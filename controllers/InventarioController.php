<?php

class InventarioController
{
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
        }

        header('Location: ' . BASE_URI . '/index.php?controller=inventario&action=index');
        exit;
    }
    

    
    public function edit()
{
    $this->guard();

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        echo json_encode(["error" => "ID inválido"]);
        exit;
    }

    $recurso = Inventario::buscar($id);

    if (!$recurso) {
        echo json_encode(["error" => "Recurso no encontrado"]);
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($recurso);
    exit;
}

}