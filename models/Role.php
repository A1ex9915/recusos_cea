<?php
class Role {
  public static function all(){
    return DB::conn()->query("SELECT * FROM roles ORDER BY id")->fetchAll();
  }

  public static function find($id){
    $st = DB::conn()->prepare("SELECT * FROM roles WHERE id = ?");
    $st->execute([$id]);
    return $st->fetch();
  }
}
