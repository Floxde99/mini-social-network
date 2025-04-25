<?php
require_once __DIR__ . '/../services/EmailService.php';

class RegisterController extends Controller
{
    private $db;
    private $emailService;

    public function __construct() {
        $this->db = Db::getInstance();
        $this->emailService = new EmailService();
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require '../view/register.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $username = trim($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';
                $password_confirm = $_POST['password_confirm'] ?? '';
                $email = trim($_POST['email'] ?? '');

                // Validation des champs
                if (empty($username) || empty($password) || empty($email) || empty($password_confirm)) {
                    throw new Exception('Veuillez renseigner tous les champs.');
                }

                // Vérification de la correspondance des mots de passe
                if ($password !== $password_confirm) {
                    throw new Exception('Les mots de passe ne correspondent pas.');
                }

                // Vérification de l'existence de l'utilisateur
                $stmt = $this->db->prepare("SELECT * FROM users WHERE mail = ?");
                $stmt->execute([$email]);
                if ($stmt->rowCount() > 0) {
                    throw new Exception('Cette adresse email est déjà utilisée.');
                }

                // Hash du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Générer un token de confirmation
                $token = bin2hex(random_bytes(32));

                // Insertion de l'utilisateur avec date_inscription au lieu de created_at
                $stmt = $this->db->prepare("
                    INSERT INTO users (username, mail, mdp, email_token, date_inscription) 
                    VALUES (?, ?, ?, ?, NOW())
                ");
                
                $stmt->execute([
                    $username,
                    $email,
                    $hashedPassword,
                    $token
                ]);

                // Envoi de l'email
                $this->emailService->sendConfirmationEmail($email, $username, $token);

                $_SESSION['success'] = "Inscription réussie ! Veuillez vérifier vos emails pour confirmer votre compte.";
                header('Location: /confirm');
                exit;

            } catch (Exception $e) {
                $_SESSION['errors'] = [$e->getMessage()];
                header('Location: /register');
                exit;
            }
        }
    }
}
