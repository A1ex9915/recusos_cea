<?php
class User {
  public static function findByEmail($email){
    $st = DB::conn()->prepare("SELECT * FROM usuarios WHERE email = ?");
    $st->execute([$email]);
    return $st->fetch();
  }
  public static function all(){
    $sql = "SELECT u.*, r.nombre AS rol FROM usuarios u JOIN roles r ON r.id=u.rol_id ORDER BY u.id DESC";
    return DB::conn()->query($sql)->fetchAll();
  }
  public static function find($id){
    $st = DB::conn()->prepare("SELECT * FROM usuarios WHERE id=?");
    $st->execute([$id]);
    return $st->fetch();
  }
  public static function create($data){
    $st = DB::conn()->prepare("INSERT INTO usuarios (nombre,email,password_hash,rol_id,activo) VALUES (?,?,?,?,?)");
    return $st->execute([
      $data['nombre'], $data['email'],
      password_hash($data['password'], PASSWORD_DEFAULT),
      $data['rol_id'], isset($data['activo'])?1:0
    ]);
  }
  public static function update($id,$data){
    $fields = ['nombre = ?','email = ?','rol_id = ?','activo = ?'];
    $params = [$data['nombre'],$data['email'],$data['rol_id'], isset($data['activo'])?1:0];
    if (!empty($data['password'])){ $fields[]='password_hash = ?'; $params[] = password_hash($data['password'], PASSWORD_DEFAULT); }
    $params[] = $id;
    $sql = "UPDATE usuarios SET ".implode(',',$fields)." WHERE id = ?";
    $st = DB::conn()->prepare($sql); return $st->execute($params);
  }
  public static function delete($id){
    $st = DB::conn()->prepare("DELETE FROM usuarios WHERE id=?");
    return $st->execute([$id]);
  }
}
