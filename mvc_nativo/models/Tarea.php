<?php
class Tarea {
    public function crear(array $datos): int {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO tareas (user_id, titulo, descripcion, estado)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $datos['user_id'],
            $datos['titulo'],
            $datos['descripcion'] ?? null,
            $datos['estado'] ?? 'pendiente',
        ]);
        return (int) $db->lastInsertId();
    }

    public function obtenerPorUsuario(int $user_id): array {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "SELECT * FROM tareas WHERE user_id = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id, int $user_id): array|false {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "SELECT * FROM tareas WHERE id = ? AND user_id = ? LIMIT 1"
        );
        $stmt->execute([$id, $user_id]);
        return $stmt->fetch();
    }

    public function actualizar(int $id, int $user_id, array $datos): bool {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "UPDATE tareas
             SET titulo = ?, descripcion = ?, estado = ?, updated_at = NOW()
             WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([
            $datos['titulo'],
            $datos['descripcion'] ?? null,
            $datos['estado'],
            $id,
            $user_id,
        ]);
    }

    public function actualizarEstado(int $id, int $user_id, string $estado): bool {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "UPDATE tareas SET estado = ?, updated_at = NOW() WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$estado, $id, $user_id]);
    }

    public function eliminar(int $id, int $user_id): bool {
        $db   = Database::getConnection();
        $stmt = $db->prepare(
            "DELETE FROM tareas WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$id, $user_id]);
    }
}
