<?php

class RetourMailController extends Controller {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function index() {
        $token = $_GET['token'] ?? null;

        if ($token) {
            try {
                $stmt = $this->db->prepare("
                    SELECT iduseur 
                    FROM users 
                    WHERE email_token = ? 
                    AND email_verified = FALSE
                ");
                
                $stmt->execute([$token]);
                $user = $stmt->fetch();

                if ($user) {
                    // Mise à jour du compte
                    $updateStmt = $this->db->prepare("
                        UPDATE users 
                        SET email_verified = TRUE,
                            email_verified_at = NOW(),
                            email_token = NULL
                        WHERE iduseur = ?
                    ");
                    
                    $updateStmt->execute([$user['iduseur']]);
                    
                    // Message de succès avec style unifié
                    $_SESSION['success'] = "Votre compte a été vérifié avec succès ! Vous pouvez maintenant vous connecter.";
                    
                    // Redirection vers la page de login
                    header('Location: /login');
                    exit;
                } else {
                    $_SESSION['errors'][] = "Le lien de confirmation est invalide ou a expiré.";
                }
            } catch (Exception $e) {
                $_SESSION['errors'][] = "Une erreur est survenue lors de la vérification.";
            }
        }

        // Affichage de la vue
        require '../view/retourMail.php';
    }
}