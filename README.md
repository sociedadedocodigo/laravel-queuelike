# laravel-queuelike
Possibilita a chamada das queues utilizando um pedaço do nome da queue. Exemplo:
php artisan queue:work database --queue='email-com-id%' --sleep=3 --tries=3 --daemon
