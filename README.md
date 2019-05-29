# tcp-api-brackets

Small TCP server for validation of brackets. Uses package `koind/brackets`

Init
-
```
composer install
```

Start tcp server
-
```
./server.php --ip 127.0.0.1 --port 8080
```

Connection on client side
-
```
telnet 127.0.0.1 8080
```

Validation of brackets
-
```
(()()()()))((((()()()))(()()()(((()))))))
```