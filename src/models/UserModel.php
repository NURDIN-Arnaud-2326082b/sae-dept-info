<?php

namespace App\src\models;

use App\src\core\DatabaseConnection;
use PDO;
use Random\RandomException;
use function PHPUnit\Framework\exactly;

/**
 * Modèle de l'utilisateur.
 */
class UserModel
{
    /**
     *Constructeur de la classe UserModel.
     * @param DatabaseConnection $connect Instance de la classe DbConnect pour la connexion à la base de données.
     */
    public function __construct(private readonly DatabaseConnection $connect)
    {
    }

    /**
     * Récupère un utilisateur par son nom.
     *
     * @param string $name Nom de l'utilisateur.
     * @return array|null Tableau associatif contenant les informations de l'utilisateur ou null si l'utilisateur n'existe pas.
     */
    public function getUserByName(string $name): ?array
    {
        $query = $this->connect->getConnection()->prepare("SELECT * FROM user WHERE name = :name");
        $query->bindParam(':name', $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Récupère un utilisateur par son email.
     *
     * @param string $email Email de l'utilisateur.
     * @return array|null Tableau associatif contenant les informations de l'utilisateur ou null si l'utilisateur n'existe pas.
     */
    public function getUserByMail(string $email): ?array
    {
        $query = $this->connect->getConnection()->prepare("SELECT * FROM user WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Méthode pour ajouter un utilisateur.
     * @param mixed $name Nom de l'utilisateur.
     * @param mixed $email Email de l'utilisateur.
     * @param mixed $annee Année de l'utilisateur.
     * @param mixed $groupe Groupe de l'utilisateur.
     * @throws RandomException Erreur lors de l'ajout de l'utilisateur.
     */
    public function ajouterUserAction(mixed $name, mixed $email, mixed $annee, mixed $groupe): void
    {
        //Génére un mot de passe
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $tailleMax = strlen($caracteres) - 1;
        $chaineAleatoire = '';

        for ($i = 0; $i < $tailleMax; $i++) {
            $chaineAleatoire .= $caracteres[random_int(0, $tailleMax)];
        }

        $password = $chaineAleatoire;

        //Hash le mot de passe
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = 'INSERT INTO user (name, email, annee, groupe, password) VALUES (:name, :email, :annee, :groupe, :password)';
        $stmt = $this->connect->getConnection()->prepare($sql);

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':annee', $annee, PDO::PARAM_STR);
        $stmt->bindValue(':groupe', $groupe, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de l\'ajout de l\'utilisateur.');
        }

        $this->envoyerEmail($name,$email, $password);

    }

    /**
     * Envoie un email à l'utilisateur.
     * @param mixed $email Email de l'utilisateur.
     * @param mixed $password Mot de passe de l'utilisateur.
     * @throws \Exception Erreur lors de l'envoi de l'email.
     */
    public function envoyerEmail(mixed $name,mixed $email, mixed $password): void
    {
        $subject = 'Création de compte';
        $message = "Bonjour,\n\nUn compte a été créé pour vous."
            . "Voici votre identifiant : $name\n"
            . "Votre mot de passe temporaire est : $password\n\n"
            . "Veuillez vous connecter sur le site via le lien ci-dessous pour définir votre nouveau mot de passe :\n"
            . "https://departementinfoaix.alwaysdata.net/login\n\n"
            . "Cordialement, \nLa direction du BUT informatique.";


        if (!mail($email, $subject, $message)) {
            throw new \Exception('Erreur lors de l\'envoi de l\'email.');
        }
    }


    /**
     * Supprime un utilisateur.
     *
     * @param string $email Email de l'utilisateur.
     * @throws \Exception Erreur lors de la suppression de l'utilisateur.
     */
    public function supprimerUserAction(mixed $email){
        $sql = 'DELETE FROM user WHERE email = :email';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de l\'utilisateur.');
        }
    }

    /**
     * Met à jour le mot de passe d'un utilisateur.
     *
     * @param string $name Nom de l'utilisateur.
     * @param mixed $mdpActuel
     * @param mixed $nouveauMdp1
     * @param mixed $nouveauMdp2
     * @throws \Exception Erreur lors de la mise à jour du mot de passe.
     */
    public function mettreAjourMdpAction(mixed $name, mixed $mdpActuel, mixed $nouveauMdp1, mixed $nouveauMdp2): void
    {
        // Vérification des champs
        if (empty($mdpActuel) || empty($nouveauMdp1) || empty($nouveauMdp2)) {
            throw new \Exception('Les champs de mot de passe ne peuvent pas être vides.');
        }

        // Récupére mot de passe actuel
        $sql = 'SELECT password FROM user WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($mdpActuel, $user['password'])) {
            throw new \Exception('Mot de passe actuel incorrect.');
        }
        if (strlen($nouveauMdp1) < 12) {
            throw new \Exception("Le mot de passe doit contenir au moins 12 caractères.");
        }
        if (!preg_match('/[a-zA-Z]/', $nouveauMdp1)) {
            throw new \Exception("Le mot de passe doit contenir au moins une lettre.");
        }
        if (!preg_match('/\d/', $nouveauMdp1)) {
            throw new \Exception("Le mot de passe doit contenir au moins un chiffre.");
        }
        if (!preg_match('/[\W_]/', $nouveauMdp1)) {
            throw new \Exception("Le mot de passe doit contenir au moins un caractère spécial.");
        }

