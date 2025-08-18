#!/bin/bash
# wait-for-db.sh

host="$1"
port="$2"
shift 2
cmd="$@"

# MySQL이 사용 가능해질 때까지 기다립니다.
until nc -z "$host" "$port"; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

>&2 echo "MySQL is up - executing command"
exec $cmd