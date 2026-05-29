<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="form-card">

    <a href="?controller=tarea&action=index" class="btn-back">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>

    <div class="card">
        <div class="card-header-bar">
            <h5><i class="bi bi-pencil-square me-1"></i> Editar tarea</h5>
            <span class="count-badge" style="background:#f0fdf4;color:#059669">ID #<?= (int) $tarea['id'] ?></span>
        </div>
        <div style="padding:1.75rem">
            <form method="POST" action="?controller=tarea&action=procesarEditar" novalidate>
                <input type="hidden" name="id" value="<?= (int) $tarea['id'] ?>">

                <div class="mb-3">
                    <label for="titulo" class="form-label">
                        Título <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        class="form-control <?= isset($errores['título']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($_POST['titulo'] ?? $tarea['titulo']) ?>"
                        placeholder="Título de la tarea…"
                        maxlength="255"
                        required
                    >
                    <?php if (isset($errores['título'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errores['título']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">
                        Descripción
                        <span class="text-muted fw-normal" style="font-size:.78rem">(opcional)</span>
                    </label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        class="form-control"
                        rows="4"
                        placeholder="Agrega más detalles…"
                    ><?= htmlspecialchars($_POST['descripcion'] ?? $tarea['descripcion'] ?? '') ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select id="estado" name="estado" class="form-select">
                        <?php $estadoActual = $_POST['estado'] ?? $tarea['estado']; ?>
                        <option value="pendiente"  <?= $estadoActual === 'pendiente'  ? 'selected' : '' ?>>⏳ Pendiente</option>
                        <option value="completada" <?= $estadoActual === 'completada' ? 'selected' : '' ?>>✅ Completada</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-submit" style="width:auto;flex:1">
                        <i class="bi bi-floppy"></i> Guardar cambios
                    </button>
                    <a href="?controller=tarea&action=index" class="btn-action edit" style="padding:.6rem 1rem;font-size:.875rem">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

    <?php if (!empty($tarea['updated_at'])): ?>
        <p class="text-center mt-3" style="font-size:.75rem;color:var(--muted)">
            <i class="bi bi-clock-history me-1"></i>
            Última actualización: <?= date('d/m/Y H:i', strtotime($tarea['updated_at'])) ?>
        </p>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