        // Vérifie que les deux nouveaux mdp sont identiques
        if ($nouveauMdp1 !== $nouveauMdp2) {
            throw new \Exception('Les deux nouveaux mots de passe ne correspondent pas.');
        }

        // Vérifie que le nouveau mdp est différent de l'ancien
        if ($mdpActuel === $nouveauMdp1) {
            throw new \Exception('Le nouveau mot de passe doit être différent de l\'ancien.');
        }

        // Hache le nouveau mdp
        $passwordHash = password_hash($nouveauMdp2, PASSWORD_BCRYPT);

        // Update le mdp
        $sql = 'UPDATE user SET password = :password WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour du mot de passe.');
        }
    }


    /**
     * Réinitialise le mot de passe d'un utilisateur.
     */
    public function reinitialiserMdp(): void
    {
        header('Content-Type: application/json');

        try {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            if (empty($name) || empty($email)) {
                throw new \Exception('Veuillez remplir tous les champs.');
            }

            // Vérifier si l'utilisateur existe
            $sql = 'SELECT email FROM user WHERE name = :name AND email = :email';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new \Exception('Aucun compte trouvé avec ces informations.');
            }

            // Générer un mot de passe aléatoire et le hacher
            $nouveauMdp = bin2hex(random_bytes(6)); // Exemple : "4f3d9a1b"
            $passwordHash = password_hash($nouveauMdp, PASSWORD_BCRYPT);

            // Mettre à jour le mot de passe
            $sql = 'UPDATE user SET password = :password WHERE name = :name';
            $stmt = $this->connect->getConnection()->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                throw new \Exception('Erreur lors de la mise à jour du mot de passe.');
            }

            // Envoyer l'email avec le nouveau mot de passe
            $to = $email;
            $subject = "Réinitialisation de votre mot de passe";
            $message = "Bonjour $name,\n\nVotre nouveau mot de passe est : $nouveauMdp\n\nVeuillez le modifier après connexion.";
            $headers = "From: departementinfoaix@alwaysdata.net\n";
            $headers .= "Reply-To: departementinfoaix@alwaysdata.net";


            error_log("Envoi d'email à: " . $email);

            if (!mail($to, $subject, $message, $headers)) {
                throw new \Exception('Échec de l\'envoi de l\'email.');
            } else {
                error_log("Email envoyé avec succès à: " . $email);
                echo json_encode(['success' => 'Un nouveau mot de passe a été envoyé à votre email.']);
                exit;
            }

        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    /**
     * ajoute une tentative de connexion.
     * @param $ip mixed Adresse IP de l'utilisateur.
     * @return void ne retourne rien.
     */
    public function logLoginAttempt(mixed $ip): void
    {
        $sql = 'INSERT INTO login_attempts (ip_address) VALUES (:ip)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Récupère le nombre de tentatives de connexion.
     * @param $ip mixed Adresse IP de l'utilisateur.
     * @param $minutes mixed Nombre de minutes.
     * @return mixed Nombre de tentatives de connexion.
     */
    public function getLoginAttempts($ip , $minutes)
    {
        $sql = 'SELECT COUNT(*) FROM login_attempts WHERE ip_address = :ip  AND attempt_time > (NOW() - INTERVAL :minutes MINUTE)';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindValue(':minutes', $minutes, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Récupère l'année et le groupe d'un utilisateur.
     * @param mixed $name Nom de l'utilisateur.
     * @return mixed Tableau associatif contenant l'année et le groupe de l'utilisateur.
     */
    public function getAnneeGroupe(mixed $name)
    {
        $sql = 'SELECT annee, groupe FROM user WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * méthode pour supprimer tous les utilisateurs sauf l'admin.
     * @return void ne retourne rien.
     */
    public function deleteAllUsers(): void
    {
        $sql = 'DELETE FROM user WHERE name != :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', 'admin', PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Méthode pour mettre à jour l'email d'un utilisateur.
     * @param mixed $email Email de l'utilisateur.
     * @param mixed $newemail Nouvel email de l'utilisateur.
     * @throws \Exception Erreur lors de la mise à jour de l'email.
     */
    public function mettreAjourEmailAction(mixed $email, mixed $newemail): void
    {
        $sql = 'UPDATE user SET email = :newemail WHERE email = :email';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':newemail', $newemail, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour de l\'email.');
        }
        else {
            error_log('ez');
            echo json_encode(['success' => 'Email mis à jour.']);
        }
    }
}