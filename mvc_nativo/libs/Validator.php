<?php
class Validator {
    private array $errores = [];

    public function requerido(string $valor, string $campo): void {
        if (trim($valor) === '') {
            $this->errores[$campo] = "El campo {$campo} es obligatorio.";
        }
    }

    public function email(string $valor, string $campo): void {
        if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
            $this->errores[$campo] = "El campo {$campo} debe ser un correo válido.";
        }
    }

    public function minLength(string $valor, string $campo, int $min): void {
        if (strlen($valor) < $min) {
            $this->errores[$campo] = "El campo {$campo} debe tener al menos {$min} caracteres.";
        }
    }

    public function maxLength(string $valor, string $campo, int $max): void {
        if (strlen($valor) > $max) {
            $this->errores[$campo] = "El campo {$campo} no puede superar {$max} caracteres.";
        }
    }

    public function coinciden(string $valor1, string $valor2, string $campo): void {
        if ($valor1 !== $valor2) {
            $this->errores[$campo] = "El campo {$campo} no coincide.";
        }
    }

    public function getErrores(): array {
        return $this->errores;
    }

    public function tieneErrores(): bool {
        return !empty($this->errores);
    }
}
