<?php
require_once __DIR__ . '/../services/EmailService.php';

class ContactController extends Controller {
    private $emailService;

    public function __construct() {
        // Pas besoin d'appeler parent::__construct() car Controller n'a pas de constructeur
        $this->emailService = new EmailService();
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require '../view/contact.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $subject = trim($_POST['subject'] ?? '');
                $message = trim($_POST['message'] ?? '');

                // Validation
                if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                    throw new Exception('Tous les champs sont obligatoires.');
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Adresse email invalide.');
                }

                // Préparation du message HTML
                $htmlContent = "
                    <h2>Nouveau message de contact</h2>
                    <p><strong>Nom:</strong> " . htmlspecialchars($name) . "</p>
                    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                    <p><strong>Sujet:</strong> " . htmlspecialchars($subject) . "</p>
                    <p><strong>Message:</strong></p>
                    <p>" . nl2br(htmlspecialchars($message)) . "</p>
                ";

                // Utilisation de la méthode sendContactEmail
                $sent = $this->emailService->sendContactEmail(
                    $email,
                    $name,
                    $subject,
                    $htmlContent
                );

                if (!$sent) {
                    throw new Exception("L'envoi du message a échoué. Veuillez réessayer plus tard.");
                }

                $_SESSION['success'] = "Votre message a été envoyé avec succès !";
                header('Location: /contact');
                exit;

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /contact');
                exit;
            }
        }
    }
}