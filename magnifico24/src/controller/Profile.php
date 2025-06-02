<?php

namespace controller;

include_once './src/servises/connect.php';

use services\Connect;
use PDO;

class Profile
{
	public static function getUser()
	{
		$pdo = Connect::connect();
		$userID = $_SESSION['user']['userID'];
		$sql = "SELECT * FROM `Users` WHERE userID = ?";
		$query = $pdo->prepare($sql);
		$query->execute([$userID]);
		return $query->fetchAll();
	}
	public static function getOrdres()
	{
		$pdo = Connect::connect();
		$userID = $_SESSION['user']['userID'];
		$sql = "SELECT * FROM Orders WHERE usersID = ? ORDER BY ordersID DESC
";
		$query = $pdo->prepare($sql);
		$query->execute([$userID]);
		return $query->fetchAll();
	}
	public static function getAllOrdres()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Orders` ORDER BY ordersID DESC");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getOrderDetalis($OrderID)
	{
		$pdo = Connect::connect();

		$sql = "SELECT 

        OD.topMaterials,
        OD.topColourIMG,

        OD.OrdersDetailsID,
        OD.OrderID,
        OD.ProductVariantsID,
        OD.quantity,
        OD.colour,
        OD.colourIMG,
        OD.equipment,
        P.ImageURL,
        P.title,
        P.descriptions,
        P.car_modelsID,
        P.materialsID,
        P.years,
        P.price,
        M.materialsID
    FROM OrdersDetails OD
    JOIN ProductsVariants PV ON OD.ProductVariantsID = PV.products_variantsID
    JOIN Products P ON PV.productsID = P.productsID
    JOIN Materials M ON P.materialsID = M.materialsID
    WHERE OD.OrderID = ?";  // Исправлено с ordersID на OrderID

		$query = $pdo->prepare($sql);
		$query->execute([$OrderID]);
		return $query->fetchAll();
	}
	
	public static function review(){
		$pdo = Connect::connect();

		$name = $_POST['username'];
		$review = $_POST['comment'];
		$rating = $_POST['rating'];

		// Вставка каждого товара
		$sql = "INSERT INTO `review`(`name`, `review`, `rating`) VALUES (?, ?, ?)";
		$query = $pdo->prepare($sql);
			$query->execute([$name, $review, $rating]);
		header('Location: /reviews');
		exit();
	}

	public static function getAllReview()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM review ORDER BY reviewID DESC
");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
