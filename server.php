#!/usr/bin/php -q
<?php
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$connectionData = getopt('ip:port:', ['ip:', 'port:']);

if (empty($connectionData) || !isset($connectionData['ip']) || !isset($connectionData['port'])) {
    exit("Invalid ip or port\n");
}

$ip   = $connectionData['ip'];
$port = $connectionData['port'];

set_time_limit(0);
ob_implicit_flush();

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "Create failed, reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $ip, $port) === false) {
    echo "Bind failed, reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock) === false) {
    echo "Listen failed, reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

$bracket = new Koind\Brackets();

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "Accept failed, reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }

    $msg = "\nWelcome to the brace checking server.\n To quit, type 'quit'. \n";

    socket_write($msgsock, $msg, strlen($msg));

    do {
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
            echo "failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }

        if (!$buf = trim($buf)) {
            continue;
        }

        if ($buf == 'quit') {
            break;
        }

        try {
            $talkback = $bracket->checkString($buf) ? 'Brackets is correct' : 'Brackets is not correct';
        } catch (\InvalidArgumentException $e) {
            $talkback = $e->getMessage();
        }

        socket_write($msgsock, $talkback, strlen($talkback));

        echo "$buf\n";
    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);