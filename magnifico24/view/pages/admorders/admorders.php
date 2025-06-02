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
	<link rel="stylesheet" href="view/general/styles/normolize.css">
	<link rel="stylesheet" href="view/pages/admorders/admorders.css">
	<title>Профиль</title>
</head>

<body>
<?
	include 'view/assets/header/headerADM.html';

	use controller\Basket;
	use controller\Profile;
	use controller\GetTitle;

	?>

	<main class="main">
		<div class="container">
			<div class="wrapper">
				<div class="main_nav">
					<div class="main_nav-container">
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/home.svg" alt="" class="nav_item-image">
							<a href="" class="nav_item-link">Главная страница</a>
						</div>
						<span class="line"></span>
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/people.svg" alt="" class="nav_item-image">
							<a href="" class="nav_item-link">Обратная связь</a>
						</div>
						<span class="line"></span>
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/politic.svg" alt="" class="nav_item-image">
							<a href="" class="nav_item-link">Политика компании</a>
						</div>
						<span class="line"></span>
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/basket.svg" alt="" class="nav_item-image">
							<a href="" class="nav_item-link">Корзина</a>
						</div>
						<span class="line"></span>

						<form class="button-form" action="logout_form" method='post'>
							<button class="nav_button-exit">Выйти</button>
						</form>
					</div>
				</div>


				<div class="main_order-container">
					<h2 class="order-title">Заказы</h2>
					<?
					$orders = Profile::getAllOrdres();
					foreach ($orders as $order):
					?>
						<div class="order-item">
							<div class="order-summary">
								<span class="order-number">Заказ № <?= $order['ordersID'] ?></span>
								<span class="order-cost">Стоимость: <?= $order['total_prace'] ?>$</span>
								<span class="order-date"><?= $order['date'] ?></span>
								<span class="order-status accepted">
									<?php
									$status = $order['status'];
									$color = '';
									if ($status == 'Подтверждено') {
										$color = 'orange';
									} elseif ($status == 'Готово') {
										$color = 'green';
									} elseif ($status == 'Отклонено') {
										$color = 'red';
									} else {
										$color = 'gray'; // цвет по умолчанию
									}
									?>
									<i class="status-indicator" style='background-color: <?= $color; ?>;'></i><?= $status ?>

								</span>
								<form class="button-form" action="/statusOrder_form" method="post">
									<input type="hidden" name="ordersID" value=' <?= $order['ordersID'] ?>'>
									<select name="status">
										<option value="Подтверждено">Подтвердить</option>
										<option value="Отклонено">Отклонить</option>
										<option value="Готово">Готово</option>
									</select>
									<input type="text" name="admComment" placeholder='Оставить коментарий клиенту'>
									<button>Отправить</button>
								</form>
								<button class="details-button">Детали <i class="arrow-down"></i></button>
							</div>

							<div class="order-details hidden">
								<table>
									<thead>
										<tr>
											<th>Товар</th>
											<th>Материал</th>
											<th>Цвет</th>
											<th>Картинка</th>
											<th>Материал верхнего слоя</th>
											<th>Цвет</th>
											<th>количество</th>
											<th>Цена</th>
										</tr>
									</thead>
									<tbody>
										<?
										$detalis = Profile::getOrderDetalis($order['ordersID']);
										foreach ($detalis as $detal):
										?>
											<tr>
												<td><?= $detal['title'] ?></td>
												<td><?= GetTitle::titleMaterials($detal['materialsID']) ?></td>
												<?
												if ($detal['colourIMG'] == null) {
													echo '<td>Нет</td>';
												} else {
												?>
													<td><?= GetTitle::titleColour($detal['colourIMG']) ?></td>
												<?
												}
												if ($detal['colourIMG'] == null) {
													echo '<td>Нет</td>';
												} else {
												?>
													<td><img width="60" height="20" src="<?= $detal['colourIMG'] ?>" alt=""></td>
												<?
												}
												?>
												<?
														if ($detal['topMaterials'] == null) {
															echo '<td>Нет</td>';
														} else {
														?>
															<td><?= $detal['topMaterials'] ?></td>
														<?
														}
														if ($detal['topColourIMG'] == null) {
															echo '<td>Нет</td>';
														} else {
														?>
															<td><img width="60" height="20" src="<?= $detal['topColourIMG'] ?>" alt=""></td>
														<?
														}
														?>
												<td><?= $detal['quantity'] ?></td>
												<td><?= $detal['price'] * $detal['quantity'] ?>$</td>
											</tr>
										<? endforeach ?>
									</tbody>
									<? $user = GetTitle::getUserInfoByOrder($order['ordersID'])  ?>
									<label for="">Имя клиента: </label>
									<label for=""><?= $user['surname'] . $user['name'] ?></label><br>

									<label for="">Номер клиента: </label>
									<label for=""><?= $user['phone'] ?></label><br>

									<label for="">Комментарий клиента: </label>
									<label for=""><?= $order['comment'] ?></label><br>

									<label for="">Наш коментарий: </label>
									<label for=""><?= $order['adm_comment'] ?></label>
								</table>
							</div>
						</div>
					<? endforeach ?>

					<script src="/view/pages/profile/profile.js"></script>
				</div>
			</div>
		</div>
	</main>





	<?
	include 'view/assets/footer/footer.html'
	?>


</body>

</html>