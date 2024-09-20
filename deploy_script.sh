#!/bin/bash
source .env

REMOTE_PASSWORD=$REMOTE_PASSWORD
REMOTE_IP=$REMOTE_IP

if [ "$1" = "--local" ]; then
    git checkout main
    git pull
    docker compose down -v
    docker compose up --build -d
    sleep 5
    docker exec -i opencmf-bdd-1 psql -U "$POSTGRES_USER" -d postgres < www/Core/bdd.sql
    cd www
    composer install
    cd framework
    npm run build
else
sshpass -p "$REMOTE_PASSWORD" ssh root@$REMOTE_IP <<EOF 
    cd OpenCMF
    git pull
    docker compose down -v
    docker compose up --build -d
    sleep 5
    ./create_database.sh "$POSTGRES_USER" "$POSTGRES_PASSWORD"
    docker exec -i opencmf-bdd-1 psql -U "$POSTGRES_USER" -d postgres < www/Core/bdd.sql
    cd www
    composer install
    cd framework
    npm i
    npm run build
    exit
EOF
fi