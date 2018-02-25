A simple PHP library for building a mysql query easily with builder pattern. Easy to use with just a PHP class.
### Example
```php
<?php
    include 'QueryBuilder.php';
    $qb = QueryBuilder::new()
        ->connect()
        ->prepare('SELECT username, password FROM users WHERE id < ?')
        ->param('i', 3)
        ->result($username, $password)
        ->go()
        ->doeach(function($username, $password) {
            echo("$username -> $password");
        })
        ->prepare('INSERT INTO users (username, password) VALUES (?, ?)')
        ->param('ss', 'someone', '12345678')
        ->go()
        ->prepare('SELECT * FROM users WHERE username = ?')
        ->param('s', 'someone')
        ->result($id, $username, $password, $email, $fullname)
        ->go()
        ->doeach(function($id, $username, $password, $email, $fullname) {
            echo("$id $username $password $email $fullname");
        });
```