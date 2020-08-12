Страница для авторизации пользователя.

Что можно делать:
- создать нового пользователя;
- войти пользователем в систему;
- сменить пароль и имя;
- выйти из аккаунта.

PHP 7.3.9 <BR>
MySQL 8.0.18
<BR>

Таблица `users`: <BR>
```mysql
 CREATE TABLE `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `session_id` varchar(255) DEFAULT NULL,
  `session_ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4
  ```
