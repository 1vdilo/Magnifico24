<?
if (!isset($_SESSION['user'])) {
	header('Location: /registration');
}
if ($_SESSION['user']['role'] == 0) {
	header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/view/pages/admconstr/admconstr.css">
	<title>Document</title>
</head>

<body>
	<header>
		<?php include 'view/assets/header/headerADM.html'; ?>
	</header>
	<div class="container">

		<h1>Загрузка видео на главной странице</h1>
		<?php

		use controller\Constr;
		use controller\Catalog;
		use controller\Adm;
		use controller\GetTitle;

		$video = Constr::getVideo();

		$cout = 1;
		foreach ($video as $item) :
		?>
			<form action='/addHomeVideo_form' enctype="multipart/form-data" method="post">
				<p class='qwe'><? echo "видео " . $cout++ ?></p>
				<input type="file" name="video">
				<input type="hidden" name="videoID" value='<?= $item['id'] ?>'>
				<button>Отправить</button>
			</form>
		<?php endforeach ?>

		<h2>Услуги</h2>
		<?php
		$servises = Constr::getServises();
		?>
		<form action="/upServises_form" method="post">

			<select name="servicesID">
				<? foreach ($servises as $usl) : ?>
					<option value="<?= $usl['servicesID'] ?>"><?= $usl['title'] ?></option>
				<?php endforeach ?>
			</select>

			<input type="text" name="title" placeholder='Название'>
			<input type="text" name="description" placeholder='Описание'>
			<input type="text" name="price" placeholder='Обознчте новую цену'>
			<button>Изменить цену</button>
		</form>

		<?
		$carBrands = Catalog::getCarBrand();
		?>
		<h2>Марка автомобиля</h2>
		<form action="/addCarBrands_form" method="post">
			<select>
				<? foreach ($carBrands as $brand): ?>
					<option><?= $brand['title'] ?></option>
				<? endforeach ?>
			</select>
			<input type="text" name="carBrands" placeholder='Марка авто'>
			<button>Добавить маку авто</button>
		</form>

		<h2>Удалить марку автомобиля</h2>
		<form action="/dellCarBrands_form" method="post">
			<select name='brand_title'>
				<? foreach ($carBrands as $brand): ?>
					<option value='<?= $brand['title'] ?>'><?= $brand['title'] ?></option>
				<? endforeach ?>
			</select>
			<button>Удалить марку авто</button>
		</form>

		<h2>Добавить модель авто</h2>
		<?
		// $carModels = Constr::getModel();

		?>
		<form action="/addCarModel_form" method="post">
			<select name='car_brandsID'>
				<? foreach ($carBrands as $model): ?>
					<option name='carModel' value='<?= $model['car_brandsID'] ?>'><?= $model['title'] ?></option>
				<? endforeach ?>
			</select>
			<input type="text" name="carModel" placeholder='Model авто'>
			<button>Добавить модель авто</button>
		</form>

		<?
		$carModels = Adm::getModels();
		?>
		<h2>Удалить модель автомобиля</h2>
		<form action="/dellCarModels_form" method="post">
			<select name='model_title'>
				<? foreach ($carModels as $model): ?>
					<option value='<?= $model['model_title'] ?>'><?= $model['brand_title'] . ' ' . $model['model_title'] ?></option>
				<? endforeach ?>
			</select>
			<button>Удалить модель авто</button>
		</form>

		<h2>Добавить Материал верхнего слоя</h2>
		<form action='/addTopMaterials' enctype="multipart/form-data" method="post">
			<input type="text" name="title" required placeholder='Название'>
			<input type="file" name="video" required>
			<button>Загрузить материал верхнего слоя</button>
		</form>


		<?
		$topMat = Constr::getTopMaterials();
		?>

		<h2>Добавить цвет верхнего слоя</h2>

		<form action='/addTopColors' enctype="multipart/form-data" method="post">
			<select name="topMaterials">
				<? foreach($topMat as $mater): ?>
				<option value="<?=$mater['TopLayerMaterialsID']?>"><?=$mater['title']?></option>
				<? endforeach ?>
			</select>
			<input type="text" name="title" required placeholder='Название'>
			<input type="file" name="video" required>
			<button>Загрузить цвет</button>
		</form>

		<h2>Добавить Материал основного слоя слоя</h2>
		<form action='/addMaterials' enctype="multipart/form-data" method="post">
			<input type="text" name="title" required placeholder='Название'>
			<button>Загрузить материал основного слоя</button>
		</form>

		<h2>Добавить цвет основного слоя</h2>
		<?php
		$Materials = Constr::getMaterials();
		?>
		<form action='/addColors' enctype="multipart/form-data" method="post">
			<input type="text" name="title" required placeholder='Название'>
			<input type="file" name="video" required>
			<select name="materialsID">
				<?php foreach ($Materials as $top) : ?>
					<option value="<?= $top['materialsID'] ?>"><?= $top['title'] ?></option>
				<?php endforeach ?>
			</select>
			<button>Загрузить цвет</button>
		</form>

		<h2>Материал верхнего слоя</h2>


		<table>
			<tr>
				<td>ID</td>
				<td>Название</td>
				<td>Цвет</td>
				<td>Удалить</td>
			</tr>
			<? foreach ($topMat as $top): ?>
				<tr>
					<td><?= $top['TopLayerMaterialsID'] ?></td>
					<td><?= $top['title'] ?></td>
					<td><img src="<?= $top['imgURL'] ?>" alt="" style="width: 80px; height: 80px;"></td>
					<td>
						<form action="/deleteTop" method="post">
							<input type="hidden" name="TopID" value='<?= $top['TopLayerMaterialsID'] ?>'>
							<button>удалить</button>
						</form>
					</td>
				</tr>
			<? endforeach ?>
		</table>


		<h2>Цвета верхнего слоя</h2>

		<?
		$topCol = Constr::getTopLayerColour();
		?>
		<table>
			<tr>
				<td>ID</td>
				<td>Материал</td>
				<td>Название</td>
				<td>Цвет</td>
				<td>Удалить</td>
			</tr>
			<? foreach ($topCol as $col): ?>
				<tr>
					<td><?= $col['topLayerID'] ?></td>
					<td><?=$col['material_title']?></td>
					<td><?= $col['colour_title'] ?></td>
					<td><img src="<?= $col['imgURL'] ?>" alt="" style="width: 80px; height: 80px;"></td>
					<td>
						<form action="/deleteTopCol" method="post">
							<input type="hidden" name="TopColID" value='<?= $col['topLayerID'] ?>'>
							<button>удалить</button>
						</form>
					</td>
				</tr>
			<? endforeach ?>
		</table>


		<h2>Основной слой</h2>

		<?
		$topCol = Constr::getMaterials();
		?>
		<table>
			<tr>
				<td>ID</td>
				<td>Название</td>
				<td>Удалить</td>
			</tr>
			<? foreach ($topCol as $col): ?>
				<tr>
					<td><?= $col['materialsID'] ?></td>
					<td><?= $col['title'] ?></td>

					<td>
						<form action="/deleteCol" method="post">
							<input type="hidden" name="materialsID" value='<?= $col['materialsID'] ?>'>
							<button>удалить</button>
						</form>
					</td>
				</tr>
			<? endforeach ?>
		</table>

		<h2>Цвета основного слоя</h2>

		<?
		$topCol = Constr::getColor();
		?>
		<table>
			<tr>
				<td>ID</td>
				<td>Материал</td>
				<td>Название</td>
				<td>Цвет</td>
				<td>Удалить</td>
			</tr>
			<? foreach ($topCol as $col): ?>
				<tr>
					<td><?= $col['colourID'] ?></td>
					<td><?= $col['material_title'] ?></td>
					<td><?= $col['colour_title'] ?></td>
					<td><img src="<?= $col['img'] ?>" alt="" style="width: 80px; height: 80px;"></td>
					<td>
						<form action="/deleteCol" method="post">
							<input type="hidden" name="colourID" value='<?= $col['colourID'] ?>'>
							<button>удалить</button>
						</form>
					</td>
				</tr>
			<? endforeach ?>
		</table>
	</div>

	</div>
</body>

</html>