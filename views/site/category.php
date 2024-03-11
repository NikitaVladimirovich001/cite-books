<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Категории';
?>
<div class="category-container-glav">
    <?php foreach($categories as $category): ?>
        <a href="<?=Url::toRoute(['site/mycategory', 'id' => $category['id']]);?>" class="">
            <div class="category-block">
                <p class="category-text-1"><?= $category['name'] ?></p>
                <img src="../image/genres/<?= $category['image'] ?>" alt="" class="image-category-block">
                <p class="category-text">Перейти</p>
            </div>
        </a>
    <?php endforeach; ?>
</div>