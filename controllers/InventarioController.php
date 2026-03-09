<?php

class InventarioController
{
    private function json(array $payload, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
        exit;
    }

    private function guard()
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login');
            exit;
        }
    }

    private function render(string $vista, array $vars = [])
    {
        extract($vars);
        $_SESSION['vista'] = $vista;
        require dirname(__DIR__) . '/views/dashboard.php';
    }

    // LISTADO PRINCIPAL DE INVENTARIO
    public function index()
    {
        $this->guard();

        $q         = $_GET['q'] ?? '';
        $recursos  = Inventario::listar($q);

        $this->render('inventario/index.php', compact('recursos', 'q'));
    }

    // FORMULARIO (ALTA / EDICIÓN)
    public function form()
    {
        $this->guard();

        $id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $recurso = $id ? Inventario::buscar($id) : null;

        // catálogos
        $categorias  = Catalogo::categorias();
        $unidades    = Catalogo::unidades();
        $organismos  = Catalogo::organismos();
        $municipios  = Catalogo::municipios();
        $proveedores = Catalogo::proveedores();
        $ubicaciones = Catalogo::ubicaciones();

        $this->render('inventario/form.php', compact(
            'recurso',
            'categorias',
            'unidades',
            'organismos',
            'municipios',
            'proveedores',
            'ubicaciones'
        ));
    }

    // GUARDAR NUEVO RECURSO (ALTA)// GUARDAR NUEVO RECURSO (ALTA)
public function store()
{
    $this->guard();

    Inventario::crear($_POST);
    Bitacora::registrar('crear', 'inventario', 'Recurso creado', [
        'clave' => $_POST['clave'] ?? null,
        'nombre' => $_POST['nombre'] ?? null
    ]);

    // MENSAJE DE CONFIRMACIÓN
    $_SESSION['flash_inv'] = "Producto guardado correctamente en el inventario.";

    header('Location: ' . BASE_URI . '/index.php?controller=inventario&action=form');
    exit;
}

// ACTUALIZAR RECURSO EXISTENTE
public function update()
{
    $this->guard();

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if ($id <= 0) {
        header('Location: ' . BASE_URI . '/index.php?controller=inventario&action=index');
        exit;
    }

    Inventario::actualizar($id, $_POST);
    Bitacora::registrar('actualizar', 'inventario', 'Recurso actualizado', [
        'recurso_id' => $id,
        'clave' => $_POST['clave'] ?? null,
        'nombre' => $_POST['nombre'] ?? null
    ]);

    // MENSAJE DE CONFIRMACIÓN
    $_SESSION['flash_inv'] = "Cambios guardados correctamente.";

    header('Location: ' . BASE_URI . '/index.php?controller=inventario&action=form&id=' . $id);
    exit;
}


    // ELIMINAR
    public function delete()
    {
        $this->guard();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            Inventario::eliminar($id);
            Bitacora::registrar('eliminar', 'inventario', 'Recurso eliminado', [
                'recurso_id' => $id
            ]);
        }

        header('Location: ' . BASE_URI . '/index.php?controller=inventario&action=index');
        exit;
    }
    

    
    public function edit()
{
    $this->guard();

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        $this->json(["error" => "ID inválido"], 400);
    }

    $recurso = Inventario::buscar($id);

    if (!$recurso) {
        $this->json(["error" => "Recurso no encontrado"], 404);
    }

    $this->json($recurso);
}

}