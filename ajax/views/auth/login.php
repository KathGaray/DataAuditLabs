<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-4">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Iniciar sesión</h2>

                <?php
                $flash = $_SESSION['flash_success'] ?? null;
                unset($_SESSION['flash_success']);
                if ($flash): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
                <?php endif; ?>

                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errores as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="?controller=auth&action=procesarLogin" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required
                        >
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    ¿No tienes cuenta?
                    <a href="?controller=auth&action=mostrarRegistro">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
