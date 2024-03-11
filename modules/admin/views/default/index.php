<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
?>
<aside>
    <span class="logo">Админка</span>

    <ul style="margin-top: 71px;">
        <a href="<?php echo Url::toRoute(['site/'])?>"><li><i class="fa fa-solid fa-check"></i>Выйти</li></a>
    </ul>
    <h3>Основные</h3>
    <ul>
        <a href="<?php echo Url::toRoute(['category/index'])?>"><li><i class="fas fa-home"></i>Категории</li></a>
        <a href="<?php echo Url::toRoute(['books/index'])?>"><li><i class="fas fa-address-card"></i>Книги</li></a>
        <a href="<?php echo Url::toRoute(['proposal/index'])?>"><li><i class="fa fa-solid fa-check"></i>Обращения</li></a>
        <a href="<?php echo Url::toRoute(['author/index'])?>"><li><i class="fa fa-solid fa-check"></i>Авторы</li></a>
    </ul>
</aside>
