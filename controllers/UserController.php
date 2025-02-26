<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/Validator.php';

class UserController {
    private $userModel;
    private $validator;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
        $this->validator = new Validator();
    }

    public function register() {
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = Validator::sanitizeInput($_POST['username'] ?? '');
            $email = Validator::sanitizeInput($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $usernameError = Validator::validateUsername($username);
            $emailError = Validator::validateEmail($email);
            $passwordError = Validator::validatePassword($password);

            if ($usernameError) $errors['username'] = $usernameError;
            if ($emailError) $errors['email'] = $emailError;
            if ($passwordError) $errors['password'] = $passwordError;

            if (empty($errors)) {
                if ($this->userModel->isEmailExists($email)) {
                    $errors['email'] = "Este correo electrónico ya está registrado";
                }
                if ($this->userModel->isUsernameExists($username)) {
                    $errors['username'] = "Este nombre de usuario ya está en uso";
                }
            }

            if (empty($errors)) {
                if ($this->userModel->registerUser($username, $email, $password)) {
                    $success = true;
                    $_SESSION['register_success'] = true;
                    header('Location: login.php');
                    exit;
                } else {
                    $errors['general'] = "Error al registrar el usuario. Por favor, intente nuevamente.";
                }
            }
        }

        include __DIR__ . '/../views/register.php';
    }

    public function login() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Validator::sanitizeInput($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $emailError = Validator::validateEmail($email);
            if ($emailError) {
                $errors['email'] = $emailError;
            }
            
            if (empty($password)) {
                $errors['password'] = "La contraseña es requerida";
            }
            
            if (empty($errors)) {
                $user = $this->userModel->verifyLogin($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $errors['general'] = "Correo electrónico o contraseña incorrectos";
                }
            }
        }
        
        include __DIR__ . '/../views/login.php';
    }

    public function logout() {
        // Destroy all session data
        session_destroy();
        
        // Redirect to login page
        header('Location: login.php');
        exit;
    }
}
?>
