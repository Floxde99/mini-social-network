<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class EmailService {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPDebug = 0;
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'florian.fchr99@gmail.com';
            $this->mailer->Password = 'wddk oaac oald iqyi';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
            $this->mailer->CharSet = 'UTF-8';
        } catch (Exception $e) {
            throw new Exception("Erreur de configuration SMTP : " . $e->getMessage());
        }
    }

    public function sendConfirmationEmail($email, $username, $token) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->setFrom('florian.fchr99@gmail.com', 'ClicnClac');
            $this->mailer->addAddress($email, $username);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Confirmez votre inscription';

            $confirmationLink = "http://localhost:8000/retour-mail?token=" . $token;

            $this->mailer->Body = "
                <h2>Bienvenue sur ClicnClac !</h2>
                <p>Bonjour {$username},</p>
                <p>Merci pour votre inscription. Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :</p>
                <p><a href='{$confirmationLink}' style='padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>
                    Confirmer mon compte
                </a></p>
                <p>Si le lien ne fonctionne pas, copiez cette URL dans votre navigateur :</p>
                <p>{$confirmationLink}</p>
                <p>Ce lien expire dans 24 heures.</p>
            ";

            $this->mailer->AltBody = "
                Bienvenue sur ClicnClac !
                
                Bonjour {$username},
                
                Merci pour votre inscription. Pour activer votre compte, veuillez copier et coller le lien suivant dans votre navigateur :
                
                {$confirmationLink}
                
                Ce lien expire dans 24 heures.
            ";

            return $this->mailer->send();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'envoi de l'email : " . $e->getMessage());
        }
    }

    public function sendContactEmail($senderEmail, $senderName, $subject, $htmlContent) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->setFrom($senderEmail, $senderName);
            $this->mailer->addAddress('florian.fchr99@gmail.com', 'ClicnClac Admin');
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Contact - ' . $subject;
            $this->mailer->Body = $htmlContent;
            $this->mailer->AltBody = strip_tags($htmlContent);

            return $this->mailer->send();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'envoi de l'email : " . $e->getMessage());
        }
    }
}