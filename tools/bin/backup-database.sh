#!/bin/bash
####
#### Description: Backups a postgres database
####
set -o errexit
set -o pipefail
set -o nounset
# set -o xtrace

# Set magic variables for current file & dir
__dir="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
__file="${__dir}/$(basename "${BASH_SOURCE[0]}")"
__base="$(basename ${__file} .sh)"
__root="$(cd "$(dirname "${__dir}")/.." && pwd)"

if [ ! -f "${__root}/.env" ]; then
    echo "[!!ERROR!!] Missing .env file. Please copy .env.example and update the values"
    exit 1
fi

. "${__root}/.env"

database_user="${DB_USERNAME}"
database_pass="${DB_PASSWORD}"
database_name="${DB_DATABASE}"
database_host="127.0.0.1"
database_port="5432"
filename="$(date +"%Y-%m-%d_%H-%M-%S")-house-development.bak"
backup_file="/backups/${filename}"

local_backup_file="${__root}/tmp/backups/${filename}"

if [ -f "$local_backup_file" ]; then
    echo "[!!ERROR!!] Backup file '$backup_file' already exists in ${__root}/tmp/backups/backups"
    ls -lah "${__root}/tmp/backups/backups"
    exit 1
fi

docker-compose --file="${__root}/docker-compose.yml" exec postgres bash -c "
    PGPASSWORD=\"$database_pass\" \
        pg_dump \
        --format=custom \
        --file=\"${backup_file}\" \
        --username=\"${database_user}\" \
        --host=\"${database_host}\" \
        --port=\"${database_port}\" \
        \"${database_name}\"
"
