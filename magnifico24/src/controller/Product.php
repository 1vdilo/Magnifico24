<?php


namespace controller;


use services\Connect;
use PDO;


include_once './src/servises/connect.php';


class Product
{


	//вывод товаров из  таблицы `Products` по id
	public static function getProduct($id)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("SELECT * FROM `Products` WHERE `productsID` = :productsID");
		$query->execute(['productsID' => $id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	//Вывод информации из таблицы по `ProductsVariants` по id
	public static function getProductsVariants($id)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("SELECT * FROM `ProductsVariants` WHERE `productsID` = :productsID");
		$query->execute(['productsID' => $id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	public static function getColors($materialsID)
	{
		$pdo = Connect::connect();
		$query = $pdo->prepare("SELECT * FROM `colors` WHERE materialsID = :materialsID");
		$query->execute(['materialsID' => $materialsID]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	public static function getTopMaterials()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `TopLayerMaterials`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	public static function getTopColors()
	{
		$pdo = Connect::connect();
		$query = $pdo->query("SELECT * FROM `TopLayerColour`");
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
