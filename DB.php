<?php
declare(strict_types=1);

session_start();

class DB {
    /**
     * @var string Имя хоста.
     */
    private $host = 'localhost';

    /**
     * @var string Пользователь MySQL.
     */
    private $user = 'root';

    /**
     * @var string Пароль для MySQL.
     */
    private $password = 'password';

    /**
     * @var string Schema MySQL.
     */
    private $schema = 'defaultSchema';

    /**
     * Возвращает объект PDO.
     *
     * @return null|PDO
     */
    public function getPDO(): ?PDO
    {

         $dataSourceName = 'mysql:host=' . $this->host . ';dbname=' . $this->schema;

        try
        {
            $pdo = new PDO($dataSourceName, $this->user,  $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($pdo) {
                return $pdo;
            }
        }
        catch (PDOException $e)
        {
            echo $e;
            die();
        }

        return null;
    }
}
