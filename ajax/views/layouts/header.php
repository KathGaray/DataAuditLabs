<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataAuditLabs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="?controller=tarea&action=index">DataAuditLabs</a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <?php if (Auth::isLoggedIn()): ?>
                <span class="text-white">
                    Hola, <?= htmlspecialchars(Auth::getUser()['name']) ?>
                </span>
                <a href="?controller=auth&action=logout" class="btn btn-outline-light btn-sm">
                    Cerrar sesión
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<main class="container mt-4">
