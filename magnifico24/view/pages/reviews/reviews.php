<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/view/general/styles/normolize.css">
    <link rel="stylesheet" href="/view/pages/reviews/reviews.css">
    <title>Отзывы</title>
</head>

<body>

    <?
    include 'view/assets/header/header.html';
    use controller\Profile;
    ?>

    <main class="main">
        <div class="container">
            <section class="review-form">
                <h2>Оставить отзыв</h2>
                <form action="/reviewForm" method="post">
                    <div class="form-group">
                        <label for="username">Ваше Имя</label>
                        <input type="text" id="username" name="username" placeholder="Введите ваше имя" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Ваш Отзыв</label>
                        <textarea id="comment" name="comment" placeholder="Напишите ваш отзыв здесь" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Рейтинг</label>
                        <div class="star-rating">
                            <input type="radio" id="star1" name="rating" value="5" /><label for="star1" title="1 star">★</label>
                            <input type="radio" id="star2" name="rating" value="4" /><label for="star2" title="2 stars">★</label>
                            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars">★</label>
                            <input type="radio" id="star4" name="rating" value="2" /><label for="star4" title="4 stars">★</label>
                            <input type="radio" id="star5" name="rating" value="1" /><label for="star5" title="5 stars">★</label>
                        </div>
                    </div>
                    <button type="submit" class="submit-button">Отправить отзыв</button>
                </form>
            </section>
            <?
            $reviews = Profile::getAllReview();
            foreach($reviews as $review):

                if($review['rating'] == 5){
                    $rating = '★★★★★';
                }
                if($review['rating'] == 4){
                    $rating = '★★★★';
                }
                if($review['rating'] == 3){
                    $rating = '★★★';
                }
                if($review['rating'] == 2){
                    $rating = '★★';
                }
                if($review['rating'] == 1){
                    $rating = '★';
                }
            ?>
            <section class="reviews-display">
                <h2>Отзывы Клиентов</h2>
                <div id="reviewsContainer">
                    <div class="review-card">
                        <h3><?=$review['name']?></h3>
                        <div class="rating">Рейтинг: <?= $rating?></div>
                        <p><?=$review['review']?></p>
                    </div>
                </div>
            </section>
            <? endforeach ?>
        </div>
    </main>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reviewForm = document.getElementById('reviewForm');
            const reviewsContainer = document.getElementById('reviewsContainer');

            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const username = document.getElementById('username').value;
                const comment = document.getElementById('comment').value;
                const rating = document.querySelector('input[name="rating"]:checked');

                if (!rating) {
                    alert('Пожалуйста, выберите рейтинг.');
                    return;
                }

                const ratingValue = rating.value;

                const reviewCard = document.createElement('div');
                reviewCard.classList.add('review-card');

                const h3 = document.createElement('h3');
                h3.textContent = username;

                const ratingDiv = document.createElement('div');
                ratingDiv.classList.add('rating');
                let stars = '';
                for (let i = 0; i < ratingValue; i++) {
                    stars += '★';
                }
                for (let i = ratingValue; i < 5; i++) {
                    stars += '☆';
                }
                ratingDiv.textContent = 'Рейтинг: ' + stars;

                const p = document.createElement('p');
                p.textContent = comment;

                reviewCard.appendChild(h3);
                reviewCard.appendChild(ratingDiv);
                reviewCard.appendChild(p);

                reviewsContainer.prepend(reviewCard);

                document.getElementById('username').value = '';
                document.getElementById('comment').value = '';
                rating.checked = false;
            });
        });
    </script> -->

    <?
    include 'view/assets/footer/footer.html'
    ?>


</body>

</html>