<?php

/** @var yii\web\View $this */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мое';
?>

<div class="books-glav">
    <div class="container-books">

        <!--    Избранное    -->
        <div class="brt">
            <div class="zag">
                <h3>Избранное</h3>
            </div>

            <div class="books-container-book" style="    display: flex;
    flex-wrap: wrap;">
                <?php if (empty($favoriteBooks)): ?>
                    <p style="">Пусто</p>
                <?php else: ?>
                    <?php foreach($favoriteBooks as $item): ?>
                        <div class="books_disp">
                            <a href="<?= Url::toRoute(['site/books', 'id' => $item->books->id]); ?>" class="books-a">
                                <div class="opisanie">
                                    <img src="../image/books/<?= $item->books->image ?>" alt="" class="books-img">
                                    <p class="opisanie-p"><?= $item->books->name ?></p>
                                    <p class="opisanie-author"><?= $item['books']['author']['nsp'] ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="brt">
            <div class="zag">
                <h3>История</h3>
            </div>

            <div class="books-container-book" style="    display: flex;
    flex-wrap: wrap;">
                <?php if (empty($userHistory)): ?>
                    <p style="padding-bottom: 275px">Пусто</p>
                <?php else: ?>
                    <?php foreach($userHistory as $item): ?>
                    <div class="books_disp">
                        <a href="<?= Url::toRoute(['site/books', 'id' => $item->books->id]); ?>" class="books-a">
                            <div class="opisanie">
                                <img src="../image/books/<?= $item->books->image ?>" alt="" class="books-img">
                                <p class="opisanie-p"><?= $item->books->name ?></p>
                                <p class="opisanie-author"><?= $item['books']['author']['nsp'] ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
