<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="view/general/styles/normolize.css">
	<link rel="stylesheet" href="view/pages/admorders/admorders.css">
	<title>Админка — Записи</title>
</head>

<body>
	<?php
	if (!isset($_SESSION['user'])) {
		header('Location: /registration');
	}if($_SESSION['user']['role'] == 0){
		header('Location: /');
	}
	include 'view/assets/header/headerADM.html';

	use controller\Profile;
	use controller\GetTitle;
	use controller\Usl;
	?>

	<main class="main">
		<!-- <div class="container"> -->
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
					<h2 class="order-title">Записи</h2>
					<?php
					$records = Usl::getAllRecords();
					foreach ($records as $record):
					?>
						<div class="order-item">
							<br>
							<span class="order-number">Имя клиента: <?= $record['name'] ?></span><br>
							<span class="order-number">Номер телефона: <?= $record['phone'] ?></span><br>
							<span class="order-number">Коментарий клиента: <?= $record['comment'] ?></span><br>
							<span class="order-number">Наш коментарий: <?= $record['adm_comment'] ?></span>
							<div class="order-summary">
								<span class="order-number">Запись № <?= $record['recordsID'] ?></span>
								<span class="order-date">Дата: <?= $record['date'] ?></span>
								<span class="order-date">Модель авто: <?= $record['car_model'] ?></span>
								<span class="order-date">Услуга: <?= $record['usl'] ?></span>
								<span class="order-date">Телефон: <?= $record['phone'] ?></span>
								<span class="order-status accepted">
									<?php
									$status = $record['status'];
									$color = match ($status) {
										'Подтверждено' => 'orange',
										'Завершено' => 'green',
										'Отклонено' => 'red',
										default => 'gray',
									};
									?>
									<i class="status-indicator" style='background-color: <?= $color; ?>;'></i><?= $status ?>
								</span>

								<form class="button-form" action="/statusRecord_form" method="post">
									<input type="hidden" name="recordID" value='<?= $record['recordsID'] ?>'>
									<select name="status">
										<option value="Подтверждено">Подтвердить</option>
										<option value="Отклонено">Отклонить</option>
										<option value="Завершено">Завершить</option>
									</select>
									<input type="text" name="admComment" placeholder="Комментарий администратора">
									<button>Отправить</button>
								</form>
							</div>

						</div>
					<?php endforeach ?>

					<script src="/view/pages/profile/profile.js"></script>
				</div>
			</div>
		<!-- </div> -->
	</main>

	<?php include 'view/assets/footer/footer.html'; ?>
</body>

</html>
