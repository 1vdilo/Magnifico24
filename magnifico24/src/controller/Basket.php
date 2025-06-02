<?

namespace controller;

include_once './src/servises/connect.php';

use services\Connect;
use PDO;
use PDOException;

class Basket
{
    private static function getCommonData()
    {
        $userID = $_POST['userID'] ?? null;
        $productIDs = $_POST['productsID'] ?? [];
        $colours = $_POST['colour'] ?? [];
        $colourIMGs = $_POST['colourIMG'] ?? [];
        $equipments = $_POST['equipment'] ?? [];
        $quantity = $_POST['quantity'] ?? [];

        $TopColour = $_POST['TopColour'] ?? []; //значение
        $topLayerID = $_POST['topLayerID'] ?? []; //цвет

        $topMaterialsID = $_POST['topMaterialsID'] ?? [];

        if (empty($productIDs)) {
            die('Ошибка: productsID не передан!');
        }

        return [
            'userID' => $userID,
            'productIDs' => (array) $productIDs,
            'colours' => (array) $colours,
            'equipments' => (array) $equipments,
            'quantitys' => (array) $quantity,
            'colourIMG' => (array) $colourIMGs,
            'topLayerID' => (array) $topLayerID,
            'topMaterialsID' => (array) $topMaterialsID,
            'TopColour' => (array) $TopColour,
        ];
    }


    public static function addOrder()
    {
        $pdo = Connect::connect();
        $pdo->beginTransaction();

        try {
            $commonData = self::getCommonData();
            $userID = $commonData['userID'];
            $productIDs = $commonData['productIDs'];
            $colours = $commonData['colours'];
            $equipments = $commonData['equipments'];
            $quantitys = $commonData['quantitys'];
            $colourIMGs = $commonData['colourIMG'];
            $topLayerID = $commonData['topLayerID'];
            $topMaterialsID = $commonData['topMaterialsID'];
            $TopColour = $commonData['TopColour'];

            $totalPrice = $_POST['totalPrice'] ?? 0;
            $date = $_POST['date'] ?? date('Y-m-d');
            $comment = $_POST['comment'] ?? '';

            // Вставка заказа
            $sql = "INSERT INTO Orders(usersID, total_prace, date, comment) VALUES (?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([$userID, $totalPrice, $date, $comment]);

            $orderID = $pdo->lastInsertId();


            $sql = "INSERT INTO OrdersDetails(OrderID, ProductVariantsID, quantity, colour, colourIMG, topMaterials, topColour, topColourIMG, equipment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);

            foreach ($productIDs as $index => $productID) {
                $colour = $colours[$index] ?? null;
                $equipment = $equipments[$index] ?? null;
                $quantity = $quantitys[$index] ?? null;
                $colourIMG = $colourIMGs[$index] ?? null;
                $topLayer = $topLayerID[$index] ?? null; //цвет
                $topMaterial = $topMaterialsID[$index] ?? null;
                $TopColour = $TopColour[$index] ?? null; //значение 

                $query->execute([$orderID, $productID, $quantity, $colour, $colourIMG, $topMaterial, $TopColour, $topLayer,  $equipment]);
            }

            // Очистка корзины пользователя
            $sql = "DELETE FROM Basket WHERE usersID = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$userID]);

            $pdo->commit();
            header('Location: /categories');
            exit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo 'Ошибка: ' . $e->getMessage();
        }
    }



    public static function Basket()
    {
        $pdo = Connect::connect();

        $commonData = self::getCommonData();
        $userID = $commonData['userID'];
        $productIDs = $commonData['productIDs'];
        $colours = $commonData['colours'];
        $equipments = $commonData['equipments'];
        $colourIMGs = $commonData['colourIMG'];
        $topLayerID = $commonData['topLayerID']; //цвет
        $topMaterialsID = $commonData['topMaterialsID']; // новый параметр
        $TopColour = $commonData['TopColour']; // значение



        if (empty($userID)) {
            header('Location: /registration');
            exit();
        }

        
        $sql = "INSERT INTO Basket(usersID, products_variantsID, colour, colourIMG, topMaterials, topColour, topColourIMG, equipment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $pdo->prepare($sql);

        foreach ($productIDs as $key => $productID) {
            $colour = $colours[$key] ?? null;
            $equipment = $equipments[$key] ?? null;
            $colourIMG = $colourIMGs[$key] ?? null;
            $topLayer = $topLayerID[$key] ?? null; // цвет
            $topMaterial = $topMaterialsID[$key] ?? null; 
            $TopColour = $TopColour[$key] ?? null; //значение

            $query->execute([$userID, $productID, $colour, $colourIMG, $topMaterial, $TopColour,  $topLayer,  $equipment]);
        }

        header('Location: /categories');
        exit();
    }



    public static function GetOneProd()
    {
        $pdo = Connect::connect();
        $userID = $_SESSION['user']['userID'];
        $sql = "SELECT 
		B.topMaterials,
		B.topColour, 
		B.topColourIMG, 

		B.basketID, 
		B.usersID,
		B.products_variantsID,
	 B.colour,
	 B.colourIMG,
		B.equipment,
		B.quantity,
		P.ImageURL,
		P.title,
		P.descriptions,
		P.car_modelsID,
		P.materialsID,
		P.years,
		P.price,
		P.materialsID
		FROM Basket B JOIN ProductsVariants PV ON B.products_variantsID = PV.products_variantsID JOIN Products P ON PV.productsID = P.productsID WHERE B.usersID = ?;";
        $query = $pdo->prepare($sql);
        $query->execute([$userID]);
        return $query->fetchAll();
    }

    public static function addTovar()
    {
        $pdo = Connect::connect();

        $tovarID = $_POST['tovarID'];

        $sql = "UPDATE Basket SET quantity = quantity + 1 WHERE basketID = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$tovarID]);

        header('Location: /basket');
    }

    public static function removeTovar()
    {
        $pdo = Connect::connect();

        $tovarID = $_POST['tovarID'];

    
        $sql = "SELECT quantity FROM Basket WHERE basketID = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$tovarID]);
        $result = $query->fetch();

        if ($result && $result['quantity'] > 1) {
    
            $sql = "UPDATE Basket SET quantity = quantity - 1 WHERE basketID = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$tovarID]);
        } else {

            $sql = "DELETE FROM Basket WHERE basketID = ?";
            $query = $pdo->prepare($sql);
            $query->execute([$tovarID]);
        }

        header('Location: /basket');
    }



    public static function dellPozit()
    {
        $pdo = Connect::connect();

        $tovarID = $_POST['tovarID'];

        $sql = "DELETE FROM `Basket` WHERE basketID = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$tovarID]);
        header('Location: /basket');
    }
}
