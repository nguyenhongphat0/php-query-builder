### Example
```php
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
```
Even more simple when the statement doesn't return anything

```php
<?php
    include 'QueryBuilder.php';
    QueryBuilder::new()
        ->connect()
        ->prepare('INSERT INTO users (username, password) VALUES (?, ?)')
        ->param('ss', 'someone', '12345678')
        ->go();
```