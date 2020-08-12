<html>
<head>
    <title>Личный кабинет</title>
    <link href="resources/css/index.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div>

    <div class="main-container">

        <div class="welcome-text">Привет, <? echo $name ?></div>
        <div class="welcome-text">Ничего интересного в личном кабинете. Можете сменить имя и пароль, если хотите. Ещё
            можете выйти.
        </div>
        <form action="index.php" method="post" onSubmit="return validate();">
            <div class="input-container">
                <div>
                    <label for="update_name">Сменить имя</label><span id="password_info"></span>
                </div>
                <div>
                    <input class="form-control" name="name" id="name" type="text"
                           placeholder="Ваше новое имя">
                </div>
            </div>
            <input type="hidden" name="action" value="updateName" />
            <button class="btn btn-sm " type="submit" name="name">
                Сменить
            </button>
        </form>
        <form action="index.php" method="post" onSubmit="return validate();">
            <div class="input-container">
                <div>
                    <label for="password">Сменить пароль</label><span id="password_info"></span>
                </div>
                <div>
                    <input class="form-control" name="password" id="password" type="password"
                           placeholder="Ваш новый пароль">
                </div>
            </div>
            <div class="button-container">
                <input type="hidden" name="action" value="updatePassword" />
                <button class="btn btn-sm " type="submit" name="password">
                    Сменить
                </button>
            </div>
        </form>

        <div class="register-link">
            <br>
            <a href="index.php?action=logOut">Выйти</a>
        </div>

    </div>
    </form>
</div>
</body>
</html>