<?php

namespace App\src\models;

use App\src\database\DatabaseConnection;
use PDO;
use Random\RandomException;

class UserModel
{
    /**
     *
     * @param DatabaseConnection $connect Instance de la classe DbConnect pour la connexion à la base de données.
     */
    public function __construct(private readonly DatabaseConnection $connect)
    {
    }

    public function getUserByName(string $name): ?array
    {
        $query = $this->connect->getConnection()->prepare("SELECT * FROM user WHERE name = :name");
        $query->bindParam(':name', $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getUserByMail(string $email): ?array
    {
        $query = $this->connect->getConnection()->prepare("SELECT * FROM user WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * @param mixed $name
     * @param mixed $email
     * @param mixed $annee
     * @param mixed $groupe
     * @throws RandomException
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

        $this->envoyerEmail($email, $password);

    }

    public function envoyerEmail(mixed $email, mixed $password): void
    {
        $subject = 'Création de compte';
        $message = "Bonjour,\n\nUn compte a été créé pour vous. Votre mot de passe temporaire est : $password\n\n"
            . "Veuillez vous connecter sur le site via le lien ci-dessous pour définir votre nouveau mot de passe :\n"
            . "https://votre-site.com/changer-mot-de-passe?email=$email\n\n"
            . "Cordialement, \nLa direction du BUT informatique.";


        if (!mail($email, $subject, $message)) {
            throw new \Exception('Erreur lors de l\'envoi de l\'email.');
        }

        mail($email, $subject, $message);
    }


    public function changePassword(mixed $email, mixed $password): void
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = 'UPDATE user SET password = :password WHERE email = :email';
        $stmt = $this->connect->getConnection()->prepare($sql);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour du mot de passe.');
        }
    }

    public function supprimerUserAction(mixed $email){
        $sql = 'DELETE FROM user WHERE email = :email';
        $stmt = $this->connect->getConnection()->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la suppression de l\'utilisateur.');
        }
    }

    public function mettreAjourMdpAction(mixed $name, mixed $mdp)
    {
        $passwordHash = password_hash($mdp, PASSWORD_BCRYPT);

        $sql = 'UPDATE user SET password = :password WHERE name = :name';
        $stmt = $this->connect->getConnection()->prepare($sql);

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            throw new \Exception('Erreur lors de la mise à jour du mot de passe.');
        }
    }
}
