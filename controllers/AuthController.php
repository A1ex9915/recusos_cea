<?php
class AuthController {
  private function saludoPorHorario(string $nombre): string {
    $hora = (int)date('G');

    if ($hora < 12) {
      return "Buenos días, {$nombre}. Bienvenid@ al sistema.";
    }

    if ($hora < 19) {
      return "Buenas tardes, {$nombre}. Bienvenid@ al sistema.";
    }

    return "Buenas noches, {$nombre}. Bienvenid@ al sistema.";
  }

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

    // Verificar credenciales — log si falla
    if (!$user || !password_verify($pass, $user['password_hash'] ?? '') || !($user['activo'] ?? 0)) {
        Bitacora::registrar('login_fallido', 'auth', 'Intento de acceso fallido', [
            'email_intento' => $email,
            'ip'            => $_SERVER['REMOTE_ADDR'] ?? null,
        ]);
        $_SESSION['flash'] = 'Credenciales inválidas';
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    // Login exitoso
    $_SESSION['user'] = [
        'id'          => $user['id'],
        'nombre'      => $user['nombre'],
        'email'       => $user['email'],
        'rol_id'      => $user['rol_id'],
        'foto_perfil' => $user['foto_perfil'] ?? '',
    ];

    $_SESSION['flash_saludo'] = $this->saludoPorHorario($user['nombre']);
    Bitacora::registrar('login', 'auth', 'Inicio de sesión exitoso', [
        'email' => $user['email'],
    ]);

    header('Location: index.php?controller=dashboard&action=inicio');
    exit;
}


  public function logout(){
    if (!empty($_SESSION['user'])) {
      Bitacora::registrar('logout', 'auth', 'Cierre de sesión', [
        'email' => $_SESSION['user']['email'] ?? null
      ]);
    }

    session_destroy();
    header('Location: index.php?controller=auth&action=login'); exit;
  }
}
