<?php

namespace controller;

include_once './src/servises/connect.php';

use services\Connect;
use PDO;
use PDOException;

class Adm
{
	//получение данных из таблицы `Products`
	public static function GetProducts()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Products`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	// 	public static function getModels()
	// 	{
	// 		$pdo = Connect::connect();
	// 		$query = $pdo->query("
	// 		SELECT * FROM `CarModels`
	// 		ORDER BY 
	// 						CASE 
	// 										WHEN car_modelsID = 6 THEN 0
	// 										ELSE 1
	// 						END,
	// 						title
	// ");
	// 		return $query->fetchAll(PDO::FETCH_ASSOC);
	// 	}
	public static function getModels()
	{
		$pdo = Connect::connect();

		$query = $pdo->query("
        SELECT 
            m.car_modelsID,
            m.title AS model_title,
            m.car_brandsID,
            b.title AS brand_title
        FROM CarModels m
        JOIN CarBrands b ON m.car_brandsID = b.car_brandsID
        ORDER BY 
            CASE 
                WHEN m.car_modelsID = 6 THEN 0
                ELSE 1
            END,
            m.title
    ");

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	public static function getMaterials()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Materials`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	//получение данных о товаре по id
	public static function GetProduct($id)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("SELECT * FROM `Products` WHERE `productsID` = :productsID");
		$query->execute(['productsID' => $id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	//получние данных о карточке товара по id
	public static function GetProductVariants($id)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("SELECT * FROM `ProductsVariants` WHERE `productsID` = :productsID");
		$query->execute(['productsID' => $id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	//загрузка/обработка/перемещение фотографий
	private static function uploadImage()
	{
		$targetDir = "view/general/imgproduct/Q";
		$filePaths = [];

		foreach ($_FILES as $file) {
			$targetFile = $targetDir . basename($file["name"]);
			if (move_uploaded_file($file["tmp_name"], $targetFile)) {
				$filePaths[] = $targetFile;
			}
		}
		return $filePaths;
	}

	//добавление товара в таблицы `Products` и `ProductsVariants`
	public static function addProductWithVariants()
	{
		$pdo = Connect::connect();

		$categoriesID = $_POST['categoriesID'];
		$car_modelsID = $_POST['car_modelsID'];
		$title = $_POST['title'];
		$descriptions = $_POST['descriptions'];
		$materialsID = $_POST['materialsID'];
		$years = $_POST['years'];
		$price = $_POST['price'];
		[$imagePath, $imagePath1, $imagePath2, $imagePath3, $video] = self::uploadImage();
		$description = $_POST['big_description'];
		$productsID = null;

		try {
			$pdo->beginTransaction();

			$sql = "INSERT INTO Products(categoriesID, car_modelsID, title, descriptions, materialsID, years, price, ImageURL) VALUES (?,?,?,?,?,?,?,?)";
			$query = $pdo->prepare($sql);
			$query->execute([$categoriesID, $car_modelsID, $title, $descriptions, $materialsID, $years, $price, $imagePath]);

			$productsID = $pdo->lastInsertId();

			$sqlVariants = "INSERT INTO ProductsVariants(productsID, big_description, image1, image2, image3, video) VALUES (?,?,?,?,?,?)";
			$queryVariants = $pdo->prepare($sqlVariants);
			$queryVariants->execute([$productsID, $description, $imagePath1, $imagePath2, $imagePath3, $video]);

			$pdo->commit();

			header("Location: /adm");
		} catch (PDOException $e) {
			$pdo->rollBack();
			echo "Ошибка: " . $e->getMessage();
		}
	}

	//обновление данных о товаре в таблицах `Products` и `ProductsVariants`
	public static function updateProductWithVariants()
	{
		$pdo = Connect::connect();
		$productsID = $_POST['productsID'];
		$categoriesID = $_POST['categoriesID'] ?? null;
		$car_modelsID = $_POST['car_modelsID'] ?? null;
		$title = $_POST['title'] ?? null;
		$descriptions = $_POST['descriptions'] ?? null;
		$materialsID = $_POST['materialsID'] ?? null;
		$years = $_POST['years'] ?? null;
		$price = $_POST['price'] ?? null;
		$description = $_POST['big_description'] ?? null;

		try {
			$pdo->beginTransaction();

			$sql = "UPDATE Products SET categoriesID = ?, car_modelsID = ?, title = ?, descriptions = ?, materialsID = ?, years = ?, price = ? WHERE productsID = ?";
			$query = $pdo->prepare($sql);
			$query->execute([$categoriesID, $car_modelsID, $title, $descriptions, $materialsID, $years, $price, $productsID]);

			$sqlVariants = "UPDATE ProductsVariants SET big_description = ? WHERE productsID = ?";
			$queryVariants = $pdo->prepare($sqlVariants);
			$queryVariants->execute([$description, $productsID]);

			$pdo->commit();

			header("Location: /adm");
		} catch (PDOException $e) {
			$pdo->rollBack();
			echo "Ошибка: " . $e->getMessage();
		}
	}


	public static function updateProductImages()
	{
		$pdo = Connect::connect();

		$productId = $_POST['productsID'];
		$uploadedImages = self::uploadImage();
		$imagePath = $uploadedImages[0] ?? null;
		$imagePath1 = $uploadedImages[1] ?? null;
		$imagePath2 = $uploadedImages[2] ?? null;
		$imagePath3 = $uploadedImages[3] ?? null;

		try {
			$pdo->beginTransaction();

			if ($imagePath !== null) {
				$sql = "UPDATE Products SET ImageURL = ? WHERE productsID = ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$imagePath, $productId]);
			}
			if ($imagePath1 !== null || $imagePath2 !== null || $imagePath3 !== null) {
				$sqlVariants = "UPDATE ProductsVariants SET image1 = ?, image2 = ?, image3 = ? WHERE productsID = ?";
				$stmtVariants = $pdo->prepare($sqlVariants);
				$stmtVariants->execute([$imagePath1, $imagePath2, $imagePath3, $productId]);
			}

			$pdo->commit();

			header("Location: /adm");
		} catch (PDOException $e) {
			$pdo->rollBack();
			echo "Ошибка: " . $e->getMessage();
		}
	}

	public static function updateVideo()
	{
		$pdo = Connect::connect();

		$productsID = $_POST['productsID'];
		$uploadedImages = self::uploadImage();
		$video = $uploadedImages[0] ?? null;

		$sql = "UPDATE `ProductsVariants` SET `video`= ? WHERE productsID = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$video, $productsID]);
		header("Location: /adm");
	}

	// удаление данных о товаре в таблице `Products` 
	public static function dell()
	{
		if (isset($_POST['dellID']) && is_numeric($_POST['dellID'])) {
			$id = $_POST['dellID'];
			$pdo = Connect::connect();
			$query = $pdo->prepare("DELETE FROM Products WHERE productsID = :productsID");
			$query->execute(['productsID' => $id]);

			if ($query->rowCount() > 0) {
				header("Location: /adm");
				exit;
			} else {
				echo "Продукт с ID $id не найден.";
			}
		} else {
			echo "Неверный ID для удаления.";
		}
	}


	public static function statusOrder()
	{
		$pdo = Connect::connect();

		$ordersID = $_POST['ordersID'];
		$status = $_POST['status'];
		$comment = $_POST['admComment'] ?? null;

		$sql = "UPDATE `Orders` SET `status` = ?, adm_comment = ? WHERE ordersID = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$status, $comment, $ordersID]);
		header("Location: /admorders");
	}
	public static function statusRecords()
	{
		$pdo = Connect::connect();

		$ordersID = $_POST['recordID'];
		$status = $_POST['status'];
		$comment = $_POST['admComment'] ?? null;

		$sql = "UPDATE `Records` SET `status` = ?, adm_comment = ? WHERE recordsID = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$status, $comment, $ordersID]);
		header("Location: /admrecords");
	}
}
