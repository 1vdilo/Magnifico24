<?
if (!isset($_SESSION['user'])) {
	header('Location: /registration');
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="view/general/styles/normolize.css">
	<link rel="stylesheet" href="view/pages/basket/basket.css">
	<title>Корзина</title>
</head>

<body>
	<main class="main">
		<?
		error_reporting(0); // Отключает вывод ошибок PHP

		if (!isset($_SESSION['user'])) {
			header('Location: /registration');
		}
		include 'view/assets/header/header.html';
		?>
		<div class="container">
			<h2 class="title">Корзина</h2>
			<div class="main__basket-container">
				<div class="main__basket-contents">
					<?

					use controller\Basket;
					use controller\GetTitle;


					$tovar = Basket::GetOneProd();
					$totalPrice = 0;
					foreach ($tovar as $pozisition):
					?>
						<!-- Товары -->


						<div class="basket__container-item">
							<img src="<?= $pozisition['ImageURL'] ?>" alt="Item" class="basket__item-img">
							<div class="basket__item-details">
								<div class="basket__item-description">
									<h3 class="item-title"><?= $pozisition['title'] ?></h3>
									<? $result = GetTitle::getModelAndBrandByModelID($pozisition['car_modelsID'])  ?>
								<p class="item-model">Для <?= $result['brand_title'] . ' ' . $result['model_title'] ?></p>
								</div>
								<div class="basket__item-properties">
									<p>Материал: <?= GetTitle::titleMaterials($pozisition['materialsID']) ?></p>
									<?
									if ($pozisition['colourIMG'] == null) {
										echo '';
									} else {
									?>
										<div class="color-conainer">
											<p>Цвет: <?= GetTitle::titleColour($pozisition['colourIMG']) ?></p>
											<img width="60" height="20" src="<?= $pozisition['colourIMG'] ?>" alt="">
										</div>
									<? } ?>
									<?
									if ($pozisition['topMaterials'] == '') {
										echo '';
									} else {
									?>
										<p>Материал верхнего слоя: <?= $pozisition['topMaterials'] ?></p>
										<div class="color-conainer">
											<p>Цвет: </p>
											<img width="60" height="20" src="<?= $pozisition['topColourIMG'] ?>" alt="">
										</div>
									<? } ?>

								</div>
							</div>
							<div class="basket__item-controls">

								<div class="quantity-controls">
									<form action="/remove_tovar_form" method="post">
										<input type="hidden" name="tovarID" value='<?= $pozisition['basketID'] ?>'>
										<input type="hidden" name="count" value='<?= $pozisition['quantity'] ?>'>
										<button class="quantity-btn">-</button>
									</form>
									<div class="quantity-value"><?= $pozisition['quantity'] ?></div>
									<form action="/add_tovar_form" method="post">
										<input type="hidden" name="tovarID" value='<?= $pozisition['basketID'] ?>'>
										<input type="hidden" name="count" value='<?= $pozisition['quantity'] ?>'>
										<button class="quantity-btn">+</button>
									</form>
								</div>


								<div class="basket__item-price">
									<? $price = $pozisition['price'] * $pozisition['quantity'];
									$totalPrice += $price;
									?>
									<p class="price-text"><?= $price ?>₽</p>
								</div>
								<form action="/dell_pozition_form" method="post">
									<input type="hidden" name="tovarID" value='<?= $pozisition['basketID'] ?>'>
									<button class="remove-btn">
										<img src="/view/general/icons/delete.svg" alt="удалить товар" width="24" height="24">
									</button>
								</form>
							</div>
						</div>
					<? endforeach; ?>
				</div>

				<!-- Оплата товара -->

				<div class="basket__container-payment">
					<div class="basket__payment-content">
						<h2 class="basket__payment-title">Оформление заказа</h2>
						<form action="/addOrder_form" method="post" class="payment-form">
							<div class="payment-details">
								<div class="payment-item">
									<span class="item-label">Сумма:</span>
									<span class="item-value amount"><?= $totalPrice ?> ₽</span>
									<input type="hidden" name="totalPrice" value='<?= $totalPrice ?>'>
								</div>
								<div class="payment-item">
									<span class="item-label">Дата оформления:</span>
									<? date_default_timezone_set('Asia/Krasnoyarsk'); ?>
									<span class="item-value date"><?= date("F j, Y") ?></span>
									<input type="hidden" name="date" value='<?= date("Y-m-d") ?>'>
								</div>
							</div>

							<div class="comment-section">
								<label for="comment" class="comment-label">Комментарий к заказу:</label>
								<textarea id="comment" name='comment' class="payment-comment" placeholder="Введите ваше сообщение"></textarea>
							</div>
							<?php

							foreach ($tovar as $item): ?>
								<input type="hidden" name="productsID[]" value="<?= $item['products_variantsID'] ?>">

								<input type="hidden" name="topMaterialsID[]" value="<?= $item['topMaterials'] ?>">


								<input type="hidden" name="TopColour[]" value="<?= $item['topColour'] ?>">
								<input type="hidden" name="topLayerID[]" value="<?= $item['topColourIMG'] ?>">

								<input type="hidden" name="colour[]" value="<?= $item['colour'] ?>">
								<input type="hidden" name="colourIMG[]" value="<?= $item['colourIMG'] ?>">
								<input type="hidden" name="equipment[]" value="<?= $item['equipment'] ?>">
								<input type="hidden" name="quantity[]" value="<?= $item['quantity'] ?>">
							<?php endforeach; ?>
							<div class="terms-agreement">
								<label class="terms-label">
									<input type="checkbox" class="terms-checkbox" value="agree" required>
									Соглашаюсь с правилами пользования торговой площадкой и возврата
								</label>
							</div>

							<input type="hidden" name="userID" value="<?= @$_SESSION['user']['userID'] ?>">

							<button type="submit" class="payment-button">Оформить заказ</button>
						</form>
					</div>
				</div>
				<button class="floating-order-button" onclick="document.querySelector('.payment-form').submit();">
					Оформить заказ
				</button>
			</div>
		</div>
		<?
		include 'view/assets/footer/footer.html'; ?>
	</main>
</body>

</html>