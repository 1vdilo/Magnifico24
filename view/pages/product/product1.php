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
	<?
	include 'view/assets/header/header.html';

	use controller\Product;
	use controller\GetTitle;

	$productsID = intval($_GET['productsID']);
	$productVariants = Product::getProductsVariants($productsID);
	?>
	<main class="main">
		<div class="container">
			<div class="product__card-container">
				<div class="card__image-items">
					<div class="image__item-min">
						<?
						$imgs = Product::getProductsVariants($_GET['productsID']);

						foreach ($imgs as $img) {
						?>
							<?
							$oneProduct = Product::getProduct($_GET['productsID']);
							foreach ($oneProduct as $image):
							?>
								<img src="<?= $image['ImageURL'] ?>" alt="товар"
									class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
							<? endforeach ?>
							<img src="<?= $img['image1'] ?>" alt="товар"
								class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
							<img src="<?= $img['image2'] ?>" alt="товар"
								class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
							<img src="<?= $img['image3'] ?>" alt="товар"
								class="small-image" width="150" height="130" onclick="changeMainContent(this, 'image')">
							<video id="defaultVideo" src="<?= $img['video'] ?>"
								class="small-image" width="150" height="130" onclick="changeMainContent(this, 'video')" controls muted></video>
					</div>
				<?
						}
				?>
				<div class="image__item-max">
					<img id="mainImage" src="https://via.placeholder.com/500x510/123456" alt="Main Image" style="display:none;">
					<video id="mainVideo" width="460" height="480" controls autoplay muted style="display:block;">
						<source src="https://test-videos.co.uk/vids/bigbuckbunny/mp4/h264/360/Big_Buck_Bunny_360_10mb.mp4" type="video/mp4">
					</video>
				</div>
				</div>


				<?
				foreach ($oneProduct as $specifications) {
				?>
					<div class="card__inform-container">
						<?
						foreach ($oneProduct as $product_title) {
						?>
							<h2 class="card-title"><?= $product_title['descriptions'] ?></h2>
						<?
						}
						?>
						<div class="card-container">
							<div class="card-name">
								<p class="card__name-p">Модел автомобиля</p>
								<p class="card__name-p">Год выпуска</p>
								<p class="card__name-p">Материал</p>
								<p class="card__name-p">Цена</p>
							</div>
							<div class="card-value">
								<p class="card__value-p"><?= $specifications['title'] ?></p>
								<p class="card__value-p"><?= $specifications['years'] ?> год</p>
								<p class="card__value-p"><?= GetTitle::titleMaterials($specifications['materialsID'])  ?></p>
								<p class="card__value-p"><?= $specifications['price'] ?> ₽</p>
							</div>
						</div>
						<h2 class="color__card-title">Выберите цвет ковриков</h2>
						<form action="/addToCart_form" class="card-form" method='post'>
							<div class="color__card-container">
								<?
								$colors = Product::getColors($specifications['materialsID']);
								foreach ($colors as $colour):
								?>
									<input type="radio" name="colour" value='<?= $colour['title'] ?>' id="<?= $colour['title'] ?>" style="display:none;">
									<label for="<?= $colour['title'] ?>">
										<img src="<?= $colour['img'] ?>" alt="" class="color-card-item" width="50" height="50" onclick="selectColor(this, '<?= $colour['title'] ?>')">
									</label>

								<? endforeach ?>
							</div>
							<br>
							<label class="filter-label">
								<input type="radio" name="equipment" class="filter-checkbox" value="full_set"> Комплект на весь салон
							</label>
							<label class="filter-label">
								<input type="radio" name="equipment" class="filter-checkbox" value="driver_passenger"> Водитель + пассажир
							</label>
							<?
							foreach ($productVariants as $variant):
							?>
								<input type="hidden" name="productsID" value="<?= $variant['products_variantsID'] ?>">
							<? endforeach ?>
							<input type="hidden" name="userID" value="<?= @$_SESSION['user']['userID'] ?>">
							<button class="card__form-button" type="submit">В корзину</button>
						</form>
					<?
				}
					?>
					</div>
			</div>
			<div class="card__description-content">
				<p class="card__description-title">Описание</p>
				<p class="card__description-text">
					<?
					foreach ($productVariants as $product) {
						echo $product['big_description'];
					}
					?>
					<br><br>
			</div>
		</div>
	</main>
	<?
	include 'view/assets/footer/footer.html';
	?>
	<script src="view/pages/product/product.js"></script>
</body>

</html>