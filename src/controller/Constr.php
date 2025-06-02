<?

namespace controller;

include_once './src/servises/connect.php';

use FFI\CType;
use services\Connect;
use PDO;
use PDOException;

class Constr
{

	public static function getVideo()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `HomeVideo`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	private static function uploadVideo(): ?string
	{
		$targetDir = "view/general/video/Q/";

		// Проверяем, что директория существует
		if (!is_dir($targetDir)) {
			mkdir($targetDir, 0777, true);
		}

		if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
			$fileName = basename($_FILES['video']['name']);
			$targetFile = $targetDir . $fileName;

			if (move_uploaded_file($_FILES['video']['tmp_name'], $targetFile)) {
				return $targetFile;
			}
		}

		return null;
	}


	public static function addVideo()
	{
		$pdo = Connect::connect();

		$id = $_POST['videoID'];
		$videoPath = self::uploadVideo();

		if ($videoPath !== null) {
			$sql = "UPDATE `HomeVideo` SET `VideoUrl` = ? WHERE id = ?";
			$query = $pdo->prepare($sql);
			$query->execute([$videoPath, $id]);
			header("Location: /admconstr");
		} else {
			throw new \Exception("Ошибка при загрузке видео");
		}
	}

	public static function getServises()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Services` ORDER BY servicesID DESC");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	// public static function addSrvises()
	// {
	// 	$pdo = Connect::connect();

	// 	$price = $_POST['price'];
	// 	$id = $_POST['servicesID'];
	// 	$description = $_POST['description'];
	// 	$title = $_POST['title'];

	// 	$sql = "UPDATE `Services` SET `price`= ?, `description`= ?, `title` = ? WHERE servicesID = ?";
	// 	$query = $pdo->prepare($sql);
	// 	$query->execute([$price, $description, $title, $id]);
	// 	header("Location: /admconstr");
	// }
	public static function addSrvises()
	{
		$pdo = Connect::connect();

		$id = $_POST['servicesID'] ?? null;
		if (!$id || !is_numeric($id)) {
			die("Неверный ID услуги.");
		}

		$fields = [];
		$values = [];

		if (isset($_POST['price']) && $_POST['price'] !== '' && is_numeric($_POST['price'])) {
			$fields[] = "`price` = ?";
			$values[] = $_POST['price'];
		}

		if (isset($_POST['description']) && $_POST['description'] !== '') {
			$fields[] = "`description` = ?";
			$values[] = $_POST['description'];
		}

		if (isset($_POST['title']) && $_POST['title'] !== '') {
			$fields[] = "`title` = ?";
			$values[] = $_POST['title'];
		}

		if (empty($fields)) {
			die("Нет данных для обновления.");
		}

		$sql = "UPDATE `Services` SET " . implode(", ", $fields) . " WHERE `servicesID` = ?";
		$values[] = $id;

		$query = $pdo->prepare($sql);
		$query->execute($values);

		header("Location: /admconstr");
		exit();
	}


	public static function getTopMaterials()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `TopLayerMaterials`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function addTopMaterials()
	{
		$pdo = Connect::connect();

		$title = $_POST['title'];
		$photo = self::uploadVideo();


		$sql = "INSERT INTO `TopLayerMaterials`(`title`, `imgURL`) VALUES (?, ?)";
		$query = $pdo->prepare($sql);
		$query->execute([$title, $photo]);
		header("Location: /admconstr");
	}
	public static function delTop()
	{
		$pdo = Connect::connect();

		$id = $_POST['TopID'];


		$sql = "DELETE FROM `TopLayerMaterials` WHERE TopLayerMaterialsID = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$id]);
		header("Location: /admconstr");
	}



	public static function addTopColors()
	{
		$pdo = Connect::connect();
		$topMat = $_POST['topMaterials'];
		$title = $_POST['title'];
		$photo = self::uploadVideo();


		$sql = "INSERT INTO `TopLayerColour`(`title`, `imgURL`, `TopLayerMaterialsID`) VALUES (?, ?, ?)";
		$query = $pdo->prepare($sql);
		$query->execute([$title, $photo, $topMat]);
		header("Location: /admconstr");
	}
	public static function getTopLayerColour()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT 
    c.topLayerID,
    c.TopLayerMaterialsID,
    c.title AS colour_title,
    c.imgURL,
    m.title AS material_title
FROM TopLayerColour c
JOIN TopLayerMaterials m ON c.TopLayerMaterialsID = m.TopLayerMaterialsID;
");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	// public static function getTopLayerColour()
	// {
	// 	$pdo = Connect::connect();
	// 	$query = $pdo->query("SELECT * FROM `TopLayerColour`");
	// 	return $query->fetchAll(PDO::FETCH_ASSOC);
	// }
	public static function delTopCol()
	{
		$pdo = Connect::connect();

		$id = $_POST['TopColID'];


		$sql = "DELETE FROM `TopLayerColour` WHERE topLayerID = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$id]);
		header("Location: /admconstr");
	}


	public static function getMaterials()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Materials`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	public static function addMaterials()
	{
		$pdo = Connect::connect();

		$title = $_POST['title'];


		$sql = "INSERT INTO `Materials`(`title`) VALUES (?)";
		$query = $pdo->prepare($sql);
		$query->execute([$title]);
		header("Location: /admconstr");
	}

	public static function addColors()
	{
		$pdo = Connect::connect();

		$title = $_POST['title'];
		$topMaterials = $_POST['materialsID'];
		$photo = self::uploadVideo();


		$sql = "INSERT INTO `colors`(`materialsID`, `title`, `img`) VALUES (?, ?, ?)";
		$query = $pdo->prepare($sql);
		$query->execute([$topMaterials, $title, $photo]);
		header("Location: /admconstr");
	}

	public static function getColor()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT 
    c.colourID,
    c.materialsID,
    c.title AS colour_title,
    c.img,
    m.title AS material_title
