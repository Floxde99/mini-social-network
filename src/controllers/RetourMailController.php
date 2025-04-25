<?php

class RetourMailController extends Controller {
    private $db;

    public function __construct() {
        $this->db = Db::getInstance();
    }

    public function index() {
        try {
            $token = $_GET['token'] ?? '';
            
            if (empty($token)) {
                throw new Exception("Token invalide ou manquant");
            }

            $stmt = $this->db->prepare("
                SELECT * FROM users 
                WHERE email_token = ? 
                AND email_verified = FALSE
            ");
            
            $stmt->execute([$token]);
            $user = $stmt->fetch();

            if (!$user) {
                throw new Exception("Ce lien de confirmation n'est plus valide ou a déjà été utilisé");
            }

            
            $updateStmt = $this->db->prepare("
                UPDATE users 
                SET email_verified = TRUE,
                    email_verified_at = NOW(),
                    email_token = NULL
                WHERE iduseur = ?
            ");
            
            $updateStmt->execute([$user['iduseur']]);
            $_SESSION['success'] = "Votre compte a été vérifié avec succès ! Vous pouvez maintenant vous connecter.";

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        require '../view/retourMail.php';
    }
}