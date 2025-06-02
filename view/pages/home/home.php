<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/general/styles/normolize.css">
    <link rel="stylesheet" href="view/pages/home/home.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <title>Magnifico Car Design</title>
    </head>

</html>

<?
    include 'view/assets/header/header.html' ;

    ?>

    <main class="main">
        <a href="#top" id="back-to-top" class="back-to-top" title="Back to top">▲</a>
        <div class="container">
            <section class="banner">
                <div class="banner__container">

                    <div class="banner__container-max" id="banner-slider">
                        <div class="banner__slide-content">
                            <h2 class="banner__max-title">
                                С заботой и вниманием к
                                каждой детали
                            </h2>
                            <br>
                            <br>
                            <br>





                            <p class="banner__max-parag">
                                От идеи до реализации <br />
                                один шаг
                            </p>
                            <!-- <a href="#section3" class="banner__max-link">Консультация</a> -->
                            <a href="#" class="banner__max-link openModalBtn" data-service="Консультация">Консультация</a>
                        </div>
                    </div>
                    <div class="modal" id="myModal">
                        <div class="modal-content">
                            <span class="close-button">&times;</span>
                            <h2>Запись на услугу</h2>
                            <form id="modalForm" action="/modalForm" method="post">
                                <? date_default_timezone_set('Asia/Krasnoyarsk') ?>
                                <label for="phone">Дата: <?= date("F j, Y") ?></label>
                                <label for="phone">Наш нормер телефона: +7 923 355 33-55</label> <!-- Фиксани номер телефона -->
                                <label for="phone">Ваше имя:</label>
                                <input type="text" id="name" name="name" required><br><br>

                                <label for="phone">Номер телефона:</label>
                                <input type="tel" name="phone" id="phone" placeholder="+7 (___) ___-__-__" required><br><br>


                                <input type="hidden" name='service' value='Консультация'>

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

                    <div class="banner__container-min">
                        <div class="banner__min-item usl">
                            <h3 class="banner__min-title">Наши услуги</h3>
                            <p class="banner__min-parag">
                                Все работы выполняются квалифицированными специалистами
                            </p>
                            <a href="/usl" class="banner__min-link">Подробнее</a>
                        </div>
                        <div class="banner__min-item prs">
                            <h3 class="banner__min-title">Наши Товары</h3>
                            <p class="banner__min-parag">
                                Продукт кропотливой, вывереной и точной работы
                            </p>
                            <a href="/categories" class="banner__min-link">Подробнее</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="container">
            <section class="about">
                <h2 class="title">Почему именно мы?</h2>

                <div class="parent">
                    <div class="grid1 grid">
                        <h3 class="grid-title">30</h3>
                        <p class="grid-parag">Специалистов</p>
                    </div>
                    <div class="grid2 grid">
                        <h3 class="grid-title">1 000+</h3>
                        <p class="grid-parag">Довольных клиентов</p>
                    </div>
                    <div class="grid3 grid">
                        <h3 class="grid-title">20 лет</h3>
                        <p class="grid-parag">В индустрии автодизайна</p>
                    </div>
                    <div class="grid4 grid">
                        <h3 class="grid-title">500</h3>
                        <p class="grid-parag">Уникальных проектов</p>
                    </div>
                    <div class="grid5 grid-mac">
                        <p class="grid__title-mac">НЕВОЗМОЖНОЕ ВОЗМОЖНО</p>
                        <p class="grid__parag-mac">Для нас важен каждый клиент, поэтому мы делаем все, чтобы вы остались
                            довольны</p>
                        <a href="#" class="grid-link openModalBtn" data-service="Консультация">Консультация</a>
                    </div>
                </div>
                <br>
                <h2 id="section1" class="title">Наши работы</h2>
                <div class="works-grid">
                    <?

                    use controller\Constr;

                    $video = Constr::getVideo();
                    foreach ($video as $item):
                    ?>
                        <div class="video-wrapper">
                            <video controls>
                                <source src="<?= $item['VideoUrl'] ?>"
                                    type="video/webm" />
                        </div>
                    <? endforeach ?>
                </div>
            </section>
        </div>
        <div class="container">
            <section id='section4' class="main_section-servises">
                <h2 class="title">Наши услуги</h2>
                <div class="section_servises-grid">
                    <a href="/categories" class="servises_grid1">
                        <div class="content_animation1 animation">
                            <p class="anmation_title">3D коврики</p>
                            <p class="description"> Создают дополнительный комфорт в салоне автомобиля. Практичны в период эксплуатации автомобиля, легко ухаживать, просто протерев влажной тряпкой. Изготовлены из качественной Эко-кожи, приближенной к натуральной, при этом прочнее, не царапается, не боится влаги и не вышаркивается со временем.
                            </p>
                        </div>
                    </a>

                    <a href="/usl" class="servises_grid2">
                        <div class="content_animation2 animation">
                            <p class="anmation_title">Детелинг</p>
                            <p class="description">Приведите свой автомобиль в идеальное состояние с нашими услугами. Мы предлагаем профессиональную химчистку, которая удалит все загрязнения и запахи, оставив ваш салон свежим и чистым. Наша полировка подарит вашему авто ни с чем не сравнимый вид. А для любителей комфорта мы предлагаем реставрацию кожи, которая вернет эластичность и яркость вашим сиденьям.</p>
                        </div>
                    </a>

                    <a href="/usl" class="servises_grid3">
                        <div class="content_animation3 animation">
                            <p class="anmation_title">Оклейка и бронирование</p>
                            <p class="description">Выполняем работы по изменению цвета и <br> бронированию кузова вашего автомобиля, мотоцикла, снегохода, <br>холодильника, кофеварки и еще много чего другого. <br> Наши мастера умеют удивлять</p>
                        </div>
                    </a>
                </div>
            </section>
        </div>

        <div class="container">
            <section id='section3' class="contacts">

                <h2 class="title">Наши контакты</h2>
                <div class="contacts_container">


                    <div class="contacts__number-container">
                        <div class="contacts__number-item">
                            <img src="/view/general/images/phone.svg" alt="">
                            <p class="text">Номер телефона</p>
                            <p class="val">+7 923 355 33-55</p>
                            <p class="footer-link" href="/#section3">+7 923 355 33-55</p>
                            <p class="footer-link" href="/#section3">+7 391 241 7478</p>
                        </div>
                        <div class="contacts__number-item">
                            <img src="/view/general/images/email.svg" alt="">
                            <p class="text">Почта</p>
                            <p class="val">24magnifico@bk.ru</p>
                        </div>
                        <div class="contacts__number-item">
                            <img src="/view/general/images/Whatsapp.svg" alt="">
                            <p class="text">Whatsapp</p>
                            <p class="val">+7 923 355 33-55</p>
                        </div>
                        <div class="contacts__number-item">
                            <img src="/view/general/images/geo.svg" alt="">
                            <p class="text">Наш офис</p>
                            <p class="val">ул. Мичурина 2Ж</p>
                        </div>
                    </div>


                    <div class="contacts__map-container">
                        <div class="map-container">

                            <iframe class="map-frame"
                                src="https://yandex.ru/map-widget/v1/?ll=92.959628%2C56.013961&mode=poi&poi%5Bpoint%5D=92.959337%2C56.014127&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D216580811078&z=12"
                                frameborder="1" allowfullscreen="true"></iframe>
                        </div>
                    </div>

                </div>

            </section>
        </div>
    </main>
    <? include 'view/assets/footer/footer.html' ?>



    <script src="view/pages/home/home.js"></script>
    </body>

    </html>