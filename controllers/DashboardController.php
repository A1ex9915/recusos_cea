<?php
class DashboardController {

  private function renderVista(string $vistaRelativa){
    if (session_status() === PHP_SESSION_NONE) session_start();

    $_SESSION['vista'] = $vistaRelativa;

    require dirname(__DIR__) . '/views/dashboard.php';
  }

  public function inicio(){
    $this->renderVista('dashboard/inicio.php');
  }

  public function perfil() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (empty($_SESSION['user'])) {
        header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login');
        exit;
    }

    $user_id = (int) $_SESSION['user']['id'];

    $_SESSION['perfil_data'] = [
        'user_id' => $user_id
    ];

    return $this->renderVista('dashboard/perfil.php');
  }

  public function actualizarPerfil() {
    require dirname(__DIR__) . '/controllers/actualizar_perfil.php';
  }

  public function cambiarPassword() {
    require dirname(__DIR__) . '/controllers/cambiar_password.php';
  }

}
