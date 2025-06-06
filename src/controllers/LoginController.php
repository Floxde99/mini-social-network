<?php

class LoginController extends Controller 
{
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function index() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_COOKIE['remember_me']) && !isset($_SESSION['user'])) {
                $cookieData = json_decode($_COOKIE['remember_me'], true);
                if ($cookieData && isset($cookieData['email']) && isset($cookieData['token'])) {
                    // Vérifier l'utilisateur avec le token stocké
                    $stmt = $this->db->prepare("SELECT * FROM users WHERE mail = ? AND email_verified = TRUE");
                    $stmt->execute([$cookieData['email']]);
                    $user = $stmt->fetch();
                    
                    if ($user) {
                        $_SESSION['user'] = [
                            'iduseur' => $user['iduseur'],
                            'username' => $user['username'],
                            'email' => $user['mail']
                        ];
                        header('Location: /');
                        exit;
                    }
                }
            }
            require '../view/login.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $remember = isset($_POST['remember_me']);

                if (empty($email) || empty($password)) {
                    throw new Exception('Veuillez remplir tous les champs');
                }

                $stmt = $this->db->prepare("SELECT * FROM users WHERE mail = ? AND email_verified = TRUE");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if (!$user || !password_verify($password, $user['mdp'])) {
                    throw new Exception('Email ou mot de passe incorrect');
                }

                $_SESSION['user'] = [
                    'iduseur' => $user['iduseur'],
                    'username' => $user['username'],
                    'email' => $user['mail']
                ];

                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    
                    $cookieData = [
                        'email' => $user['mail'],
                        'token' => $token
                    ];
                    
                    setcookie(
                        'remember_me',
                        json_encode($cookieData),
                        [
                            'expires' => time() + (7 * 24 * 60 * 60),
                            'path' => '/',
                            'secure' => true,
                            'httponly' => true,
                            'samesite' => 'Strict'
                        ]
                    );
                }

                header('Location: /main');
                exit;

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /login');
                exit;
            }
        }
    }
}