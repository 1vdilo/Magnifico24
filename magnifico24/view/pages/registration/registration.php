<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="view/general/styles/normalize.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="view/pages/registration/registration.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
  <title>Регистрация</title>
</head>

<body>
  <?php include 'view/assets/header/header.html'; ?>

  <main class="main-container">
    <section class="forms-section">
      <div class="form-wrapper login">
        <div class="form-content">
          <h2 class="form-title">Войти</h2>
          <form action="/login_form" method="post">
            <div class="field">
              <input type="email" name="email" placeholder="Логин" class="input" required>
            </div>
            <div class="field">
              <input type="password" name="pass" placeholder="Пароль" class="password" required>
              <i class='bx bx-hide eye-icon'></i>
            </div>
          
            <div class="field button-field">
              <button type="submit">Войти</button>
            </div>
            <div class="form-link">
              <a href="/forgot" class="forgot-pass">Забыли пароль?</a>
            </div>
          </form>
          <div class="form-link">
            <span>Нет учетной записи? <a href="#" class="signup-link">Регистрация</a></span>
          </div>
        </div>
      </div>

      <div class="form-wrapper signup hidden">
        <div class="form-content">
          <h2 class="form-title">Регистрация</h2>
          <form action="/registration_form" method="post">
            <div class="field">
              <input type="text" name="surname" placeholder="Фамилия" class="input" required>
            </div>
            <div class="field">
              <input type="text" name="name" placeholder="Имя" class="input" required>
            </div>
            <div class="field">
              <input type="tel" name="phone"id="phone" placeholder="+7 (___) ___-__-__" class="input" required>
            </div>
            <div class="field">
              <input type="email" name="email" placeholder="Логин" class="input" required>
            </div>
            <div class="field">
              <input type="password" name="pass" placeholder="Пароль" class="password" required>
              <i class='bx bx-hide eye-icon'></i>
            </div>
            <div class="field">
              <input type="password" name="pass2" placeholder="Подтвердите пароль" class="password" required>
              <i class='bx bx-hide eye-icon'></i>
            </div>
            <div class="field button-field">
              <button type="submit">Регистрация</button>
            </div>
          </form>
          <div class="form-link">
            <span>Уже есть учетная запись? <a href="#" class="login-link">Войти</a></span>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include 'view/assets/footer/footer.html'; ?>

  <script src="view/pages/registration/registration.js"></script>
</body>

</html>