<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php
$flash      = $_SESSION['flash_success'] ?? null;  unset($_SESSION['flash_success']);
$flashError = $_SESSION['flash_error']   ?? null;  unset($_SESSION['flash_error']);

$total       = count($tareas);
$completadas = count(array_filter($tareas, fn($t) => $t['estado'] === 'completada'));
$pendientes  = $total - $completadas;
?>

<!-- Toast -->
<div class="toast-wrap">
    <div id="statusToast" class="toast align-items-center border-0" role="alert" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="statusToastMsg"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- Modal Ver -->
<div class="modal fade" id="modalVer" tabindex="-1" aria-labelledby="modalVerLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVerLabel" id="modalVerTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="detail-row">
                    <span class="detail-label">Estado</span>
                    <span class="detail-value" id="modalVerEstado"></span>
                </div>
                <div class="detail-row" id="modalDescRow">
                    <span class="detail-label">Descripción</span>
                    <span class="detail-value" id="modalVerDescripcion"></span>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="detail-row mb-0">
                            <span class="detail-label">Creada el</span>
                            <span class="detail-value" id="modalVerCreada"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="detail-row mb-0">
                            <span class="detail-label">Actualizada</span>
                            <span class="detail-value" id="modalVerActualizada"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="modalVerEditLink" href="#" class="btn-action edit">
                    <i class="bi bi-pencil"></i> Editar tarea
                </a>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-2" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php if ($flash): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($flash) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($flashError): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($flashError) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Page header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Mis tareas
            <small>Gestiona y organiza tus tareas pendientes</small>
        </h1>
    </div>
    <a href="?controller=tarea&action=mostrarCrear" class="btn-new">
        <i class="bi bi-plus-lg"></i> Nueva tarea
    </a>
</div>

<!-- Stats strip -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon total"><i class="bi bi-list-task"></i></div>
            <div>
                <p class="stat-label">Total</p>
                <p class="stat-value" id="stat-total"><?= $total ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon pending"><i class="bi bi-clock"></i></div>
            <div>
                <p class="stat-label">Pendientes</p>
                <p class="stat-value" id="stat-pending"><?= $pendientes ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card">
            <div class="stat-icon done"><i class="bi bi-check-circle"></i></div>
            <div>
                <p class="stat-label">Completadas</p>
                <p class="stat-value" id="stat-done"><?= $completadas ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Task table card -->
<div class="card">
    <div class="card-header-bar">
        <h5><i class="bi bi-table me-1"></i> Listado de tareas</h5>
        <?php if ($total > 0): ?>
            <span class="count-badge"><?= $total ?> <?= $total === 1 ? 'tarea' : 'tareas' ?></span>
        <?php endif; ?>
    </div>

    <?php if (empty($tareas)): ?>
        <div class="empty-state">
            <i class="bi bi-inbox empty-state-icon"></i>
            <h4>Sin tareas aún</h4>
            <p>Crea tu primera tarea para empezar a organizarte.</p>
            <a href="?controller=tarea&action=mostrarCrear" class="btn-new">
                <i class="bi bi-plus-lg"></i> Crear primera tarea
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th style="width:3rem">#</th>
                        <th>Tarea</th>
                        <th style="width:150px">Estado</th>
                        <th style="width:110px">Creada</th>
                        <th style="width:210px" class="text-end pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tareas as $i => $tarea): ?>
                        <tr>
                            <td class="row-num"><?= $i + 1 ?></td>
                            <td>
                                <div class="task-title"><?= htmlspecialchars($tarea['titulo']) ?></div>
                                <?php if (!empty($tarea['descripcion'])): ?>
                                    <div class="task-desc"><?= htmlspecialchars($tarea['descripcion']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button
                                    class="status-btn <?= $tarea['estado'] === 'completada' ? 'completada' : 'pendiente' ?>"
                                    data-id="<?= $tarea['id'] ?>"
                                    data-estado="<?= $tarea['estado'] ?>"
                                    title="Clic para cambiar estado"
                                >
                                    <?php if ($tarea['estado'] === 'completada'): ?>
                                        <i class="bi bi-check-circle-fill"></i> Completada
                                    <?php else: ?>
                                        <i class="bi bi-clock"></i> Pendiente
                                    <?php endif; ?>
                                </button>
                            </td>
                            <td>
                                <span class="date-text"><?= date('d/m/Y', strtotime($tarea['created_at'])) ?></span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action view btn-ver"
                                        data-id="<?= $tarea['id'] ?>"
                                        data-titulo="<?= htmlspecialchars($tarea['titulo'], ENT_QUOTES) ?>"
                                        data-descripcion="<?= htmlspecialchars($tarea['descripcion'] ?? '', ENT_QUOTES) ?>"
                                        data-estado="<?= $tarea['estado'] ?>"
                                        data-creada="<?= date('d/m/Y H:i', strtotime($tarea['created_at'])) ?>"
                                        data-actualizada="<?= $tarea['updated_at'] ? date('d/m/Y H:i', strtotime($tarea['updated_at'])) : '—' ?>"
                                    >
                                        <i class="bi bi-eye"></i> Ver
                                    </button>
                                    <a href="?controller=tarea&action=mostrarEditar&id=<?= $tarea['id'] ?>" class="btn-action edit">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <a href="?controller=tarea&action=eliminar&id=<?= $tarea['id'] ?>"
                                       class="btn-action delete"
                                       onclick="return confirm('¿Eliminar la tarea «<?= htmlspecialchars($tarea['titulo'], ENT_QUOTES) ?>»? Esta acción no se puede deshacer.')">
                                        <i class="bi bi-trash3"></i> Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
// ── AJAX: toggle estado ───────────────────────────────────────────────────
document.querySelectorAll('.status-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var id          = this.dataset.id;
        var estadoActual = this.dataset.estado;
        var nuevoEstado = estadoActual === 'completada' ? 'pendiente' : 'completada';
        var self        = this;

        self.classList.add('loading');

        var fd = new FormData();
        fd.append('id', id);
        fd.append('estado', nuevoEstado);

        fetch('?controller=tarea&action=actualizarEstado', { method: 'POST', body: fd })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    self.dataset.estado = nuevoEstado;
                    self.classList.remove('pendiente', 'completada', 'loading');
                    self.classList.add(nuevoEstado);
                    self.innerHTML = nuevoEstado === 'completada'
                        ? '<i class="bi bi-check-circle-fill"></i> Completada'
                        : '<i class="bi bi-clock"></i> Pendiente';

                    // Sync the "Ver" button data for this row
                    var row    = self.closest('tr');
                    var verBtn = row ? row.querySelector('.btn-ver') : null;
                    if (verBtn) verBtn.dataset.estado = nuevoEstado;

                    actualizarContadores();
                    showToast(
                        nuevoEstado === 'completada' ? 'Tarea marcada como completada ✓' : 'Tarea marcada como pendiente',
                        nuevoEstado === 'completada' ? 'success' : 'warning'
                    );
                } else {
                    self.classList.remove('loading');
                    showToast('No se pudo actualizar el estado', 'danger');
                }
            })
            .catch(function () {
                self.classList.remove('loading');
                showToast('Error de conexión', 'danger');
            });
    });
});

