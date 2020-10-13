<?php

require_once __DIR__. '/../controllers/LoginController.php';

/** Простой роутинг. */
class Router
{
    private LoginController $controller;

    /** Доступные для посмотра страницы. */
    const AVAILABLE_ACTIONS = ['updateName', 'updatePassword', 'addUser', 'login', 'logOut', 'create'];

    /**
     * Router constructor.
     */
    public function __construct(LoginController $controller) {
        $this->controller = $controller;
    }

    /**
     * Перенаправление на страницу.
     *
     * @param null|string $action
     *
     * @return bool
     * @throws Exception
     */
    public function route(?string $action): bool
    {
        if ($action === null){
             $this->controller->index();
             return false;
        }

        if (!in_array($action, self::AVAILABLE_ACTIONS)) {
            $this->controller->index();
            return false;
        }

        $this->controller->$action();

        return true;
    }
}
