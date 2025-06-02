<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/general/styles/normalize.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="view/pages/reset/reset.css">
    <title>Регистрация</title>
</head>

<body>
    <?php include 'view/assets/header/header.html'; ?>

    <main class="main-container">
        <div class="form-wrapper login">
            <div class="form-content">
                <form method="POST" action="/reset_password_form">
                    <div class="field">
                        <input class="input" type="email" id="email" name="email" placeholder="Введите email" required>
                    </div>
                    <div class="field">
                        <input class="input" type="text" id="recovery_code" name="recovery_code" placeholder="Введите код восстановления" required>
                    </div>
                    <div class="field">
                        <input class="password" type="password" id="new_password" name="new_password" placeholder="Новый пароль" required>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="field button-field">
                        <button type="submit">Сменить пароль</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll(".eye-icon").forEach(eyeIcon => {
            eyeIcon.addEventListener("click", () => {
                let passwordField = eyeIcon.previousElementSibling;
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    eyeIcon.classList.replace("bx-hide", "bx-show");
                } else {
                    passwordField.type = "password";
                    eyeIcon.classList.replace("bx-show", "bx-hide");
                }
            });
        });
    </script>


    <?php include 'view/assets/footer/footer.html'; ?>
</body>

</html>