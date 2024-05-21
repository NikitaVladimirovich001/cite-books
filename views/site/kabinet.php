<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Кабинет';
?>

<body>
    <div class="books-glav" style="padding-bottom: 40px;">
        <div class="container-user-glav">
            <div class="container-user">
                <img src="../image/avatar-1.png" alt="" class="img-user-1">
                <div class="content-user">
                    <p class="user-p"><?= $user->surname ?> <?= $user->name ?> <?= $user->patronymic ?></p>
                    <p class="user-p">Логин: <?= $user->username ?></p>
                    <p class="created_at-user">Дата регистрации: <?= $user->created_at ?></p>
                    <ul class="kab-ul">
                        <li class="navbar-kabinet">
                            <?= Html::a('Выйти', ['/site/logout'], ['class' => 'na', 'data' => ['method' => 'post']]) ?>
                        </li>
                    </ul>
                </div>
            </div>
            <br>
            <br>
            <h3 style="margin-left: 326px;  color: #F25900">Ваш вопрос</h3>
            <br>
            <?php if (empty($proposal)): ?>
            <div class="card" style="width: 838px; margin-top: 30px">
                <div class="card-body">
                    <h6 style="color: black">У вас не было обращений!</h6>
                </div>
            </div>
            <?php else: ?>
                <?php foreach ($proposal as $item): ?>
                    <div class="card" style="width: 838px; margin-top: 30px">
                        <div class="card-body">
                            <p class="proposal-text-h">Формулировка вопроса:</p>
                            <p class="proposal-text-p"><?= $item->body ?></p>
                            <img src="../image/uploads/<?= $item->image ?>" alt="" class="img-proposal">
                             <p class="created_at-user">Статус: <?php echo $item->getStatus() ?></p>
                             <?php if($item->soob):?>
                                 <p class="proposal-text-p">Администратор  : <?php echo $item->soob ?></p>
                             <?php else: ?>

                             <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>