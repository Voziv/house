#!/bin/bash
####
#### Description: Downloads the database backups from a local server.
####              Probably useless to the general public.
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

remote_server="voziv-server"
remote_file="voziv-server/house.voziv.com/backups/postgres/*.bak"
local_file="${__root}/tmp/backups"

scp "${remote_server}:${remote_file}" "${local_file}"
