<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/general/styles/normolize.css">
    <link rel="stylesheet" href="view/pages/catalog/catalog.css">
    <link rel="stylesheet" href="view/pages/home/home.css">

    <title>Каталог</title>
</head>

<body>
    <?php

    use controller\Catalog;
    use controller\GetTitle;

    include 'view/assets/header/header.html';

    // Фильтры, полученные из GET-запроса
    $filters = [
        'categoriesID' => $_GET['categoriesID'] ?? null,
        'car_brandsID' => $_GET['car_brandsID'] ?? null,
        'car_modelsID' => $_GET['car_modelsID'] ?? null,
        'materialsID' => $_GET['materialsID'] ?? null,
        'priceMin' => $_GET['priceMin'] ?? null,
        'priceMax' => $_GET['priceMax'] ?? null,
    ];

    // Получаем товары, соответствующие фильтрам
    $catalog = Catalog::getFilteredProducts($filters);

    // Если есть поисковый запрос
    if (!empty($_GET['s'])) {
        $searchQuery = $_GET['s'];
        // Получаем товары по поисковому запросу, игнорируя фильтры
        $catalog = Catalog::searchByTitle($searchQuery);
    }

    ?>

    <div>
        <input type="hidden" name="categoriesID" value="<?= $filters['categoriesID'] ?>">
    </div>

    <main class="main">
        <a href="#top" id="back-to-top" class="back-to-top" title="Back to top">▲</a>

        <div class="container">
            <section class="catalog-search">
                <h2 class="catalog-search__title">Каталог товаров</h2>
                <div class="catalog-search__items">
                    <img id="toggle-filters" src="view/general/icons/filter.svg" alt="Фильтр" class="catalog-search__filter">
                    <div id="filter-panel" class="hidden">
                        <form method="get" id="filter-form">
                            <input type="hidden" name="categoriesID" value="<?= $filters['categoriesID'] ?>">

                            <div class="filter-group">
                            <button id="toggle-filter" class="filter-toggle-button">⮜ Скрыть фильтры</button>
                                <h3 class="filter-title">Фильтры</h3>

                                <!-- Фильтр по цене -->
                                <div class="filter-price">
                                    <p class="filter__label-name">Цена</p>
                                    <div class="wrapper">
                                        <div class="price-input">
                                            <div class="field">
                                                <input type="number" name="priceMin" class="input-min" value="<?= $filters['priceMin'] ?? 0 ?>">
                                            </div>
                                            <div class="separator">-</div>
                                            <div class="field">
                                                <input type="number" name="priceMax" class="input-max" value="<?= $filters['priceMax'] ?? 100000 ?>">
                                            </div>
                                        </div>
                                        <div class="slider">
                                            <div class="progress"></div>
                                        </div>
                                        <div class="range-input">
                                            <input type="range" class="range-min" min="0" max="100000" value="<?= $filters['priceMin'] ?? 0 ?>" step="100">
                                            <input type="range" class="range-max" min="0" max="100000" value="<?= $filters['priceMax'] ?? 100000 ?>" step="100">
                                        </div>
                                    </div>
                                </div>

                                <!-- Фильтр по марке -->
                                <div class="filter-price">
                                    <p class="filter__label-name">Марка</p>
                                    <?php
                                    $car_brands = Catalog::getCarBrand();
                                    foreach ($car_brands as $brand) {
                                    ?>
                                        <label class="filter-label">
                                            <input type="radio" class="filter-checkbox brand-filter" name="car_brandsID" value="<?= $brand['car_brandsID'] ?>" <?= $filters['car_brandsID'] == $brand['car_brandsID'] ? 'checked' : '' ?>>
                                            <?= $brand['title'] ?>
                                        </label>
                                    <?php } ?>
                                </div>

                                <!-- Фильтр по модели -->
                                <div class="filter-price">
                                    <p class="filter__label-name">Модель</p>
                                    <select name="car_modelsID" id="car-models">
                                        <option value="">Выберите модель</option>
                                        <?php
                                        $models = [];
                                        if (!empty($filters['car_brandsID'])) {
                                            $models = Catalog::getModels(intval($filters['car_brandsID']));
                                        }
                                        foreach ($models as $model) {
                                        ?>
                                            <option value="<?= $model['car_modelsID'] ?>" <?= $filters['car_modelsID'] == $model['car_modelsID'] ? 'selected' : '' ?>>
                                                <?= $model['title'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <<!-- Фильтр по материалу -->
                                    <div class="filter-price">
                                        <p class="filter__label-name">Материал</p>
                                        <?php
                                        $materials = Catalog::getAllMaterials();
                                        foreach ($materials as $material) {
                                        ?>
                                            <label class="filter-label">
                                                <input type="radio" class="filter-checkbox material-filter" name="materialsID" value="<?= $material['materialsID'] ?>" <?= $filters['materialsID'] == $material['materialsID'] ? 'checked' : '' ?>>
                                                <?= htmlspecialchars($material['title']) ?>
                                            </label>
                                        <?php } ?>
                                    </div>



                                    <!-- Кнопка применить -->
                                    <div>
                                        <button class="product-catalog__button aas" type="submit">Применить фильтры</button>
                                    </div>
                            </div>
                        </form>
                    </div>

                    <!-- Поиск по названию -->
                    <form class="catalog-search__form" action="" method="get">
                        <?php foreach ($filters as $key => $value) {
                            if ($value !== null) { ?>
                                <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                        <?php }
                        } ?>

                        <div class="catalog-search__input-wrapper">
                            <input class="catalog-search__input" name="s" placeholder="Искать здесь..." type="search" value="<?= htmlspecialchars($_GET['s'] ?? '') ?>">
                            <button type="submit" class="catalog-search__submit">
                                <img src="view/general/icons/search.svg" alt="Поиск" class="catalog-search__submit-icon">
                            </button>
                        </div>
                    </form>


                </div>
            </section>

            <div id="catalog-container">
                <section class="product-catalog">
                    <?php foreach ($catalog as $product) { ?>
                        <div class="product-catalog__item">
                            <div class="product-catalog__content">
                                <img src="<?= $product['ImageURL'] ?>" alt="" class="product-catalog__image">
                                <p class="product-catalog__text"><?= $product['descriptions'] ?></p>
                                <p class="product-catalog__text">Год: <?= $product['years'] ?></p>
                                <p class="product-catalog__text">Материал: <?= GetTitle::titleMaterials($product['materialsID']) ?></p>
                                <span class="product-catalog__divider"></span>
                                <div class="product-catalog__bottom">
                                    <div class="product-catalog__price">
                                        <p class="product-catalog__price-value"><?= $product['price'] ?></p>
                                    </div>
                                    <a href="/product?productsID=<?= $product['productsID'] ?>" class="product-catalog__button">Посмотреть</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </section>
            </div>
        </div>
    </main>

    <?php include 'view/assets/footer/footer.html'; ?>
    <script src="view/pages/catalog/catalog.js"></script>
</body>

</html>