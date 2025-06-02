<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/view/general/styles/normolize.css">
	<link rel="stylesheet" href="/view/pages/product/product.css">
	<title>Карточка товара</title>
</head>


<body>
	<?php
	include 'view/assets/header/header.html';

	use controller\Product;
	use controller\GetTitle;
	use controller\Adm;
	use controller\Constr;

	$productsID = intval($_GET['productsID']);
	$productVariants = Product::getProductsVariants($productsID);
	?>
	<main class="main">
		<div class="container">
			<div class="product__card-container">
				<div class="card-image-block">
					<div class="aa">
						<div class="card__image-items">
							<div class="image__item-min">
								<?php
								$imgs = Product::getProductsVariants($_GET['productsID']);

								foreach ($imgs as $img) {
								?>
									<?php
									$oneProduct = Product::getProduct($_GET['productsID']);
									foreach ($oneProduct as $image) :
									?>
										<img src="<?= $image['ImageURL'] ?>" alt="товар" class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
									<?php endforeach ?>
									<img src="<?= $img['image1'] ?>" alt="товар" class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
									<img src="<?= $img['image2'] ?>" alt="товар" class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
									<img src="<?= $img['image3'] ?>" alt="товар" class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
									<video id="defaultVideo" src="<?= $img['video'] ?>" class="small-image" width="150" height="130" onclick="changeMainContent(this, 'video')" controls muted></video>
							</div>
						<?php
								}
						?>
						<div class="image__item-max">
							<img id="mainImage" src="https://via.placeholder.com/500x510/123456" alt="Main Image" style="display:none;">
							<video id="mainVideo" width="460" height="480" controls autoplay muted style="display:block;">
								<source src="https://test-videos.co.uk/vids/bigbuckbunny/mp4/h264/360/Big_Buck_Bunny_360_10mb.mp4" type="video/mp4">
							</video>
						</div>
						</div>
					</div>
					<div class="ss">
						<div class="card__description-content">
							<p class="card__description-title">Описание</p>
							<p class="card__description-text">
								<?php
								foreach ($productVariants as $product) {
									echo $product['big_description'];
								}
								?>
								<br><br>
						</div>
					</div>
				</div>

				<?php
				foreach ($oneProduct as $specifications) {
				?>
					<div class="card__inform-container">
						<?php
						foreach ($oneProduct as $product_title) {
						?>
							<h2 class="card-title"><?= $product_title['descriptions'] ?></h2>
						<?php
						}
						?>
						<div class="card-container">
							<div class="card-name">
								<p class="card__name-p">Модель автомобиля</p>
								<p class="card__name-p">Год выпуска</p>
								<p class="card__name-p">Материал</p>
								<p class="card__name-p">Цена</p>
							</div>
							<div class="card-value">
								<? $result = GetTitle::getModelAndBrandByModelID($specifications['car_modelsID'])  ?>
								<? if($result['brand_title'] == 'Универсальный'){ ?> 

								<p class="card__value-p"><?= $result['brand_title'] ?></p>
								<? }else{ ?>
								<p class="card__value-p"><?= $result['brand_title'] . ' ' . $result['model_title'] ?></p>
								<? } ?>
								<p class="card__value-p"><?= $specifications['years'] ?> год</p>
								<p class="card__value-p"><?= GetTitle::titleMaterials($specifications['materialsID']) ?></p>
								<p class="card__value-p"><span id="product-price"><?= $specifications['price'] ?></span></p>

							</div>
						</div>
						<div>
							<form action="/addToCart_form" class="card-form" method='post'>
								<?
								if ($specifications['categoriesID'] == 2) { ?>

									<?php $colors = Product::getColors($specifications['materialsID']); //материал верхнего слоя
									?>
									<?php $topMaterials = Product::getTopMaterials(); ?>
									<input type="hidden" name="topMaterialsID" value='<?= '' ?>'>
									<?php $topColors = Product::getTopColors(); //цвет верхнего слоя
									?>
									<input type="hidden" name="topLayerID" value='<?= '' ?>'>

									<h2 class="color__card-title">Выберите цвет</h2>
									<div id="chooseColor" class="color__card-container">
										<?php foreach ($colors as $colour) : ?>
											<input type="radio" name="colourIMG" value='<?= $colour['img'] ?>' id="<?= $colour['img'] ?>" required>
											<label for="<?= $colour['img'] ?>">
												<img src="<?= $colour['img'] ?>" alt="" class="color-card-item color-item" width="50" height="50">
												<p class="color-card_text"> <?= $colour['title'] ?></p>
											</label>
										<?php endforeach; ?>
									</div>
								<?  } elseif ($specifications['categoriesID'] == 3) { ?>

									<?php $colors = Product::getColors($specifications['materialsID']); //материал верхнего слоя
									?>
									<?php $topMaterials = Product::getTopMaterials(); ?>
									<input type="hidden" name="topMaterialsID" value='<?= '' ?>'>
									<?php $topColors = Product::getTopColors(); //цвет верхнего слоя
									?>
									<input type="hidden" name="topLayerID" value='<?= '' ?>'>

									<input type="hidden" name="colour" value='<?= '' ?>' style="display:none;">
									<input type="hidden" name="colourIMG" value='<?= '' ?>' style="display:none;">
								<? } else { ?>
									<?php $colors = Product::getColors($specifications['materialsID']); ?>
									<h2 class="color__card-title">Выберите материал верхнего слоя</h2>
									<?php $topMaterials = Product::getTopMaterials(); ?>
									<div id="topMaterials" class="color__card-container">
										<?php foreach ($topMaterials as $topMaterial) : ?>

											<input type="radio" name="topMaterialsID" value="<?= $topMaterial['title'] ?>" id="material-<?= $topMaterial['imgURL'] ?>" required>
											<label for="material-<?= $topMaterial['imgURL'] ?>">
												<img src="<?= $topMaterial['imgURL'] ?>" alt="" class="color-card-item top-material-item" width="50" height="50" data-top-material-id="<?= $topMaterial['imgURL'] ?>" onclick="loadColors(<?= $topMaterial['imgURL'] ?>); selectTopMaterial(this)">
												<p class="color-card_text"> <?= $topMaterial['title'] ?></p>

											</label>
										<?php endforeach; ?>
									</div>
									<?php
									$topColors = Constr::getTopLayerColour();

									// Группируем цвета по названию материала
									$groupedColors = [];

									foreach ($topColors as $color) {
										$material = $color['material_title'];
										if (!isset($groupedColors[$material])) {
											$groupedColors[$material] = [];
										}
										$groupedColors[$material][] = $color;
									}
									?>




									<h2 class="color__card-title">Выберите цвет верхнего слоя</h2>
									<?php foreach ($groupedColors as $material => $colorsTop): ?>
										<div class="material-section">

											<h3><?= htmlspecialchars($material) ?></h3> <!-- заголовок -->
											<div id="topColors" class="color__card-container-r">

												<div class="color-group new-line">

													<?php foreach ($colorsTop as $topColor): ?>
														<input type="radio" name="topLayerID" value="<?= $topColor['imgURL'] ?>" id="topcolor-<?= $topColor['imgURL'] ?>" required>
														<div class="b">

															<label class="new__lable" for="topcolor-<?= $topColor['imgURL'] ?>"> <!-- круги -->
																<img
																	src="<?= $topColor['imgURL'] ?>"
																	alt=""
																	class="color-card-item top-material-item"
																	width="50" height="50"
																	data-top-material-id="<?= $topColor['imgURL'] ?>"
																	onclick="loadColors('<?= $topColor['imgURL'] ?>'); selectTopMaterial(this)">
																<p class="color-card_text"><?= htmlspecialchars($topColor['colour_title']) ?></p>
															</label>
														</div>


													<?php endforeach; ?>

												</div>
											</div>
										<?php endforeach; ?>
										</div>








										<h2 class="color__card-title">Выберите цвет</h2>
										<div id="chooseColor" class="color__card-container">
											<?php foreach ($colors as $colour) : ?>
												<input type="radio" name="colourIMG" value='<?= $colour['img'] ?>' id="<?= $colour['img'] ?>" required>
												<label for="<?= $colour['img'] ?>">
													<img src="<?= $colour['img'] ?>" alt="" class="color-card-item color-item" width="50" height="50">
													<p class="color-card_text"> <?= $colour['title'] ?></p>
												</label>
											<?php endforeach; ?>
										</div>
									<? } ?>
									<br>
									<?php
									foreach ($productVariants as $variant) :
									?>
										<input type="hidden" name="productsID" value="<?= $variant['products_variantsID'] ?>">
									<?php endforeach ?>
									<input type="hidden" name="userID" value="<?= @$_SESSION['user']['userID'] ?>">
									<input type="hidden" name="equipment" value="full_set">
									<button class="card__form-button" type="submit">В корзину</button>
								<?php
							}
								?>
						</div>
						</form>
					</div>
			</div>

		</div>
	</main>
	<?php
	include 'view/assets/footer/footer.html';
	?>
	<script src="view/pages/product/product.js"></script>



</html>