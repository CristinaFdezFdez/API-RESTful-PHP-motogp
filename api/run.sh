ip=$(hostname -I | xargs)
php -S $ip:8000
