<?php

require_once __DIR__. '/../controllers/LoginController.php';

class Router
{
    private $controller;

    /** Доступные для посмотра страницы. */
    const AVAILABLE_ACTIONS = ['updateName', 'updatePassword', 'addUser', 'login', 'logOut'];

    /**
     * Router constructor.
     */
    public function __construct() {
        $this->controller = new LoginController();
    }

    public function route(?string $action, array $parameters): void
    {
        if (!$action){
             $this->controller->index();
        }

        if (!in_array($action, self::AVAILABLE_ACTIONS)) {
            $this->controller->index();
        }

        $this->controller->$action();

        // if (isset($_POST['create'])) {
        //     if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['email'])) {
        //         (new LoginController())->addUser($_POST['user_name'], $_POST['password'], $_POST['email']);
        //     }
        // } elseif (isset($_POST['login'])) {
        //     if (isset($_POST['password']) && isset($_POST['email'])) {
        //         (new LoginController())->login($_POST['email'], $_POST['password']);
        //     }
        // } elseif (isset($_POST['update_name'])) {
        //     (new LoginController())->updateName($_POST['update_name']);
        // } elseif (isset($_POST['update_password'])) {
        //     (new LoginController())->updatePassword($_POST['update_password']);
        // } elseif (isset($_GET['create'])) {
        //     (new LoginController())->createUser();
        // } elseif (isset($_GET['logout'])) {
        //     (new LoginController())->logOut();
        // }
        // else {
        //     (new LoginController())->index();
        // }

    }
}