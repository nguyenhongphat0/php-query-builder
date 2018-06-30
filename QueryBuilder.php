<?php

include 'config.php';

class QueryBuilder {
    public $con, $pre, $res;

    public static function new() : QueryBuilder {
      return new QueryBuilder();
    }

    public function connect() : QueryBuilder {
        $this->con = new mysqli(host, username, password, database);
        if ($this->con->connect_errno) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        return $this;
    }

    public function prepare($sql) : QueryBuilder {
        $this->pre = $this->con->prepare($sql);
        echo $this->con->prepare($sql) == false;
        return $this;
    }

    public function param($s, ...$params) : QueryBuilder {
        $this->pre->bind_param($s, ...$params);
        return $this;
    }

    public function result(&...$results) : QueryBuilder
    {
        $this->pre->bind_result(...$results);
        $this->res = $results;
        return $this;
    }

    public function go() : QueryBuilder
    {
        $this->pre->execute();
        return $this;
    }

    public function each($func) : QueryBuilder {
        while ($this->pre->fetch()) {
            $func(...$this->res);
        }
        return $this;
    }
    
    public function query($sql) : QueryBuilder {
        $this->res = $this->con->query($sql);
        return $this;
    }
    
    public function success(&$success) : QueryBuilder {
        $success = $this->res;
        return $this;
    }
    
    public function assoc($func) : QueryBuilder {
        while ($row = $this->res->fetch_assoc()) {
            $func($row);
        }
        return $this;
    }
}
