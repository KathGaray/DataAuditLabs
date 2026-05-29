<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php
$flash = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_success']);
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_error']);
?>

<?php if ($flash): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($flash) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($flashError): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($flashError) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Mis tareas</h2>
    <a href="?controller=tarea&action=mostrarCrear" class="btn btn-primary">+ Nueva tarea</a>
</div>

<?php if (empty($tareas)): ?>
    <div class="alert alert-info">No tienes tareas aún. ¡Crea tu primera tarea!</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?= htmlspecialchars($tarea['titulo']) ?></td>
                        <td><?= htmlspecialchars($tarea['descripcion'] ?? '—') ?></td>
                        <td>
                            <?php if ($tarea['estado'] === 'completada'): ?>
                                <span id="badge-<?= $tarea['id'] ?>" class="badge bg-success">Completada</span>
                            <?php else: ?>
                                <span id="badge-<?= $tarea['id'] ?>" class="badge bg-warning text-dark">Pendiente</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button
                                class="btn btn-sm btn-outline-primary me-1 toggle-estado"
                                data-id="<?= $tarea['id'] ?>"
                                data-estado="<?= htmlspecialchars($tarea['estado']) ?>"
                            >
                                <?= $tarea['estado'] === 'pendiente' ? 'Marcar completada' : 'Marcar pendiente' ?>
                            </button>
                            <a href="?controller=tarea&action=mostrarEditar&id=<?= $tarea['id'] ?>"
                               class="btn btn-sm btn-outline-secondary me-1">Editar</a>
                            <a href="?controller=tarea&action=eliminar&id=<?= $tarea['id'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Eliminar esta tarea?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<script>
document.querySelectorAll('.toggle-estado').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var tareaId      = this.dataset.id;
        var estadoActual = this.dataset.estado;
        var nuevoEstado  = estadoActual === 'pendiente' ? 'completada' : 'pendiente';
        var self         = this;

        fetch('?controller=tarea&action=cambiarEstadoAjax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: 'tarea_id=' + tareaId + '&estado=' + nuevoEstado
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                self.dataset.estado = nuevoEstado;
                var badge = document.getElementById('badge-' + tareaId);
                if (nuevoEstado === 'completada') {
                    badge.className      = 'badge bg-success';
                    badge.textContent    = 'Completada';
                    self.textContent     = 'Marcar pendiente';
                } else {
                    badge.className      = 'badge bg-warning text-dark';
                    badge.textContent    = 'Pendiente';
                    self.textContent     = 'Marcar completada';
                }
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
