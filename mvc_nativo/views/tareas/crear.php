<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="form-card">

    <a href="?controller=tarea&action=index" class="btn-back">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>

    <div class="card">
        <div class="card-header-bar">
            <h5><i class="bi bi-plus-circle me-1"></i> Nueva tarea</h5>
        </div>
        <div style="padding:1.75rem">
            <form method="POST" action="?controller=tarea&action=procesarCrear" novalidate>

                <div class="mb-3">
                    <label for="titulo" class="form-label">
                        Título <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        class="form-control <?= isset($errores['título']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                        placeholder="Ej. Revisar informe mensual…"
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
                        placeholder="Agrega más detalles sobre la tarea…"
                    ><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="estado" class="form-label">Estado inicial</label>
                    <select id="estado" name="estado" class="form-select">
                        <option value="pendiente"  <?= ($_POST['estado'] ?? 'pendiente') === 'pendiente'  ? 'selected' : '' ?>>
                            ⏳ Pendiente
                        </option>
                        <option value="completada" <?= ($_POST['estado'] ?? '')           === 'completada' ? 'selected' : '' ?>>
                            ✅ Completada
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-floppy"></i> Guardar tarea
                </button>

            </form>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
