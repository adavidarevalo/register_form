<?php
class Validator {
    public static function validateUsername($username) {
        if (empty($username)) {
            return "El nombre de usuario es requerido";
        }
        if (strlen($username) < 3 || strlen($username) > 50) {
            return "El nombre de usuario debe tener entre 3 y 50 caracteres";
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            return "El nombre de usuario solo puede contener letras, números y guiones bajos";
        }
        return "";
    }

    public static function validateEmail($email) {
        if (empty($email)) {
            return "El correo electrónico es requerido";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "El correo electrónico no es válido";
        }
        return "";
    }

    public static function validatePassword($password) {
        if (empty($password)) {
            return "La contraseña es requerida";
        }
        if (strlen($password) < 8) {
            return "La contraseña debe tener al menos 8 caracteres";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return "La contraseña debe contener al menos una letra mayúscula";
        }
        if (!preg_match('/[a-z]/', $password)) {
            return "La contraseña debe contener al menos una letra minúscula";
        }
        if (!preg_match('/[0-9]/', $password)) {
            return "La contraseña debe contener al menos un número";
        }
        return "";
    }

    public static function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}
?>
