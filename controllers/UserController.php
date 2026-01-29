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
      'nombre'           => trim($_POST['nombre'] ?? ''),
      'email'            => trim($_POST['email'] ?? ''),
      'password'         => $_POST['password'] ?? '',
      'password_confirm' => $_POST['password_confirm'] ?? '',
      'rol_id'           => (int)($_POST['rol_id'] ?? 0),
      'activo'           => isset($_POST['activo']) ? 1 : 0,
    ];

    // Array de errores
    $errores = [];

    // 1. Validar nombre
    if (strlen($data['nombre']) < 3) {
      $errores[] = 'El nombre debe tener al menos 3 caracteres';
    }

    // 2. Validar formato de email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $errores[] = 'El email no tiene un formato válido';
    }

    // 3. Verificar email único
    if (User::findByEmail($data['email'])) {
      $errores[] = 'El email ya está registrado';
    }

    // 4. Validar contraseña
    if (strlen($data['password']) < 8) {
      $errores[] = 'La contraseña debe tener mínimo 8 caracteres';
    }

    // 5. Validar confirmación de contraseña
    if ($data['password'] !== $data['password_confirm']) {
      $errores[] = 'Las contraseñas no coinciden';
    }

    // 6. Verificar que el rol existe
    if (!Role::find($data['rol_id'])) {
      $errores[] = 'El rol seleccionado no es válido';
    }

    // Si hay errores, regresar al formulario
    if (!empty($errores)) {
      $_SESSION['errores'] = $errores;
      $_SESSION['old_input'] = $data;
      header('Location: ' . BASE_URI . '/index.php?controller=users&action=create');
      exit;
    }

    // Crear usuario
    User::create([
      'nombre'   => $data['nombre'],
      'email'    => $data['email'],
      'password' => $data['password'],
      'rol_id'   => $data['rol_id'],
      'activo'   => $data['activo'],
    ]);

    $_SESSION['mensaje_exito'] = 'Usuario creado correctamente';
    header('Location: ' . BASE_URI . '/index.php?controller=users&action=index');
    exit;
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

    $usuario_actual = User::find($id);
    if (!$usuario_actual) {
      header('Location: ' . BASE_URI . '/index.php?controller=users&action=index');
      exit;
    }

    $data = [
      'nombre'           => trim($_POST['nombre'] ?? ''),
      'email'            => trim($_POST['email'] ?? ''),
      'password'         => $_POST['password'] ?? '',
      'password_confirm' => $_POST['password_confirm'] ?? '',
      'rol_id'           => (int)($_POST['rol_id'] ?? 0),
      'activo'           => isset($_POST['activo']) ? 1 : 0,
    ];

    // Array de errores
    $errores = [];

    // 1. Validar nombre
    if (strlen($data['nombre']) < 3) {
      $errores[] = 'El nombre debe tener al menos 3 caracteres';
    }

    // 2. Validar formato de email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $errores[] = 'El email no tiene un formato válido';
    }

    // 3. Verificar email único (excepto el propio usuario)
    $usuario_email = User::findByEmail($data['email']);
    if ($usuario_email && $usuario_email['id'] != $id) {
      $errores[] = 'El email ya está registrado por otro usuario';
    }

    // 4. Si envían contraseña, validarla
    if (!empty($data['password'])) {
      if (strlen($data['password']) < 8) {
        $errores[] = 'La contraseña debe tener mínimo 8 caracteres';
      }
      if ($data['password'] !== $data['password_confirm']) {
        $errores[] = 'Las contraseñas no coinciden';
      }
    }

    // 5. Verificar que el rol existe
    if (!Role::find($data['rol_id'])) {
      $errores[] = 'El rol seleccionado no es válido';
    }

    // Si hay errores, regresar al formulario
    if (!empty($errores)) {
      $_SESSION['errores'] = $errores;
      $_SESSION['old_input'] = $data;
      header('Location: ' . BASE_URI . '/index.php?controller=users&action=edit&id=' . $id);
      exit;
    }

    // Preparar datos para actualizar
    $datos_update = [
      'nombre' => $data['nombre'],
      'email'  => $data['email'],
      'rol_id' => $data['rol_id'],
      'activo' => $data['activo'],
    ];

    // Si envían contraseña, agregarla
    if (!empty($data['password'])) {
      $datos_update['password'] = $data['password'];
    }

    User::update($id, $datos_update);

    $_SESSION['mensaje_exito'] = 'Usuario actualizado correctamente';
    header('Location: ' . BASE_URI . '/index.php?controller=users&action=index');
    exit;
  }

  public function destroy(){
    $this->guardAdmin();
    $id = (int)($_POST['id'] ?? 0);
    if ($id) { User::delete($id); }
    header('Location: ' . BASE_URI . '/index.php?controller=users&action=index'); exit;
  }
}
