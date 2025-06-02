<?php

namespace controller;


include_once './src/servises/connect.php';
require_once __DIR__ . '/vendor/autoload.php';

use services\Connect;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
const MAIL_USERNAME = "24magnifico@bk.ru";
const MAIL_PASSWORD = "1ctzM2WbGUbGjQVhhJzL";


class Auth
{
	// Регистрация
	public static function regUser($data)
	{
		$pdo = Connect::connect();
		$surname = $data['surname'];
		$name = $data['name'];
		$phone = $data['phone'];
		$email = $data['email'];
		$pass = $data['pass'];
		$pass2 = $data['pass2'];

		if ($pass === $pass2) {
			$hash_pass = password_hash($pass, PASSWORD_DEFAULT);
			$sql = "INSERT INTO Users (surname, name, phone, email, pass) VALUES (?, ?, ?, ?, ?)";
			$query = $pdo->prepare($sql);
			$query->execute([$surname, $name, $phone, $email, $hash_pass]);

			$_SESSION['user'] = [
				'userID' => $pdo->lastInsertId(),
				'email' => $email,
				'role' => 0
			];

			header('Location: /');
			exit();
		} else {
			echo "Пароли не совпадают";
		}
	}

	// Авторизация
	public static function authUser()
	{
		$pdo = Connect::connect();
		$email = $_POST['email'];
		$pass = $_POST['pass'];

		$query = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
		$query->execute([$email]);
		$user = $query->fetch(PDO::FETCH_ASSOC);

		if ($user && password_verify($pass, $user['pass'])) {
			$_SESSION['user'] = [
				'userID' => $user['userID'],
				'email' => $email,
				'role' => $user['role']
			];
			header("Location: " . ($_SESSION['user']['role'] === 0 ? '/' : '/adm'));
			exit();
		} else {
			echo "Неверный логин или пароль";
		}
	}

	// Выход
	public static function logout()
	{
		unset($_SESSION['user']);
		header("Location: /");
		exit();
	}

	// Отправка кода восстановления
	public static function sendRecoveryCode($data)
	{
		$pdo = Connect::connect();
		$email = $data['email'];

		$query = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
		$query->execute([$email]);
		$user = $query->fetch(PDO::FETCH_ASSOC);

		if ($user) {
			$recoveryCode = rand(100000, 999999);
			$update = $pdo->prepare("UPDATE Users SET recovery_code = ? WHERE email = ?");
			$update->execute([$recoveryCode, $email]);

			$mail = new PHPMailer(true);
			try {
				$mail->isSMTP();
				$mail->Host = 'smtp.mail.ru';
				$mail->SMTPAuth = true;
				$mail->Username = MAIL_USERNAME;
				$mail->Password = MAIL_PASSWORD;
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				$mail->Port = 465;

				$mail->setFrom(MAIL_USERNAME, 'Support');
				$mail->addAddress($email);

				$mail->isHTML(true);
				$mail->Subject = 'Код восстановления пароля';
				$mail->Body = "Ваш код восстановления пароля: <b>$recoveryCode</b>";
				$mail->send();
			header('Location: /reset');
				echo 'Письмо с кодом восстановления отправлено.';

			} catch (Exception $e) {
				echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
			}
		} else {
			echo "Пользователь с таким email не найден.";
		}
	}

	// Сброс пароля
	public static function resetPassword($data)
	{
		$pdo = Connect::connect();
		$email = $data['email'];
		$recoveryCode = $data['recovery_code'];
		$newPassword = $data['new_password'];
		$newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

		$query = $pdo->prepare("SELECT * FROM Users WHERE email = ? AND recovery_code = ?");
		$query->execute([$email, $recoveryCode]);
		$user = $query->fetch(PDO::FETCH_ASSOC);

		if ($user) {
			$update = $pdo->prepare("UPDATE Users SET pass = ?, recovery_code = NULL WHERE email = ?");
			$update->execute([$newPasswordHash, $email]);

			echo 'Пароль успешно обновлен!';
			header('Location: /registration');
			exit();
		} else {
			echo 'Неверный код восстановления или email.';
		}
	}
}
