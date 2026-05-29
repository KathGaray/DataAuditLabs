<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="card-title mb-4">Nueva tarea</h2>

                <form method="POST" action="?controller=tarea&action=procesarCrear" novalidate>
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            class="form-control <?= isset($errores['título']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                            required
                        >
                        <?php if (isset($errores['título'])): ?>
                            <div class="text-danger small mt-1"><?= htmlspecialchars($errores['título']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea
                            id="descripcion"
                            name="descripcion"
                            class="form-control"
                            rows="4"
                        ><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="estado" class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-select">
                            <option value="pendiente" <?= (($_POST['estado'] ?? 'pendiente') === 'pendiente') ? 'selected' : '' ?>>
                                Pendiente
                            </option>
                            <option value="completada" <?= (($_POST['estado'] ?? '') === 'completada') ? 'selected' : '' ?>>
                                Completada
                            </option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="?controller=tarea&action=index" class="btn btn-outline-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
