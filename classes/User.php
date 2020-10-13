<?php

declare(strict_types=1);

require_once './DB.php';

/** Класс пользователя. */
class User
{
    private int $id;

    private string $name;

    private string $email;

    private string $password;

    private PDO $db;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->db = (new DB())->getPDO();
    }

    /**
     * Создает нового пользователя.
     *
     * @param string $userName
     * @param string $password
     * @param string $email
     *
     * @return int
     * @throws Exception
     */
    public function createUser(string $userName, string $password, string $email): bool
    {
        $userName = trim($userName);
        $password = trim($password);
        $email = trim($email);

        if (!$this->checkUserName($userName)) {
            throw new Exception('Некорректное имя');
        }

        if (!$this->checkPassword($password)) {
            throw new Exception('Некорректный пароль');
        }

        if (!$this->checkEmail($email)) {
            throw new Exception('Некорректный e-mail');
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = 'INSERT INTO users (name, email, password) VALUES (?, ?, ?)';

        try {
            $res = $this->db->prepare($query);
            $res->execute([$userName, $email, $password]);
        } catch (PDOException $e) {
            throw new Exception($e);
        }

        return true;
    }

    /**
     * Производит логин.
     *
     * @param string $email
     * @param string $password
     *
     * @return null|bool
     * @throws Exception
     */
    public function login(string $email, string $password): ?bool
    {
        if (!$email || !$password) {
            return false;
        }

        try {
            $userData = $this->getUserDataByEmail($email);
        } catch (PDOException $e) {
            throw new Exception($e);
        }

        if (!$userData) {
            return false;
        }

        if (password_verify($password, $userData['password'])) {
            $this->id = (int)$userData['id'];
            $this->name = $userData['name'];
            $this->logged = true;

            if (session_status() == PHP_SESSION_ACTIVE) {
                $query = 'UPDATE users SET session_id = :session_id, session_ts = NOW() WHERE id = :id';

                try {
                    $res = $this->db->prepare($query);
                    $res->execute(['session_id' => session_id(), 'id' => $this->id]);
                    $_SESSION['logged_id'] = $this->id;
                } catch (PDOException $e) {
                    throw new Exception($e);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Возвращает данные о пользователе по его id.
     *
     * @param int $id
     *
     * @return array
     * @throws Exception
     */
    public function getUserDataById(int $id): array
    {
        try {
            $query = 'SELECT * FROM users WHERE id = ? LIMIT 1';

            $res = $this->db->prepare($query);
            $res->execute([$id]);

            return $res->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Обновляет имя пользователя.
     *
     * @param string $name
     *
     * @return bool
     * @throws Exception
     */
    public function updateUserName(string $name): bool
    {
        if (!isset($_SESSION['logged_id'])) {
            return false;
        }

        if (!$this->checkUserName($name)) {
            return false;
        }

        $query = 'UPDATE users SET name = ? WHERE id = ?';

        try {
            $res = $this->db->prepare($query);
            $res->execute([$name, $_SESSION['logged_id']]);
        } catch (PDOException $e) {
            throw new Exception($e);
        }

        return true;
    }

    /**
     * Обновляет пароль пользователя.
     *
     * @param string $password
     *
     * @return bool
     * @throws Exception
     */
    public function updatePassword(string $password): bool
    {
        if (!isset($_SESSION['logged_id'])) {
            return false;
        }

        if (!$this->checkPassword($password)) {
            return false;
        }

        $query = 'UPDATE users SET password = :password WHERE id = :id';

        try {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $res = $this->db->prepare($query);
            $res->execute(['password' => $password, 'id' => $_SESSION['logged_id']]);

            return true;
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Выходит из аккаунта.
     */
    public function logOut(): void
    {
        session_destroy();
        session_unset();
        session_reset();
    }

    /**
     * Находит пользователя по e-mail и возвращает данные по нему.
     *
     * @param string $email
     *
     * @return null|array
     * @throws Exception
     */
    private function getUserDataByEmail(string $email): ?array
    {
        if (!$email) {
            return null;
        }

        if (!$this->checkEmail($email)) {
            return null;
        }

        try {
            $query = 'SELECT * FROM users WHERE email = ? LIMIT 1';

            $res = $this->db->prepare($query);
            $res->execute([$email]);

            return $res->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Валидирует имя пользователя.
     *
     * @param string $userName
     *
     * @return bool
     */
    private function checkUserName(string $userName): bool
    {
        if (strlen($userName) < 2 || strlen($userName) > 50) {
            return false;
        }

        return true;
    }

    /**
     * Валидирует пароль пользователя.
     *
     * @param string $password
     *
     * @return bool
     */
    private function checkPassword(string $password): bool
    {
        if (!$password) {
            return false;
        }
        if (strlen($password) < 6 || strlen($password) > 20) {
            return false;
        }

        return true;
    }

    /**
     * Валидирует e-mail пользователя и возвращает e-mail или null.
     *
     * @param string $email
     *
     * @return null|string
     */
    private function checkEmail(string $email): ?string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
