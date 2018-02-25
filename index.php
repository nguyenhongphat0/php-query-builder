<?php
    include 'QueryBuilder.php';
    $qb = QueryBuilder::new()
        ->connect()
        ->prepare('SELECT username, password FROM users WHERE id < ?')
        ->param('i', '10')
        ->result($username, $password)
        ->go();
    while ($qb->fetch()) {
        echo("$username -> $password <br>");
    }