<?php
include 'QueryBuilder.php';

class Model {
    public static $table_name = '';
    public static $columns = [];
    public $values = [];
    
    function __construct($param) {
        foreach (static::$columns as $column) {
            $this->values[$column] = $param[$column];
        }
//         $this->values = $param;
    }
    static function SelectStament() : string {
        return "SELECT * FROM ".static::$table_name;
    }
    function InsertStament() : string {
        return "INSERT INTO ".static::$table_name." (".implode(",", static::$columns).")"." VALUES (".implode(",", array_map(function($v) { return "'".$v."'"; }, $this->values)).")";
    }
    function UpdateStament() : string {
        $params = [];
        foreach (static::$columns as $column) {
            $params[] = $column."='".$this->values[$column]."'";
        }
        return "UPDATE ".static::$table_name." SET ".implode(",", $params)." WHERE ".static::$columns[0]."='".$this->values[static::$columns[0]]."'";
    }
    function DeleteStament() : string {
        return "DELETE FROM ".static::$table_name." WHERE ".static::$columns[0]."='".$this->values[static::$columns[0]]."'";
    }
    function FindStament() : string {
        return static::SelectStament()." WHERE ".static::$columns[0]."='".$this->values[static::$columns[0]]."'";
    }
    
    static function all() {
        $list = [];
        QueryBuilder::new()
        ->connect()
        ->query(static::SelectStament())
        ->assoc(function($res) use (&$list) {
            $list[] = $res;
        });
        return $list;
    }
    
    function find() {
        QueryBuilder::new()
        ->connect()
        ->query($this->FindStament())
        ->assoc(function($res) use (&$list) {
            $this->values = $res;
        });
        return $this;
    }
    
    function insert() {
        QueryBuilder::new()
        ->connect()
        ->query($this->InsertStament())
        ->success($success);
        return $success;
    }
    
    function update() {
        QueryBuilder::new()
        ->connect()
        ->query($this->UpdateStament())
        ->success($success);
        return $success;
    }
    
    function delete() {
        QueryBuilder::new()
        ->connect()
        ->query($this->DeleteStament())
        ->success($success);
        return $success;
    }
}?>