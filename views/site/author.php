<?php
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;


$this->title = 'Авторы';
?>
<div class="books-glav">
    <div class="container-books">
        <div class="brt">
            <div class="zag">
                <h3>Книги</h3>
            </div>

            <div class="books-container-book" style="    display: flex;
            flex-wrap: wrap;">
                <?php foreach($books as $item): ?>
                    <div class="books_disp">
                        <a href="<?=Url::toRoute(['site/books', 'id' => $item['id']]);?>" class="books-a">
                            <div class="opisanie">
                                <img src="../image/books/<?= $item['image'] ?>" alt="" class="books-img">
                                <p class="opisanie-p"><?= $item['name'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
