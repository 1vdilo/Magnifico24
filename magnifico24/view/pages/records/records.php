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
	<link rel="stylesheet" href="view/pages/profile/profile.css">
	<title>Профиль</title>
</head>

<body>
	<?

	include 'view/assets/header/header.html';

	use controller\Basket;
	use controller\Profile;
	use controller\GetTitle;
	use controller\Usl;

	?>

	<main class="main">
		<div class="container">
			<div class="wrapper">
				<div class="main_nav">
					<div class="main_nav-container">
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/home.svg" alt="" class="nav_item-image">
							<a href="/" class="nav_item-link">Главная страница</a>
						</div>
						<span class="line"></span>
						
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/order-profile.svg" alt="" class="nav_item-image">
							<a href="/profile" class="nav_item-link">Ваши заказы</a>
						</div>
						<span class="line"></span>
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/recording-profile.svg" alt="" class="nav_item-image">
							<a href="/records" class="nav_item-link">Ваши записи</a>
						</div>
						<span class="line"></span>
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/people.svg" alt="" class="nav_item-image">
							<a href="/reviews" class="nav_item-link">Оставить отзыв</a>
						</div>
						<span class="line"></span>
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/politic.svg" alt="" class="nav_item-image">
							<a href="/palitic" class="nav_item-link">Политика компании</a>
						</div>
						<span class="line"></span>
						<div class="main_nav-item">
							<img src="/view/pages/profile/profile-img/basket.svg" alt="" class="nav_item-image">
							<a href="/basket" class="nav_item-link">Корзина</a>
						</div>
						<span class="line"></span>

						<form class="button-form" action="logout_form" method='post'>
							<button class="nav_button-exit">Выйти</button>
						</form>
					</div>
				</div>
				<?
				$users = Profile::getUser();
				foreach ($users as $user):
				?>
					<div class="main_profile">
						<div class="main_profile-container">
							<img src="/view/pages/profile/profile-img/Ellipse 66.png" alt="" class="profile-image">

							<div class="profile-fio">
								<p class="profile-name"><?= $user['surname'] ?></p>
								<p class="profile-surename"><?= $user['name'] ?></p>
							</div>
							<div class="profile-conform">
								<div class="profile_conform-item">
									<div>
										<div class="con">
											<img src="/view/pages/profile/profile-img/email.svg" alt="" class="conform-img">
											<p class="conform-text">Электронная почта</p>
										</div>
										<p><?= $user['email'] ?></p>
									</div>
									<div>
										<div class="con">
											<img src="/view/pages/profile/profile-img/phone.svg" alt="" class="conform-img">
											<p class="conform-text">Номер телефона</p>
										</div>
										<p><?= $user['phone'] ?></p>
									</div>
								</div>
							</div>
						</div>

						<div class="main_order-container">
							<h2 class="order-title">Ваши заказы</h2>
							<?
							$orders = Usl::getRecords();
							foreach ($orders as $order):
							?>
							<div class="order-item">
								<br>
							<span class="order-number">Ваш коментарий: <?= $order['comment'] ?></span><br>
							<span class="order-number">Коментарий от Magnifico: <?= $order['adm_comment'] ?></span>
								<div class="order-summary">
									<span class="order-number">Заказ № <?= $order['recordsID'] ?></span>
									<span class="order-number">Имя <?= $order['name'] ?></span>
									<span class="order-number">Услуга: <?= $order['usl'] ?></span>
									<span class="order-number">Модель авто: <?= $order['car_model'] ?></span>
									<!-- <span class="order-cost">Стоимость: <?= $order['total_prace'] ?>$</span> -->
									<span class="order-date"><?= $order['date'] ?></span>
									<span class="order-status accepted">
										<?php
										$status = $order['status'];
										$color = '';
										if ($status == 'Подтверждено') {
											$color = 'orange';
										} elseif ($status == 'Завершено') {
											$color = 'green';
										} elseif ($status == 'Отклонено') {
											$color = 'red';
										} else {
											$color = 'gray'; // цвет по умолчанию
										}
										?>
										<i class="status-indicator" style='background-color: <?= $color; ?>;'></i><?= $status ?>
									</span>
									
									<!-- <button class="details-button">Детали <i class="arrow-down"></i></button> -->
								</div>

								<div class="order-details hidden">
									<table>
										<thead>
											<tr>
												<th>Товар</th>
												<th>Материал</th>
												<th>Цвет</th>
												<th>Комплектация</th>
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
												<td><?= $detal['colour'] ?></td>
												<td><?= $detal['equipment'] ?></td>
												<td><?= $detal['quantity'] ?></td>
												<td><?= $detal['price'] * $detal['quantity'] ?>$</td>
											</tr>
										<? endforeach ?>

										</tbody>
										<label for="">Ваш коментарий: </label>
										<label for=""><?=$order['comment']?></label>
												<?
												if($order['adm_comment'] == ''){
													echo '';
												}else{
													?>
													<br>
													<label for="">Ответ от Magnifico: </label>
													<label for=""><?=$order['adm_comment']?></label>
													<?
												}
												?>
									</table>
								</div>
								<? endforeach; ?>
							</div>
							<? endforeach; ?>
							<script src="/view/pages/profile/profile.js"></script>
						</div>
					</div>
			</div>
	</main>
	<?
	include 'view/assets/footer/footer.html';
	?>
</body>

</html>