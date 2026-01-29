<?php
class AuthController {
  private function render($view, $params=[]){
    extract($params);
    ob_start();
    require __DIR__."/../views/$view.php";
    return ob_get_clean();
  }

  public function login(){
    if (!empty($_SESSION['user'])) { header('Location: index.php?controller=dashboard&action=inicio'); exit; }
    return $this->render('auth/login');
  }

 public function doLogin(){
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $user = User::findByEmail($email);

    // Validar con password_verify para seguridad
    if ($user && password_verify($pass, $user['password_hash']) && $user['activo']) {
        $_SESSION['user'] = [
            'id'     => $user['id'],
            'nombre' => $user['nombre'],
            'email'  => $user['email'],
            'rol_id' => $user['rol_id']
        ];

        header('Location: index.php?controller=dashboard&action=inicio');
        exit;
    }

    $_SESSION['flash'] = 'Credenciales inválidas';
    header('Location: index.php?controller=auth&action=login');
    exit;
}


  public function logout(){
    session_destroy();
    header('Location: index.php?controller=auth&action=login'); exit;
  }
}
