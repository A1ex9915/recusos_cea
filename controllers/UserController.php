<?php
class UserController {

  private function guardAdmin(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user'])) {
      header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login'); exit;
    }
    if ((int)$_SESSION['user']['rol_id'] !== 1){
      http_response_code(403); exit('No autorizado');
    }
  }

  /** Renderiza dentro del layout principal (dashboard.php) usando $_SESSION['vista'] */
  private function renderVista(string $vistaRelativa, array $vars = []){
    if ($vars) extract($vars, EXTR_SKIP);
    $_SESSION['vista'] = $vistaRelativa;                              // p.ej. 'users/index.php'
    require dirname(__DIR__) . '/views/dashboard.php';
    return null;
  }

  public function index(){
    $this->guardAdmin();
    $usuarios = User::all();                                          // Debe traer rol como 'rol'
    return $this->renderVista('users/index.php', compact('usuarios'));
  }

  public function create(){
  $this->guardAdmin();
  $roles = Role::all();
  return $this->renderVista('users/create.php', compact('roles'));
}


  public function store(){
    $this->guardAdmin();

    $data = [
      'nombre'   => trim($_POST['nombre'] ?? ''),
      'email'    => trim($_POST['email'] ?? ''),
      // Modo pruebas: texto plano en el campo password_hash
      'password' => $_POST['password'] ?? '',
      'rol_id'   => (int)($_POST['rol_id'] ?? 0),
      'activo'   => isset($_POST['activo']) ? 1 : 0,
    ];

    // Normaliza para el modelo (usa la misma columna password_hash)
    $_POST['password_hash'] = $data['password'];

    User::create([
      'nombre'        => $data['nombre'],
      'email'         => $data['email'],
      'password_hash' => $data['password'],
      'rol_id'        => $data['rol_id'],
      'activo'        => $data['activo'],
    ]);

    header('Location: ' . BASE_URI . '/index.php?controller=users&action=index'); exit;
  }

  public function edit(){
    $this->guardAdmin();
    $id       = (int)($_GET['id'] ?? 0);
    $usuario  = User::find($id);
    if (!$usuario){ header('Location: ' . BASE_URI . '/index.php?controller=users&action=index'); exit; }
    $roles    = Role::all();
    return $this->renderVista('users/form.php', compact('usuario','roles'));
  }

  public function update(){
    $this->guardAdmin();

    $id = (int)($_POST['id'] ?? 0);
    if (!$id){ header('Location: ' . BASE_URI . '/index.php?controller=users&action=index'); exit; }

    $data = [
      'nombre' => trim($_POST['nombre'] ?? ''),
      'email'  => trim($_POST['email'] ?? ''),
      'rol_id' => (int)($_POST['rol_id'] ?? 0),
      'activo' => isset($_POST['activo']) ? 1 : 0,
    ];

    // Si envían contraseña, actualízala (modo pruebas: texto plano)
    if (!empty($_POST['password'])) {
      $data['password_hash'] = $_POST['password'];
    }

    User::update($id, $data);

    header('Location: ' . BASE_URI . '/index.php?controller=users&action=index'); exit;
  }

  public function destroy(){
    $this->guardAdmin();
    $id = (int)($_POST['id'] ?? 0);
    if ($id) { User::delete($id); }
    header('Location: ' . BASE_URI . '/index.php?controller=users&action=index'); exit;
  }
}
