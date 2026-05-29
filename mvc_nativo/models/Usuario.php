<?php
class Usuario {
    public function registrar(array $datos): int {
        $db   = Database::getConnection();
        $hash = password_hash($datos['password'], PASSWORD_BCRYPT);
        $stmt = $db->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );
        $stmt->execute([$datos['name'], $datos['email'], $hash]);
        return (int) $db->lastInsertId();
    }

    public function login(string $email, string $password): array|false {
        $db   = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        return false;
    }

    public function buscarPorId(int $id): array|false {
        $db   = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
