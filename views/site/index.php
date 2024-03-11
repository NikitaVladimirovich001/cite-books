<?php

use yii\bootstrap5\LinkPager;
use yii\helpers\Url;


$this->title = 'Главное';
?>

<img src="image/genres/horror.png" alt="" class="fon">
<!--  Категории  -->
<div class="slider">
    <div class="slider-block-text-p">
        <p class="slider-p">Откройте мир захватывающих приключений и увлекательных историй с нашей коллекцией книг. Разнообразие жанров которые касаются сердец и вдохновляют.</p>
    </div>
    <div class="button-slider">
        <?php if (Yii::$app->user->isGuest): ?>
            <p></p>
        <?php else: ?>
            <a onclick="location.href='<?= Url::to(['site/random-book']) ?>'" class="r-1">
                <button class="redeng">
                    <img src="image/strelka.png" alt="" class="b">Читать книгу
                </button>
            </a>
            <a href="<?=Url::toRoute(['site/about']);?>" class="b-1">
                <button class="books">О книгах</button>
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="books-glav">
    <div class="container-books">
        <!--   Если нет ссессии     -->
        <?php if (Yii::$app->user->isGuest): ?>
            <p></p>
        <?php else: ?>
            <!--    Новинки    -->
            <div class="brt">
                <div class="zag">
                    <h3>Новинки</h3>
                    <img src="image/srelka-zag-1.png" alt="" class="books-strelka">
                </div>

                <div class="books-container-book" style="    display: flex;
    flex-wrap: wrap;">
                    <?php foreach($new as $item): ?>
                        <div class="books_disp">
                            <a href="<?=Url::toRoute(['site/books', 'id' => $item->id]);?>" class="books-a">
                                <div class="opisanie">
                                    <img src="image/books/<?= $item->image ?>" alt="" class="books-img">
                                    <p class="opisanie-p"><?= $item->name ?></p>
                                    <p class="opisanie-author"><?= $item->author->nsp ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!--   Популярные     -->
            <div class="brt">
                <div class="zag">
                    <h3>Популярное</h3>
                    <img src="image/srelka-zag.png" alt="" class="books-strelka">
                </div>

                <div class="books-container-book" style="    display: flex;
    flex-wrap: wrap;">
                    <?php foreach($populars as $item): ?>
                        <div class="books_disp">
                            <a href="<?=Url::toRoute(['site/books', 'id' => $item->id, 'books_id'=>$item->id]);?>" class="books-a">
                                <div class="opisanie">
                                    <img src="image/books/<?= $item->image ?>" alt="" class="books-img">
                                    <p class="opisanie-p"><?= $item->name ?></p>
                                    <p class="opisanie-author"><?= $item->author->nsp ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!--    Авторы    -->
            <div class="brt">
                <div class="zag">
                    <h3>Авторы</h3>
                    <img src="image/srelka-zag.png" alt="" class="books-strelka">
                </div>

                <div class="books-container-book" style="    display: flex;
    flex-wrap: wrap;">
                    <?php foreach($author as $item): ?>
                        <div class="books_disp">
                            <a href="<?=Url::toRoute(['site/author', 'id' => $item->id, 'books_id'=>$item->id]);?>" class="books-a">
                                <div class="opisanie">
                                    <img src="image/author/<?= $item->image ?>" alt="" class="books-img">
                                    <p class="opisanie-p"><?= $item->nsp ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>


            <!--   Книги     -->
            <div class="brt">
                <div class="zag">
                    <h3>Книги</h3>
                    <img src="image/srelka-zag.png" alt="" class="books-strelka">
                </div>

                <div class="books-container-book" style="    display: flex;
    flex-wrap: wrap;">
                    <?php foreach($books as $item): ?>
                        <div class="books_disp">
                            <a href="<?=Url::toRoute(['site/books', 'id' => $item->id, 'books_id'=>$item->id]);?>" class="books-a">
                                <div class="opisanie">
                                    <img src="image/books/<?= $item->image ?>" alt="" class="books-img">
                                    <p class="opisanie-p"><?= $item->name ?></p>
                                    <p class="opisanie-author"><?= $item->author->nsp ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="wer" style="margin-left: 5px;;
    margin-top: 24px; border: none">
                    <?php
                    echo LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>