<?

namespace controller;

include_once './src/servises/connect.php';

use services\Connect;
use PDO;
use PDOException;

class GetTitle
{
	public static function titleMaterials($materialsID)
	{
		$pdo = Connect::connect();

		$query = $pdo->prepare("SELECT title FROM Materials WHERE materialsID = :materialsID");
		$query->execute(['materialsID' => $materialsID]);
		return $query->fetchColumn();
	}
	public static function titleCarModels($car_modelsID)
	{
		$pdo = Connect::connect();

		$query = $pdo->prepare("SELECT title FROM CarModels WHERE car_modelsID = :car_modelsID");
		$query->execute(['car_modelsID' => $car_modelsID]);
		return $query->fetchColumn();
	}
	public static function titleCarBrands($car_brandsID)
	{
		$pdo = Connect::connect();

		$query = $pdo->prepare("SELECT title FROM CarBrands WHERE car_brandsID = :car_brandsID");
		$query->execute(['car_modelsID' => $car_brandsID]);
		return $query->fetchColumn();
	}
	public static function titleCategories($CategoriesID)
	{
		$pdo = Connect::connect();

		$query = $pdo->prepare("SELECT title FROM Categories WHERE categoriesID = :CategoriesID");
		$query->execute(['CategoriesID' => $CategoriesID]);
		return $query->fetchColumn();
	}
	public static function titleColour($colorIMG)
	{
		$pdo = Connect::connect();

		$query = $pdo->prepare("SELECT title FROM colors WHERE img = :CategoriesID");
		$query->execute(['CategoriesID' => $colorIMG]);
		return $query->fetchColumn();
	}

	public static function getUserInfoByOrder($ordersID)
	{
		$pdo = Connect::connect();

		$query = $pdo->prepare("
									SELECT 
													o.ordersID,
													u.surname,
													u.name,
													u.phone,
													o.total_prace,
													o.date
									FROM Orders o
									JOIN Users u ON o.usersID = u.userID
									WHERE o.ordersID = :ordersID
					");

		$query->execute(['ordersID' => $ordersID]);
		return $query->fetch(PDO::FETCH_ASSOC);
	}

 public static	function getModelAndBrandByModelID($car_modelsID)
	{
		$pdo = Connect::connect();

		$sql = "
							SELECT 
					cm.car_modelsID,
					cm.title AS model_title,
					cb.title AS brand_title
	FROM 
					CarModels cm
	JOIN 
					CarBrands cb ON cm.car_brandsID = cb.car_brandsID
	WHERE 
					cm.car_modelsID = :car_modelsID
					";

		// Подготовка и выполнение запроса
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['car_modelsID' => $car_modelsID]);

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}
