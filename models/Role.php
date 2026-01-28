<?php
class Role {
  public static function all(){
    return DB::conn()->query("SELECT * FROM roles ORDER BY id")->fetchAll();
  }
}
