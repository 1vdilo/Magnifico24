<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Наши Услуги</title>
    <link rel="stylesheet" href="view/general/styles/normolize.css">
    <link rel="stylesheet" href="view/pages/usl/usl.css">
    <link rel="stylesheet" href="view/pages/home.home.css">
</head>

<body>

    <?php include 'view/assets/header/header.html';

    use controller\Usl;
    ?>



    <main class="services">
        <a href="#top" id="back-to-top" class="back-to-top" title="Back to top">▲</a>

        <div class="container">
            <h1 class="services__title">Наши Услуги</h1>
            <h2 style='color: aliceblue;'>Экстерьер</h2>
            <div class="services__grid">
                <?
                $servises = Usl::getServisesCat(1);
                foreach ($servises as $usl1):
                ?>
                    <div class="service-card">
                        <h2 class="service-card__title"><?= $usl1['title'] ?></h2>
                        <p class="service-card__description"><?= $usl1['description'] ?></p>
                        <p class='service-card__title'>от <?= $usl1['price'] ?> ₽</p>
                        <a href="#" class="service-card__link openModalBtn" data-service="<?= $usl1['title'] ?>">Записаться</a>
                    </div>
                <? endforeach ?>
            </div>
            <h2 style='color: aliceblue;'>Интрьер</h2>
            <div class="services__grid">
                <?
                $servises = Usl::getServisesCat(2);
                foreach ($servises as $usl2):
                ?>
                    <div class="service-card">
                        <h2 class="service-card__title"><?= $usl2['title'] ?></h2>
                        <p class="service-card__description"><?= $usl2['description'] ?></p>
                        <p class='service-card__title'>от <?= $usl2['price'] ?> ₽</p>
                        <a href="#" class="service-card__link openModalBtn" data-service="<?= $usl2['title'] ?>">Записаться</a>
                    </div>
                <? endforeach ?>
            </div>
            <h2 style='color: aliceblue;'>Детелинг</h2>
            <div class="services__grid">
                <?
                $servises = Usl::getServisesCat(3);
                foreach ($servises as $usl3):
                ?>
                    <div class="service-card">
                        <h2 class="service-card__title"><?= $usl3['title'] ?></h2>
                        <p class="service-card__description"><?= $usl3['description'] ?></p>
                        <p class='service-card__title'>от <?= $usl3['price'] ?> ₽</p>
                        <a href="#" class="service-card__link openModalBtn" data-service="<?= $usl3['title'] ?>">Записаться</a>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    </main>

    <?php
    $all_services = [];
    $all_services = array_merge($all_services, Usl::getServisesCat(1));
    $all_services = array_merge($all_services, Usl::getServisesCat(2));
    $all_services = array_merge($all_services, Usl::getServisesCat(3));
    ?>

    <div class="modal" id="myModal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Запись на услугу</h2>
            <form id="modalForm" action="/modalForm" method="post">
                <? date_default_timezone_set('Asia/Krasnoyarsk') ?>
                <label for="phone">Дата: <?= date("F j, Y") ?></label>
                <label for="phone">Наш номер телефона: +7 923 355 33-55</label>
                <label for="phone">Ваше имя:</label>
                <input type="tel" id="phone" name="name" required><br><br>
                <label for="phone">Номер телефона:</label>
                <input type="tel" id="phone" name="phone" required><br><br>

                <label for="service">Выберите услугу:</label>
                <select id="service" name="service">
                    <?
                    foreach ($all_services as $usl):
                    ?>
                        <option value="<?= $usl['title'] ?>"><?= $usl['title'] ?></option>
                    <? endforeach ?>
                </select><br><br>

                <label for="car">Модель автомобиля:</label>
                <input type="text" name="car" id="car" required><br><br>


                <label for="car">Коментарий к записи:</label>
                <textarea id="car" name="comment" rows="4" cols="30" required></textarea><br><br>

                <input type="hidden" name="date" value='<?= date("Y-m-d") ?>'>

                <input type="hidden" name="userID" value='<?= @$_SESSION['user']['userID'] ?>'>

                <button type="submit">Отправить</button>
            </form>

        </div>
    </div>
  

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById("myModal");
            const btns = document.querySelectorAll(".openModalBtn");
            const span = document.querySelector(".close-button");
            const serviceSelect = document.getElementById('service');

            btns.forEach(btn => {
                btn.onclick = function(e) {
                    e.preventDefault();

                    modal.style.display = "block";
                    const service = this.dataset.service;
                    serviceSelect.value = service;
                };
            });


            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });


        document.addEventListener("DOMContentLoaded", function() {
            const backToTop = document.getElementById("back-to-top");

            window.addEventListener("scroll", function() {
                if (window.pageYOffset > 300) {
                    backToTop.style.display = "block";
                } else {
                    backToTop.style.display = "none";
                }
            });

            backToTop.addEventListener("click", function(event) {
                event.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        });
    </script>

    <?php include 'view/assets/footer/footer.html'; ?>
</body>

</html>