<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Категории';
?>
<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Категории';
?>
<div class="books-glav">
    <div class="container-books">
        <!--    Книги    -->
        <div class="brt">
            <div class="zag">
                <h3><?= $category['name'] ?></h3>
                <img src="image/srelka-zag.png" alt="" class="books-strelka">
            </div>

            <div class="books-container-book" style="    display: flex;
    flex-wrap: wrap;">
                <?php foreach($books as $book): ?>
                    <div class="books_disp">
                        <a href="<?=Url::toRoute(['site/books', 'id' => $book['id']]);?>" class="books-a">
                            <div class="opisanie">
                                <img src="../image/books/<?= $book['image'] ?>" alt="" class="books-img">
                                <p class="opisanie-p"><?= $book['name'] ?></p>
                                <p class="opisanie-author"><?= $book['author']['nsp'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


