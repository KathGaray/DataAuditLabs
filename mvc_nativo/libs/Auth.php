<?php
class Auth {
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user']);
    }

    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: ?controller=auth&action=mostrarLogin');
            exit;
        }
    }

    public static function getUser(): ?array {
        return $_SESSION['user'] ?? null;
    }

    public static function login(array $user): void {
        $_SESSION['user'] = $user;
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
        header('Location: ?controller=auth&action=mostrarLogin');
        exit;
    }
}
