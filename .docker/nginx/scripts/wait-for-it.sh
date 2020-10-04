#!/usr/bin/env bash

containers=( "web:3000" )
#containers=( "web:3000" "engine:8080" "graphql:5000/health" "api:8080/api" )

for CONTAINER in "${containers[@]}"; do
  until [[ "$(curl -s -o /dev/null -w '%{http_code}' http://$CONTAINER)" =~ ^(200|301) ]]; do
    >&2 echo "Container \"$CONTAINER\" is unavailable - sleeping"
    sleep 3
  done
  >&2 echo "Container \"$CONTAINER\" is running"
done

>&2 echo "Application is up!!!"
exec "$@" 
