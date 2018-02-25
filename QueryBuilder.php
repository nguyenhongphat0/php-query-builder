<?php

include 'config.php';

class QueryBuilder {
    public $con, $pre;

    public static function new() {
      return new QueryBuilder();
    }

    public function connect() {
        $this->con = new mysqli(host, username, password, database);
        return $this;
    }

    public function prepare($sql) {
        $this->pre = $this->con->prepare($sql);
        return $this;
    }

    public function param($s, ...$params) {
        $this->pre->bind_param($s, ...$params);
        return $this;
    }

    public function result(&...$results)
    {
        $this->pre->bind_result(...$results);
        return $this;
    }

    public function go()
    {
        $this->pre->execute();
        return $this;
    }

    public function fetch()
    {
        return $this->pre->fetch();
    }
}
