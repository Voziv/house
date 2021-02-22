#!/bin/bash
####
#### Description: Restores a backup file
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

if [ -z "$1" ]; then
    echo "[!!ERROR!!] You must provide a filename"
    exit 1
fi

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

backup_file="/backups/$1"
local_backup_file="${__root}/tmp/backups/$1"

if [ ! -f "$local_backup_file" ]; then
    echo "[!!ERROR!!] Backup file '$backup_file' not found in ${__root}/tmp/backups"
    ls -lah "${__root}/tmp/backups"
    exit 1
fi

docker-compose --file="${__root}/docker-compose.yml" exec postgres bash -c "
    PGPASSWORD=\"$database_pass\" \
        psql \
            --username=\"${database_user}\" \
            --host=\"${database_host}\" \
            --port=\"${database_port}\" \
            \"${database_name}\" \
            -c 'SELECT timescaledb_pre_restore();'
"

docker-compose --file="${__root}/docker-compose.yml" exec postgres bash -c "
    PGPASSWORD=\"$database_pass\" \
        pg_restore \
        --format=custom \
        --dbname=\"${database_name}\" \
        --username=\"${database_user}\" \
        --host=\"${database_host}\" \
        --port=\"${database_port}\" \
        \"${backup_file}\"
"

docker-compose --file="${__root}/docker-compose.yml" exec postgres bash -c "
    PGPASSWORD=\"$database_pass\" \
        psql \
            --username=\"${database_user}\" \
            --host=\"${database_host}\" \
            --port=\"${database_port}\" \
            \"${database_name}\" \
            -c 'SELECT timescaledb_post_restore();'
"
