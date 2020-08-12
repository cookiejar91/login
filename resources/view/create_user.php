<html>
<head>
    <title>Регистрация</title>
    <link href="resources/css/index.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div>
    <form action="index.php" method="post" onSubmit="return validate();">
        <div class="main-container">

            <div class="welcome-text">Регистрация</div>
            <div class="input-container">
                <div>
                    <label for="username">Имя</label><span id="user_info"></span>
                </div>
                <div>
                    <input class="form-control" name="user_name" id="user_name" type="text">
                </div>
            </div>
            <div class="input-container">
                <div>
                    <label for="password">Пароль</label><span id="password_info"></span>
                </div>
                <div>
                    <input class="form-control" name="password" id="password" type="password">
                </div>
            </div>
            <div class="input-container">
                <div>
                    <label for="email">E-mail</label><span id="password_info"></span>
                </div>
                <div>
                    <input class="form-control" name="email" id="email" type="email">
                </div>
            </div>
            <div class="button-container">
                <input type="hidden" name="action" value="create_account" />
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="create">
                    Создать
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>