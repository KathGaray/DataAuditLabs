<?php
class AuthController {
    public function mostrarRegistro(): void {
        require_once __DIR__ . '/../views/auth/registro.php';
    }

    public function procesarRegistro(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=auth&action=mostrarRegistro');
            exit;
        }

        $name      = trim($_POST['name']              ?? '');
        $email     = trim($_POST['email']             ?? '');
        $password  = $_POST['password']               ?? '';
        $confirmar = $_POST['confirmar_password']     ?? '';

        $validator = new Validator();
        $validator->requerido($name,      'nombre');
        $validator->requerido($email,     'email');
        $validator->email($email,         'email');
        $validator->requerido($password,  'contraseña');
        $validator->minLength($password,  'contraseña', 6);
        $validator->coinciden($password, $confirmar, 'confirmar contraseña');

        if ($validator->tieneErrores()) {
            $errores = $validator->getErrores();
            require_once __DIR__ . '/../views/auth/registro.php';
            return;
        }

        $usuarioModel = new Usuario();
        $usuarioModel->registrar([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ]);

        $_SESSION['flash_success'] = 'Registro exitoso. Ahora puedes iniciar sesión.';
        header('Location: ?controller=auth&action=mostrarLogin');
        exit;
    }

    public function mostrarLogin(): void {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function procesarLogin(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=auth&action=mostrarLogin');
            exit;
        }

        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';

        $validator = new Validator();
        $validator->requerido($email,    'email');
        $validator->email($email,        'email');
        $validator->requerido($password, 'contraseña');

        if ($validator->tieneErrores()) {
            $errores = $validator->getErrores();
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->login($email, $password);

        if (!$usuario) {
            $errores = ['login' => 'Credenciales incorrectas. Intenta de nuevo.'];
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        Auth::login([
            'id'    => $usuario['id'],
            'name'  => $usuario['name'],
            'email' => $usuario['email'],
        ]);

        header('Location: ?controller=tarea&action=index');
        exit;
    }

    public function logout(): void {
        Auth::logout();
    }
}
