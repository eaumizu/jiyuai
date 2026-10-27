#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
python3 - <<'PYENV'
from pathlib import Path
import secrets
p = Path('.env')
if not p.exists():
    import os
    with os.fdopen(os.open(p, os.O_WRONLY | os.O_CREAT | os.O_EXCL, 0o600), 'w') as f:
        f.write('DB_PASSWORD=' + secrets.token_hex(24) + '\n')
        f.write('DB_ROOT_PASSWORD=' + secrets.token_hex(24) + '\n')
        f.write('WP_ADMIN_PASSWORD=' + secrets.token_urlsafe(30) + '\n')
PYENV
docker compose pull db wordpress cli