FROM colors c
JOIN materials m ON c.materialsID = m.materialsID;
");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
	// public static function getColor()
	// {
	// 	$pdo = Connect::connect();
	// 	$query = $pdo->query("SELECT * FROM `colors`");
	// 	return $query->fetchAll(PDO::FETCH_ASSOC);
	// }
	public static function delCol()
	{
		$pdo = Connect::connect();

		$id = $_POST['colourID'];


		$sql = "DELETE FROM `colors` WHERE colourID = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$id]);
		header("Location: /admconstr");
	}

	public static function addCarBrands()
	{
		$pdo = Connect::connect();

		$car_brands = $_POST['carBrands'];


		$sql = "INSERT INTO `CarBrands`(`title`) VALUES (?)";
		$query = $pdo->prepare($sql);
		$query->execute([$car_brands]);
		header("Location: /admconstr");
	}
	public static function dellCarBrands()
	{
		$pdo = Connect::connect();

		$car_brands = $_POST['brand_title'];


		$sql = "DELETE FROM `CarBrands` WHERE title = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$car_brands]);
		header("Location: /admconstr");
	}

	public static function getModel()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `CarModels`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function addCarModel()
	{
		$pdo = Connect::connect();
		$car_brandsID = $_POST['car_brandsID'];
		$carModel = $_POST['carModel'];


		$sql = "INSERT INTO `CarModels`(`car_brandsID`, `title`) VALUES (?, ?)";
		$query = $pdo->prepare($sql);
		$query->execute([$car_brandsID, $carModel]);
		header("Location: /admconstr");
	}

	public static function dellcarModels()
	{
		$pdo = Connect::connect();

		$model_title = $_POST['model_title'];


		$sql = "DELETE FROM `CarModels` WHERE title = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$model_title]);
		header("Location: /admconstr");
	}
}
