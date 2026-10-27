#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
if [ ! -f .env ]; then bash scripts/setup.sh; fi
set -a
source .env
set +a
docker compose up -d --wait --wait-timeout 180 db wordpress
for attempt in $(seq 1 60); do
  if docker compose exec -T wordpress test -f /var/www/html/wp-config.php; then break; fi
  sleep 1
done
if ! docker compose run --rm -T cli wp core is-installed; then
  docker compose run --rm -T cli wp core install \
    --url=http://localhost:8080 --title=JiyuAI --admin_user=jiyuai_admin \
    --admin_email=admin@example.test --skip-email --admin_password="$WP_ADMIN_PASSWORD"
fi
docker compose run --rm -T cli wp plugin activate jiyuai-app
docker compose run --rm -T cli wp eval-file /opt/jiyuai/initialize.php
python3 scripts/smoke.py
