<?

namespace controller;

include_once './src/servises/connect.php';

use services\Connect;
use PDO;
use PDOException;

class Usl
{
	public static function getServises()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Services` ORDER BY servicesID DESC");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	public static function getServisesCat($id)
	{
		$pdo = Connect::connect();
		$sql = "SELECT * FROM `Services` WHERE cat = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$id]);
		return $query->fetchAll();
	}

	public static function addRecords()
	{
		$pdo = Connect::connect();

		$userID = $_POST['userID'] ?? null;
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$usl = $_POST['service'];
		$date = $_POST['date'];
		$car = $_POST['car'];
		$comment = $_POST['comment'];

		if ($userID === null || $userID === '') {
			$sql = "INSERT INTO Records(name, phone, usl, date, car_model, comment) VALUES (?, ?, ?, ?, ?, ?)";
			$query = $pdo->prepare($sql);
			$query->execute([$name, $phone, $usl, $date, $car, $comment]);
		} else {
			$sql = "INSERT INTO Records(userID, name, phone, usl, date, car_model, comment) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$query = $pdo->prepare($sql);
			$query->execute([$userID, $name, $phone, $usl, $date, $car, $comment]);
		}

		if ($usl == 'Консультация') {
			header('Location: /');
		} else {
			header('Location: /usl');
		}
	}



	public static function getRecords()
	{
		$pdo = Connect::connect();
		$userID = $_SESSION['user']['userID'];
		$sql = "SELECT * FROM `Records` WHERE userID = ? ORDER BY recordsID DESC";
		$query = $pdo->prepare($sql);
		$query->execute([$userID]);
		return $query->fetchAll();
	}

	public static function getAllRecords()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Records` ORDER BY recordsID DESC");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