// ── Modal "Ver" ───────────────────────────────────────────────────────────
document.querySelectorAll('.btn-ver').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var estado    = this.dataset.estado;
        var estadoHtml = estado === 'completada'
            ? '<span class="status-btn completada" style="cursor:default;pointer-events:none"><i class="bi bi-check-circle-fill"></i> Completada</span>'
            : '<span class="status-btn pendiente"  style="cursor:default;pointer-events:none"><i class="bi bi-clock"></i> Pendiente</span>';

        document.getElementById('modalVerLabel').textContent    = this.dataset.titulo;
        document.getElementById('modalVerEstado').innerHTML      = estadoHtml;
        document.getElementById('modalVerCreada').textContent    = this.dataset.creada;
        document.getElementById('modalVerActualizada').textContent = this.dataset.actualizada;
        document.getElementById('modalVerEditLink').href          = '?controller=tarea&action=mostrarEditar&id=' + this.dataset.id;

        var desc    = this.dataset.descripcion;
        var descEl  = document.getElementById('modalVerDescripcion');
        var descRow = document.getElementById('modalDescRow');
        if (desc) {
            descEl.textContent = desc;
            descEl.classList.remove('muted');
            descRow.style.display = '';
        } else {
            descEl.textContent = 'Sin descripción';
            descEl.classList.add('muted');
            descRow.style.display = '';
        }

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalVer')).show();
    });
});

// ── Actualizar contadores de stats ────────────────────────────────────────
function actualizarContadores() {
    var btns       = document.querySelectorAll('.status-btn');
    var total      = btns.length;
    var completadas = 0;
    btns.forEach(function (b) { if (b.dataset.estado === 'completada') completadas++; });
    var pendientes = total - completadas;

    document.getElementById('stat-total').textContent   = total;
    document.getElementById('stat-pending').textContent = pendientes;
    document.getElementById('stat-done').textContent    = completadas;
}

// ── Toast helper ──────────────────────────────────────────────────────────
function showToast(msg, type) {
    var el    = document.getElementById('statusToast');
    var msgEl = document.getElementById('statusToastMsg');
    el.className = 'toast align-items-center border-0 text-bg-' + (type === 'danger' ? 'danger' : type === 'warning' ? 'warning' : 'success');
    msgEl.textContent = msg;
    bootstrap.Toast.getOrCreateInstance(el, { delay: 2800 }).show();
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
