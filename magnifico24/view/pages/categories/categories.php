<?

use controller\Catalog;

$categories = Catalog::getCategories();


?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/view/general/styles/normolize.css">
	<link rel="stylesheet" href="/view/pages/categories/categories.css">
	<title>categories</title>
</head>

<body>


	<?
	include 'view/assets/header/header.html';
	?>

<main class="main">
        <div class="container">
            <h2 class="main-title">Аксессуары в салон автомомбиля</h2>
            <div class="main__categories-container">
                <?php
                
                foreach ($categories as $category) {
                    $catalog = ['item1', 'item2', 'item3']; 
                ?>
                    <div class="product-card">
                        <div class="product-image-container">
                            <img class="product-image" src="<?= $category['imgURL'] ?>" alt="Product Image">
                        </div>
                        <div class="product-card-information">
                            <h2 class="card-information-title"><?= htmlspecialchars($category['title']) ?></h2>
                            <p class="card-information-text"><?= htmlspecialchars($category['description']) ?></p>
                            <div class="card-information-button">
                                <form action="/catalog" method="get" class="form-s">
                                    <input type="hidden" name="categoriesID" value="<?= $category['categoriesID'] ?>">
                                    <button type="submit" class='card-information-link'>Смотреть все</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </main>

	
	
<?
include 'view/assets/footer/footer.html'; ?>
</body>

</html>