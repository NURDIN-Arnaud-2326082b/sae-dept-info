<?php

namespace App\src\controllers;

use App\src\database\tables\GestionModel;
use App\src\views\GestionViews\Gestion;

class GestionController
{
    private GestionModel $model;
    private Gestion $view;

    public function __construct(GestionModel $model)
    {
        $this->model = $model;
        $this->view = new Gestion();
    }

    public function defaultMethod(): void
    {
        // Gestion des actions POST (ajout/suppression)
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] === 'add') {
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);

                if ($this->model->addUser($name, $email, $password)) {
                    $message = "Utilisateur ajouté avec succès.";
                } else {
                    $message = "Erreur lors de l'ajout de l'utilisateur.";
                }
            } elseif ($_POST['action'] === 'delete') {
                $userId = (int)$_POST['userId'];
                if ($this->model->deleteUser($userId)) {
                    $message = "Utilisateur supprimé avec succès.";
                } else {
                    $message = "Erreur lors de la suppression de l'utilisateur.";
                }
            }
        }

        // Afficher la page avec la liste des utilisateurs
        $users = $this->model->getAllUsers();
        $this->view->show($users, $message);
    }
}
