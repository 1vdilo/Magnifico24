<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/general/styles/normalize.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="view/pages/forgot/forgot.css">
    <title>Регистрация</title>
</head>

<body>
    <?php include 'view/assets/header/header.html'; ?>

    <main class="main-container">
        <section class="forms-section">
            <div class="form-wrapper login">
                <div class="form-content">
                    <h2 class="form-title">Восстановление пароля</h2>
                    <form method="POST" action="/send_recovery_code">
                        <input class="input" placeholder="Введите email" type="email" id="email" name="email" required>
                        <p class="form-description">Код будет отправлен на вашу почту. Отправить?</p>
                        <div class="field button-field">
                            <button type="submit">Отправить код</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php include 'view/assets/footer/footer.html'; ?>
</body>

</html>