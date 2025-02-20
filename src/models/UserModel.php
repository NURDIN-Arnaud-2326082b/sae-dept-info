<?php

namespace App\src\models;

use App\src\core\DatabaseConnection;
use PDO;
use Random\RandomException;

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
     * @throws RandomException Erreur lors de l'envoi de l'email.
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

        mail($email, $subject, $message);
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
     * @param string $mdp Nouveau mot de passe.
     * @throws \Exception Erreur lors de la mise à jour du mot de passe.
     */
    public function mettreAjourMdpAction(mixed $name, mixed $mdpActuel, mixed $nouveauMdp): void
    {
        // Vérification des champs
        if (empty($mdpActuel) || empty($nouveauMdp)) {
            throw new \Exception('Les mots de passe ne peuvent pas être vides.');
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
        if (strlen($nouveauMdp) < 12) {
            throw new \Exception("Le mot de passe doit contenir au moins 12 caractères.");
        }
        // Vérifie la présence d'une lettre
        if (!preg_match('/[a-zA-Z]/', $nouveauMdp)) {
            throw new \Exception("Le mot de passe doit contenir au moins une lettre.");
        }
        // Vérifie la présence d'un chiffre
        if (!preg_match('/\d/', $nouveauMdp)) {
            throw new \Exception("Le mot de passe doit contenir au moins un chiffre.");
        }
        // Vérifie la présence d'un caractère spécial
        if (!preg_match('/[\W_]/', $nouveauMdp)) {
            throw new \Exception("Le mot de passe doit contenir au moins un caractère spécial.");
        }
        // Hache le nouveau mdp
        $passwordHash = password_hash($nouveauMdp, PASSWORD_BCRYPT);

        // Update le mdp
        $sql = 'UPDATE user SET password = :password WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour du mot de passe.');
        }
    }


}
