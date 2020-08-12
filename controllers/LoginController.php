<?php

declare(strict_types=1);

require_once './DB.php';
require_once './classes/User.php';

class LoginController
{
    const NAME = 'name';

    const PASSWORD = 'password';

    const EMAIL = 'email';

    /**
     * @var User
     */
    private $service;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->service = new User();
    }

    /**
     * Главная страница.
     */
    public function index(): void
    {
        if (isset($_SESSION['logged_id']) && $_SESSION['logged_id']) {
            $data = $this->service->getUserDataById($_SESSION['logged_id']);
            echo $this->getTemplate('user_page', $data);
        } else {
            echo $this->getTemplate('login');
        }
    }

    /**
     * Страница создания нового пользователя.
     */
    public function createUser()
    {
        echo $this->getTemplate('create_user');
    }

    /**
     * Авторизирует пользователя в системе.
     *
     * @return bool
     * @throws Exception
     */
    public function login(): bool
    {
        $email = $this->getFromRequest(self::EMAIL);
        $password = $this->getFromRequest(self::PASSWORD);

        if (!$password || !$email) {
            return false;
        }

        $this->service->login($email, $password);
        $this->index();
        return true;
    }

    /**
     * Добавляет нового пользователя.
     *
     * @return bool
     * @throws Exception
     */
    public function addUser(): bool
    {
        $userName = $this->getFromRequest(self::NAME);
        $password = $this->getFromRequest(self::PASSWORD);
        $email = $this->getFromRequest(self::EMAIL);

        $this->service->createUser($userName, $password, $email);

        if (!$userName || !$password || !$email) {
            return false;
        }

        $this->index();
        return true;
    }

    /**
     * Обновляет пароль у авторизированного пользователя.
     *
     * @return bool
     * @throws Exception
     */
    public function updatePassword(): bool
    {
        $password = $this->getFromRequest(self::PASSWORD);
        if (!$password) {
            return false;
        }

        $this->service->updatePassword($password);
        $this->index();
        return true;
    }

    /**
     * Обновляет имя у авторизированного пользователя.
     *
     * @return bool
     * @throws Exception
     */
    public function updateName(): bool
    {
        $name = $this->getFromRequest(self::NAME);
        if (!$name) {
            return false;
        }

        $this->service->updateUserName($name);
        $this->index();
        return true;
    }

    /**
     * Выходит из системы.
     */
    public function logOut(): void
    {
        $this->service->logOut();

        $this->index();
    }

    /**
     * Возвращает вёрстку для страницы.
     *
     * @param string $templateName Имя шаблона из папки /resources/views.
     * @param array $data
     *
     * @return string
     */
    public function getTemplate(string $templateName, array $data = []): string
    {
        if (!empty($data)) {
            extract($data);
        }
        ob_start();
        include "resources/view/$templateName.php";

        return ob_get_clean();
    }

    public function getFromRequest($parameterName)
    {
        return trim($_REQUEST[$parameterName]);
    }
}