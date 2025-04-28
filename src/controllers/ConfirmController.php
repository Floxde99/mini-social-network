<?php

class ConfirmController extends Controller
{
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function index()
    {
        // Vérifier s'il y a un token dans l'URL
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
                    // Mettre à jour l'utilisateur
                    $updateStmt = $this->db->prepare("
                        UPDATE users 
                        SET email_verified = TRUE,
                            email_verified_at = NOW(),
                            email_token = NULL
                        WHERE iduseur = ?
                    ");
                    
                    $updateStmt->execute([$user['iduseur']]);
                    $_SESSION['success'] = 'Votre compte a été vérifié avec succès ! Vous pouvez maintenant vous connecter.';
                } else {
                    $_SESSION['errors'] = ['Le lien de confirmation est invalide ou a expiré'];
                }
            } catch (Exception $e) {
                $_SESSION['errors'] = ['Une erreur est survenue lors de la vérification'];
            }
        }
        
        require '../view/confirm.php';
    }
}