<?php

namespace controller;

use services\Connect;
use PDO;

include_once './src/servises/connect.php';

class Catalog
{

	//получение названия марок авто
	public static function getCarBrand()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("
									SELECT * FROM `CarBrands`
									ORDER BY 
													CASE 
																	WHEN car_brandsID = 30 THEN 0
																	ELSE 1
													END,
													title
					");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	//получение моделей авто в зависимости от марки авто
	public static function getModels($id)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("SELECT * FROM `CarModels` WHERE `car_brandsID` = :car_brandsID");
		$query->execute(['car_brandsID' => $id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	//получение категорий 
	public static function getCategories()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Categories`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	//вывод товаров по категориии или передача id для категорий, я хз зачем нужно
	public static function getCatalog($id)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("SELECT * FROM `Products` WHERE `categoriesID` = :id");
		$query->execute(['id' => $id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	//получение материалов по модели авто
	public static function getMaterials($id)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("
						SELECT DISTINCT m.* 
						FROM `Products` p
						JOIN `Materials` m ON p.materialsID = m.materialsID
						WHERE p.car_modelsID = :car_modelsID
		");
		$query->execute(["car_modelsID" => $id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	//вывод товаров по фильтрам
	public static function getFilteredProducts($filters)
	{
		$pdo = Connect::connect();

		$sql = "
					SELECT DISTINCT p.*, p.price
					FROM Products p
					JOIN CarModels cm ON p.car_modelsID = cm.car_modelsID
					JOIN CarBrands cb ON cm.car_brandsID = cb.car_brandsID
					LEFT JOIN Materials m ON p.materialsID = m.materialsID
					WHERE 1=1
					";

		$params = [];

		// Фильтр по категории
		if (!empty($filters['categoriesID'])) {
			$sql .= " AND p.categoriesID = :categoriesID";
			$params['categoriesID'] = $filters['categoriesID'];
		}

		// Фильтр по бренду
		if (!empty($filters['car_brandsID'])) {
			$sql .= " AND cb.car_brandsID = :car_brandsID";
			$params['car_brandsID'] = $filters['car_brandsID'];
		}

		// Фильтр по модели
		if (!empty($filters['car_modelsID'])) {
			$sql .= " AND cm.car_modelsID = :car_modelsID";
			$params['car_modelsID'] = $filters['car_modelsID'];
		}

		// Фильтр по материалу
		if (!empty($filters['materialsID'])) {
			$sql .= " AND p.materialsID = :materialsID";
			$params['materialsID'] = $filters['materialsID'];
		}

		// Фильтр по минимальной цене
		if (!empty($filters['priceMin'])) {
			$sql .= " AND p.price >= :priceMin";
			$params['priceMin'] = $filters['priceMin'];
		}

		// Фильтр по максимальной цене
		if (!empty($filters['priceMax'])) {
			$sql .= " AND p.price <= :priceMax";
			$params['priceMax'] = $filters['priceMax'];
		}

		// Выполнение запроса
		$query = $pdo->prepare($sql);
		$query->execute($params);

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function searchByTitle($searchQuery)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("
									SELECT * 
									FROM `Products` 
									WHERE `descriptions` LIKE :searchQuery
					");
		$searchTerm = "%" . $searchQuery . "%";
		$query->execute(['searchQuery' => $searchTerm]);

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getAllMaterials()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `Materials`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
