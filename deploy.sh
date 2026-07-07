#!/usr/bin/env bash
#
# deploy.sh — publica a branch atual no VPS via SSH.
# Config (host/usuário/caminho) fica em deploy.conf (fora do git).
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CONFIG_FILE="$SCRIPT_DIR/deploy.conf"

if [ ! -f "$CONFIG_FILE" ]; then
  echo "❌ Falta $CONFIG_FILE — copie de deploy.conf.example e preencha."
  exit 1
fi
# shellcheck disable=SC1090
source "$CONFIG_FILE"

: "${DEPLOY_HOST:?defina DEPLOY_HOST em deploy.conf}"
: "${DEPLOY_USER:?defina DEPLOY_USER em deploy.conf}"
: "${DEPLOY_PATH:?defina DEPLOY_PATH em deploy.conf}"
DEPLOY_PORT="${DEPLOY_PORT:-22}"
DEPLOY_BRANCH="${DEPLOY_BRANCH:-main}"

# 1) exigir árvore de git limpa
if [ -n "$(git status --porcelain)" ]; then
  echo "❌ Há alterações não commitadas. Commite (ou stashe) antes de publicar."
  git status --short
  exit 1
fi

# 2) garantir branch correta
CURRENT_BRANCH="$(git rev-parse --abbrev-ref HEAD)"
if [ "$CURRENT_BRANCH" != "$DEPLOY_BRANCH" ]; then
  echo "❌ Branch atual '$CURRENT_BRANCH' ≠ '$DEPLOY_BRANCH'."
  exit 1
fi

# 3) enviar commits para o GitHub
echo "➡️  git push origin $DEPLOY_BRANCH"
git push origin "$DEPLOY_BRANCH"

# 4) deploy remoto via SSH
echo "➡️  Deploy em $DEPLOY_USER@$DEPLOY_HOST:$DEPLOY_PATH (branch $DEPLOY_BRANCH)"
SSH_OPTS=(-p "$DEPLOY_PORT")
[ -n "${DEPLOY_KEY:-}" ] && SSH_OPTS+=(-i "$DEPLOY_KEY")
ssh "${SSH_OPTS[@]}" "$DEPLOY_USER@$DEPLOY_HOST" bash -s <<REMOTE
set -euo pipefail
cd "$DEPLOY_PATH"

echo "· git pull --ff-only"
git pull --ff-only origin "$DEPLOY_BRANCH"

echo "· composer install --no-dev"
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# --- descomente se um deploy precisar de migrations/assets ---
# echo "· migrate --force"; php artisan migrate --force
# echo "· npm build";      npm ci && npm run build

echo "· caches"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link 2>/dev/null || true

echo "· restart fila"
php artisan queue:restart
REMOTE

echo "✅ Deploy concluído com sucesso."
