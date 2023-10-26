>&2 echo -n "...Waiting Mysql to be up"
until echo '\q' | mysql -h mysqldb -u root --password="mysql" 2> /dev/null; do
    >&2 echo -n "."
    sleep 1
done

>&2 echo "...MySQL IS UP!"