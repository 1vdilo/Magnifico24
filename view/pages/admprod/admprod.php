<?
if (!isset($_SESSION['user'])) {
		header('Location: /registration');
	}if($_SESSION['user']['role'] == 0){
		header('Location: /');
	}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/view/general/styles/normolize.css">
    <link rel="stylesheet" href="/view/pages/admprod/admprod.css">

    <title>Document</title>
</head>
<?

include 'view/assets/header/headerADM.html'; ?>

<body>
    <?

    use controller\Adm;

    $productsID = intval($_GET['productsID']);
    $products = Adm::GetProduct($productsID);

    $productsVariants = Adm::GetProductVariants($productsID);
    ?>
    <div class="container">
        <h2>Панель администратора | Карточка товара</h2>
        <div class="table-container">

            <div class="table-container">
                <form action="/update_form" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>Атрибут</th>
                                <th>Значение</th>
                                <th>Изменить</th>
                            </tr>
                        </thead>
                        <?
                        foreach ($products as $product) {
                        ?>
                            <tbody>
                                <tr>
                                    <td>ID продукта</td>
                                    <td><?= $product['productsID'] ?></td>
                                    <td><input type="hidden" name="productsID" value='<?= $product['productsID'] ?>'></td>
                                </tr>
                                <tr>
                                    <td>ID категории</td>
                                    <td><?= $product['categoriesID'] ?></td>
                                    <td><input type="number" value='<?= isset($_GET['productsID']) ? $product['categoriesID'] : '' ?>' name="categoriesID" /></td>
                                </tr>
                                <tr>
                                    <td>ID модели авто</td>
                                    <td><?= $product['car_modelsID'] ?></td>
                                    <td><input type="number" value='<?= isset($_GET['productsID']) ? $product['car_modelsID'] : '' ?>' name='car_modelsID' /></td>
                                </tr>
                                <tr>
                                    <td>Наименование</td>
                                    <td><?= $product['title'] ?></td>
                                    <td><input type="text" value='<?= isset($_GET['productsID']) ? $product['title'] : '' ?>' name='title' /></td>
                                </tr>
                                <tr>
                                    <td>Краткое описание</td>
                                    <td><?= $product['descriptions'] ?></td>
                                    <td><input type="text" value='<?= isset($_GET['productsID']) ? $product['descriptions'] : '' ?>' name='descriptions' /></td>
                                </tr>
                                <tr>
                                    <td>ID материала</td>
                                    <td><?= $product['materialsID'] ?></td>
                                    <td><input type="number" value='<?= isset($_GET['productsID']) ? $product['materialsID'] : '' ?>' name='materialsID' /></td>
                                </tr>
                                <tr>
                                    <td>Год выпуска авто</td>
                                    <td><?= $product['years'] ?></td>
                                    <td><input type="number" value='<?= isset($_GET['productsID']) ? $product['years'] : '' ?>' name='years' /></td>
                                </tr>
                                <tr>
                                    <td>Цена</td>
                                    <td><?= $product['price'] ?></td>
                                    <td><input type="text" value='<?= isset($_GET['productsID']) ? $product['price'] : '' ?>' name='price' /></td>
                                </tr>
                                <?
                                foreach ($productsVariants as $prodVar) {
                                ?>
                                    <tr>
                                        <td>Описание продукта</td>
                                        <td><?= $prodVar['big_description'] ?></td>
                                        <td>
                                            <textarea rows='6' name="big_description" value='<?= isset($_GET['productsID']) ? $prodVar['big_description'] : '' ?>'><?= isset($_GET['productsID']) ? $prodVar['big_description'] : '' ?></textarea>
                                        </td>
                                    </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        <?
                        }
                        ?>
                    </table>
                    <button type="submit" class="submit-button">Сохранить</button>
                </form>
                <form action="/update_img" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>ID продукта</td>
                        <td><?= $product['productsID'] ?></td>
                        <td><input type="hidden" name="productsID" value='<?= $product['productsID'] ?>'></td>
                    </tr>
                    <tr>
                        <td>Основное фото</td>
                        <td><img src="<?= $product['ImageURL'] ?>" alt="" style="width: 180px; height: 180px;"></td>
                        <td><input type="file" name="productImage" /></td>
                    </tr>
                    <tr>
                        <td>Фото карточки товара 1</td>
                        <td><img src="<?= $prodVar['image1'] ?>" alt="" style="width: 180px; height: 180px;"></td>
                        <td><input type="file" name="productImage1" /></td>
                    </tr>
                    <tr>
                        <td>Фото карточки товара 2</td>
                        <td><img src="<?= $prodVar['image2'] ?>" alt="" style="width: 180px; height: 180px;"></td>
                        <td><input type="file" name="productImage2" /></td>
                    </tr>
                    <tr>
                        <td>Фото карточки товара 3</td>
                        <td><img src="<?= $prodVar['image3'] ?>" alt="" style="width: 180px; height: 180px;"></td>
                        <td><input type="file" name="productImage3" /></td>
                    </tr>
                    <button type="submit" class="submit-button">Сохранить</button>
                </form>

                <form action="/update_video_form" method='post' enctype="multipart/form-data">
                    <tr>
                        <td>ID продукта</td>
                        <td><?= $product['productsID'] ?></td>
                        <td><input type="hidden" name="productsID" value='<?= $product['productsID'] ?>'></td>
                    </tr>
                    <tr>
                        <td>Видео</td>
                        <td><video src="<?= $prodVar['video'] ?>" alt="" style="width: 180px; height: 180px;"></td></video>
                        <td><input type="file" name="video" /></td>
                    </tr>
                    <button type="submit" class="submit-button">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>