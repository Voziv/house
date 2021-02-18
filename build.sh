#!/bin/bash

DOCKER_NODE_BUILD_FILE="./tools/docker/node/node.docker"
DOCKER_NODE_BUILD_TAG="house_node_build:latest"
BACKEND_DOCKERFILE="./tools/docker/app/app.docker"
BACKEND_DOCKER_IMAGE="gcr.io/voziv-web/house-backend"
BACKEND_DOCKER_LATEST="gcr.io/voziv-web/house-backend:latest"
FRONTEND_DOCKERFILE="./tools/docker/nginx/nginx.docker"
FRONTEND_DOCKER_IMAGE="gcr.io/voziv-web/house-frontend"
FRONTEND_DOCKER_LATEST="gcr.io/voziv-web/house-frontend:latest"
DOCKER_REGISTRY_URL="https://gcr.io"

function docker_build () {
    docker build \
        --build-arg BUILD_DATE=`TZ="America/Toronto" date +"%Y-%m-%dT%H:%M:%SZ"` \
        --build-arg VCS_REF="local" \
        --build-arg VERSION="local" \
        --tag "${1}" \
        --file "${2}" \
        .
}

docker_build "${DOCKER_NODE_BUILD_TAG}" "${DOCKER_NODE_BUILD_FILE}"
docker_build "${BACKEND_DOCKER_LATEST}" "${BACKEND_DOCKERFILE}"
#docker_build "${FRONTEND_DOCKER_LATEST}" "${FRONTEND_DOCKERFILE}"


