<?php
class TareaController {
    public function index(): void {
        Auth::requireLogin();
        $user        = Auth::getUser();
        $tareaModel  = new Tarea();
        $tareas      = $tareaModel->obtenerPorUsuario($user['id']);
        require_once __DIR__ . '/../views/tareas/index.php';
    }

    public function mostrarCrear(): void {
        Auth::requireLogin();
        require_once __DIR__ . '/../views/tareas/crear.php';
    }

    public function procesarCrear(): void {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=tarea&action=mostrarCrear');
            exit;
        }

        $titulo      = trim($_POST['titulo']      ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $estado      = $_POST['estado']           ?? 'pendiente';

        $validator = new Validator();
        $validator->requerido($titulo, 'título');
        $validator->maxLength($titulo, 'título', 255);

        if ($validator->tieneErrores()) {
            $errores = $validator->getErrores();
            require_once __DIR__ . '/../views/tareas/crear.php';
            return;
        }

        $user       = Auth::getUser();
        $tareaModel = new Tarea();
        $tareaModel->crear([
            'user_id'     => $user['id'],
            'titulo'      => $titulo,
            'descripcion' => $descripcion ?: null,
            'estado'      => in_array($estado, ['pendiente', 'completada']) ? $estado : 'pendiente',
        ]);

        $_SESSION['flash_success'] = 'Tarea creada correctamente.';
        header('Location: ?controller=tarea&action=index');
        exit;
    }

    public function mostrarEditar(): void {
        Auth::requireLogin();
        $user       = Auth::getUser();
        $id         = (int) ($_GET['id'] ?? 0);
        $tareaModel = new Tarea();
        $tarea      = $tareaModel->obtenerPorId($id, $user['id']);

        if (!$tarea) {
            $_SESSION['flash_error'] = 'Tarea no encontrada.';
            header('Location: ?controller=tarea&action=index');
            exit;
        }

        require_once __DIR__ . '/../views/tareas/editar.php';
    }

    public function procesarEditar(): void {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=tarea&action=index');
            exit;
        }

        $id          = (int) ($_POST['id']          ?? 0);
        $titulo      = trim($_POST['titulo']         ?? '');
        $descripcion = trim($_POST['descripcion']    ?? '');
        $estado      = $_POST['estado']              ?? 'pendiente';
        $user        = Auth::getUser();

        $validator = new Validator();
        $validator->requerido($titulo, 'título');
        $validator->maxLength($titulo, 'título', 255);

        if ($validator->tieneErrores()) {
            $errores    = $validator->getErrores();
            $tareaModel = new Tarea();
            $tarea      = $tareaModel->obtenerPorId($id, $user['id']);
            require_once __DIR__ . '/../views/tareas/editar.php';
            return;
        }

        $tareaModel = new Tarea();
        $actualizado = $tareaModel->actualizar($id, $user['id'], [
            'titulo'      => $titulo,
            'descripcion' => $descripcion ?: null,
            'estado'      => in_array($estado, ['pendiente', 'completada']) ? $estado : 'pendiente',
        ]);

        if (!$actualizado) {
            $_SESSION['flash_error'] = 'No se pudo actualizar la tarea.';
        } else {
            $_SESSION['flash_success'] = 'Tarea actualizada correctamente.';
        }

        header('Location: ?controller=tarea&action=index');
        exit;
    }

    public function eliminar(): void {
        Auth::requireLogin();
        $user       = Auth::getUser();
        $id         = (int) ($_GET['id'] ?? 0);
        $tareaModel = new Tarea();
        $tareaModel->eliminar($id, $user['id']);

        $_SESSION['flash_success'] = 'Tarea eliminada correctamente.';
        header('Location: ?controller=tarea&action=index');
        exit;
    }

    public function actualizarEstado(): void {
        Auth::requireLogin();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        $id     = (int) ($_POST['id']     ?? 0);
        $estado = $_POST['estado']        ?? '';
        $user   = Auth::getUser();

        if ($id <= 0 || !in_array($estado, ['pendiente', 'completada'])) {
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            exit;
        }

        $tareaModel = new Tarea();
        $ok = $tareaModel->actualizarEstado($id, $user['id'], $estado);

        echo json_encode(['success' => $ok, 'estado' => $estado]);
        exit;
    }
}
