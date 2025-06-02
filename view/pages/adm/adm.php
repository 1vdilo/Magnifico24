<?php
if (!isset($_SESSION['user'])) {
	header('Location: /registration');
}
if ($_SESSION['user']['role'] == 0) {
	header('Location: /');
}

use controller\Adm;
use controller\Catalog;
use controller\GetTitle;

include 'view/assets/header/headerADM.html';

$products = Adm::GetProducts();
$cout = count($products);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="view/general/styles/normolize.css">
	<link rel="stylesheet" href="view/pages/adm/adm.css">
	<title>admin</title>
</head>

<body>
	<main class="main">
		<h2 class="main__header">Панель администратора</h2>
		<div class="main-wrapper">
			<div class="main__content">
				<div class="main__panel">
					<table class="panel-table">
						<tr class="table__header-row">
							<td class="photo">Фото</td>
							<td class="brand">ID товара</td>
							<td class="brand">Категория</td>
							<td class="name">Модель авто</td>
							<td class="category">Наименование</td>
							<td class="size">Описание</td>
							<td class="price">Материал</td>
							<td class="quantity">Год выпуска</td>
							<td class="quantity">Цена</td>
							<td class="price">Удаление</td>
							<td class="price">Изменение</td>
							<td class="fill-form-header">Дублировать</td>
						</tr>
						<tbody>
							<?php foreach ($products as $product) { ?>
								<tr>
									<td><img src="<?= $product['ImageURL'] ?>" alt="" style="width: 80px; height: 80px;"></td>
									<td><?= $product['productsID'] ?></td>
									<td><?= GetTitle::titleCategories($product['categoriesID']) ?></td>
									<td><?= GetTitle::titleCarModels($product['car_modelsID']) ?></td>
									<td><?= $product['title'] ?></td>
									<td><?= $product['descriptions'] ?></td>
									<td><?= GetTitle::titleMaterials($product['materialsID']) ?></td>
									<td><?= $product['years'] ?></td>
									<td><?= $product['price'] ?></td>
									<td>
										<form action="/dell_form" method="POST">
											<input type="hidden" name="dellID" value='<?= $product['productsID'] ?>'>
											<button type="submit" class="delete-button">Удалить</button>
										</form>
									</td>
									<td><a class="update-button" href="/admprod?productsID=<?= $product['productsID'] ?>">Изменить</a></td>
									<td>
										<?php $prodVar = Adm::GetProductVariants($product['productsID'])[0] ?? []; ?>
										<button
											type="button"
											class="fill-form-button"
											data-category="<?= $product['categoriesID'] ?>"
											data-title="<?= htmlspecialchars($product['title']) ?>"
											data-desc="<?= htmlspecialchars($product['descriptions']) ?>"
											data-model="<?= $product['car_modelsID'] ?>"
											data-material="<?= $product['materialsID'] ?>"
											data-years="<?= $product['years'] ?>"
											data-price="<?= $product['price'] ?>"
											data-big_description="<?= htmlspecialchars($prodVar['big_description'] ?? '') ?>">Дублировать</button>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<button class="save-button button">Количество товаров: <?= $cout ?></button>
			</div>

			<div class="form-wrapper">
				<form class="panel-form" method="post" action="/add_form" enctype="multipart/form-data">
					<?php $category = Catalog::getCategories(); ?>
					<label for="brand">Категория</label>
					<select name="categoriesID" id="form-category" required>
						<?php foreach ($category as $item) { ?>
							<option value="<?= $item['categoriesID'] ?>"><?= $item['title'] ?></option>
						<?php } ?>
					</select>

					<label for="name">Название товара</label>
					<input type="text" name="title" id="form-title" required>

					<label for="descriptions">Описание</label>
					<input type="text" name="descriptions" id="form-desc" required>

					<label for="models">Модель авто</label>
					<select name="car_modelsID" id="form-model" required>
						<?php $car_models = Adm::getModels();
						foreach ($car_models as $model): ?>
							<option value="<?= $model['car_modelsID'] ?>">
								<?= $model['brand_title'] . ' ' . $model['model_title'] ?>
							</option>
						<?php endforeach ?>
					</select>


					<label for="material">Материал</label>
					<select name="materialsID" id="form-material" required>
						<?php $mater = Adm::getMaterials();
						foreach ($mater as $item): ?>
							<option value="<?= $item['materialsID'] ?>"><?= $item['title'] ?></option>
						<?php endforeach ?>
					</select>

					<label for="years">Год выпуска</label>
					<input type="number" name="years" id="form-years" required>

					<label for="price">Цена</label>
					<input type="text" name="price" id="form-price" class="product-price" required>

					<label for="fulldescriptions">Полное описание товара</label>
					<textarea rows='6' name="big_description" id="form-big_description"></textarea><br>

					<label for="foto">Основное фото товара</label>
					<input type="file" name="productImage" required>

					<label for="foto">Фотография карточки товара 1</label>
					<input type="file" name="productImage1" required>

					<label for="foto">Фотография карточки товара 2</label>
					<input type="file" name="productImage2" required>

					<label for="foto">Фотография карточки товара 3</label>
					<input type="file" name="productImage3" required>

					<label for="video">Видео</label>
					<input type="file" name="video" required>

					<button class="form__add-button button" type="submit">Добавить</button>
				</form>
			</div>
		</div>
	</main>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const buttons = document.querySelectorAll('.fill-form-button');

			buttons.forEach(button => {
				button.addEventListener('click', () => {
					document.getElementById('form-category').value = button.dataset.category;
					document.getElementById('form-title').value = button.dataset.title;
					document.getElementById('form-desc').value = button.dataset.desc;
					document.getElementById('form-model').value = button.dataset.model;
					document.getElementById('form-material').value = button.dataset.material;
					document.getElementById('form-years').value = button.dataset.years;
					document.getElementById('form-price').value = button.dataset.price;
					document.getElementById('form-big_description').value = button.dataset.big_description;

					document.querySelector('.form-wrapper').scrollIntoView({
						behavior: 'smooth'
					});
				});
			});
		});
	</script>
</body>

</html>