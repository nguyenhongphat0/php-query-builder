<?php
include 'QueryBuilder.php';

class Model {
    public static $table = '';
    public static $columns = [];
    public $values = [];
    
    function __construct($param) {
        foreach (static::$columns as $column) {
            $this->values[$column] = $param[$column];
        }
//         $this->values = $param;
    }
    static function SelectStatement() : string {
        return "SELECT * FROM ".static::$table;
    }
    function InsertStatement() : string {
        return "INSERT INTO ".static::$table." (".implode(",", static::$columns).")"." VALUES (".implode(",", array_map(function($v) { return "'".$v."'"; }, $this->values)).")";
    }
    function UpdateStatement() : string {
        $params = [];
        foreach (static::$columns as $column) {
            $params[] = $column."='".$this->values[$column]."'";
        }
        return "UPDATE ".static::$table." SET ".implode(",", $params)." WHERE ".static::$columns[0]."='".$this->values[static::$columns[0]]."'";
    }
    function DeleteStatement() : string {
        return "DELETE FROM ".static::$table." WHERE ".static::$columns[0]."='".$this->values[static::$columns[0]]."'";
    }
    function FindStatement() : string {
        return static::SelectStatement()." WHERE ".static::$columns[0]."='".$this->values[static::$columns[0]]."'";
    }
    
    static function all() {
        $list = [];
        QueryBuilder::new()
        ->connect()
        ->query(static::SelectStatement())
        ->assoc(function($res) use (&$list) {
            $list[] = $res;
        });
        return $list;
    }
    
    function find() {
        QueryBuilder::new()
        ->connect()
        ->query($this->FindStatement())
        ->assoc(function($res) use (&$list) {
            $this->values = $res;
        });
        return $this;
    }
    
    function insert() {
        QueryBuilder::new()
        ->connect()
        ->query($this->InsertStatement())
        ->success($success);
        return $success;
    }
    
    function update() {
        QueryBuilder::new()
        ->connect()
        ->query($this->UpdateStatement())
        ->success($success);
        return $success;
    }
    
    function delete() {
        QueryBuilder::new()
        ->connect()
        ->query($this->DeleteStatement())
        ->success($success);
        return $success;
    }
}?>