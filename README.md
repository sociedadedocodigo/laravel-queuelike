# laravel-queuelike
Possibilita a chamada das queues utilizando um pedaço do nome da queue. Exemplo:
php artisan queue:work database --queue='email-com-id%' --sleep=3 --tries=3 --daemon

Trata-se de uma extensão de um recurso existente no Laravel. Então, qualquer atualziação realizada no recurso (desde que não seja nas funções de pesquisa no banco), serão reconhecidas pelo pacote.
