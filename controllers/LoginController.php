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
     *
     * @param bool $logOut Пришел ли пользователь с действия разлогина.
     *
     * @throws Exception
     */
    public function index(bool $logOut = false): void
    {
        if (isset($_SESSION['logged_id']) && $_SESSION['logged_id'] && !$logOut) {
            $data = $this->service->getUserDataById($_SESSION['logged_id']);
            echo $this->getTemplate('user_page', $data);
        } else {
            echo $this->getTemplate('login');
        }
    }

    /**
     * Страница создания нового пользователя.
     */
    public function create()
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
            echo 'Логин или пароль не могут быть пустыми!';
            $this->index();

            return false;
        }

        if (!$this->service->login($email, $password)) {
            echo 'Неверный логин или пароль!';
        }

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
            echo 'Не заполнено одно из полей!';

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

        if (!$this->service->updatePassword($password)) {
            echo 'ОШИБКА! Не удалось сменить пароль. Пароль должен быть от 6 до 20 символов.';
        }

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

        if (!$this->service->updateUserName($name)) {
            echo 'ОШИБКА! Не удалось сменить имя. Имя должно быть от 2 до 50 символов.';
        }

        $this->index();

        return true;
    }

    /**
     * Выходит из системы.
     */
    public function logOut(): void
    {
        $this->service->logOut();

        $this->index(true);
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