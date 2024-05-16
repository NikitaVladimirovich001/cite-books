<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\components\SearchWidget;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon-16x16.png')]);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="favicons/site.webmanifest">
    <link rel="mask-icon" href="favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="" id="theme">
    <script src="//code.jivo.ru/widget/tffjvfaD2h" async></script>
    <script src="/web/js/script.js"></script>

</head>
<body>
<?php $this->beginBody() ?>

<header>
    <div class="navbar-container">
        <div class="block-1">

            <button id="btn_menu" class="btn_menu">
                <div class="wrap-logo-and-menu">
<!--                    <img src="image/menu.png" alt="" class="navbar-menu">-->
                    <img src="../image/menu.png" alt="" class="navbar-menu" id="btn_menu">
                    <div class="navbar-logo">
                        <a href="<?= Yii::$app->homeUrl ?>"><div class="logo">КнигаТут</div></a>
                    </div>
                </div>
            </button>

            <div class="modal" id="modal">
                <div class="modal_content">
                    <div class="model_content_smena">
                        <button id="switchMode" class="modal_content_button">
                            <img src="/image/dark.png" class="modal_content_img_dark">
                            <p class="modal_content_text">Смена темы</p>
                        </button>
                    </div>
                </div>
            </div>


        </div>
        <div class="block-2" id="navigationBlock">
            <ul class="navbar-ul">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="navbar-li" style="margin-left: 90px;"><a href="<?= Yii::$app->homeUrl ?>" id="button1">Главное</a></li>
                <?php endif; ?>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li class="navbar-li"><a href="<?= Yii::$app->homeUrl ?>">Главное</a></li>
                    <li class="navbar-li"><a href="<?= Url::to(['/site/my']) ?>">Моё</a></li>
                    <li class="navbar-li"><a href="<?= Url::to(['/site/category']) ?>">Жанры</a></li>
                    <li class="navbar-li">
                        <button id="searchButton">
                            <img src="../image/search1.png" alt="" class="search">
                        </button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="block-2" id="searchBlock" style="display: none;">
            <div style="display: flex;">
                <?php echo SearchWidget::widget(); ?>
            </div>
        </div>

        <button id="closeSearchButton" class="button-zak" style="display: none; margin-top: 7px; background-color: transparent; border: none; cursor: pointer; margin-left: 5px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#C6C6C6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <script>
            document.getElementById('searchButton').addEventListener('click', function() {
                document.getElementById('navigationBlock').style.display = 'none';
                document.getElementById('searchBlock').style.display = 'block';
                document.getElementById('closeSearchButton').style.display = 'block'; // Показываем кнопку закрытия поиска
            });

            document.getElementById('closeSearchButton').addEventListener('click', function() {
                document.getElementById('navigationBlock').style.display = 'block';
                document.getElementById('searchBlock').style.display = 'none';
                document.getElementById('closeSearchButton').style.display = 'none'; // Скрываем кнопку закрытия поиска
            });
        </script>
        <div class="block-3">
            <ul class="navbar-ul">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="navbar-li" style="margin-left: 60px"><a href="<?= Url::to(['/site/login']) ?>">Войти</a>
                    </li>
                    <li class="navbar-li"><a href="<?= Url::to(['/site/register']) ?>">Регистрация</a></li>
                <?php else: ?>
                    <li class="navbar-li">
                        <?= Html::a('Выйти', ['/site/logout'], ['class' => 'navbar-li', 'data' => ['method' => 'post']]) ?>
                    </li>
<!--                    <a href="--><?//= Url::to(['/site/kabinet']) ?><!--"><img src="../image/avatar.png" alt=""-->
<!--                                                                     class="img-kabinet"></a></li>-->
                    <a href="<?= Url::to(['/site/kabinet']) ?>"><img src="../image/avatar.png" alt="" class="img-kabinet"></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>


<main id="main" class="flex-shrink-0" role="main">
    <?php if (!empty($this->params['breadcrumbs'])): ?>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    <?php endif ?>
    <?= Alert::widget() ?>
    <?= $content ?>

</main>

<?php if (Yii::$app->user->isGuest): ?>
    <footer class="footer" style="margin-top: -19px;">
        <hr class="footer-hr">
        <div class="footer-container">
            <h3 class="footer-h">Мы всегда готовы вам помочь</h3>
            <?php if (Yii::$app->user->isGuest): ?>
                <li class="footer-li"><a href="<?= Url::to(['/site/login']) ?>">Оставить заявку</a></li>
            <?php else: ?>
                <li class="footer-li"><a href="<?= Url::to(['/site/proposal']) ?>">Оставить заявку</a></li>
            <?php endif; ?>
        </div>
        <hr class="footer-hr">
        <div class="f">
            <p class="footer-p">© 2023 КнигаТут. 18+</p>
            <p class="footer-p">Проект разработан Лапиным Никитой В.</p>
        </div>
    </footer>
<?php else: ?>
    <footer class="footer">
        <hr class="footer-hr">
        <div class="footer-container">
            <h3 class="footer-h">Мы всегда готовы вам помочь</h3>
            <li class="footer-li"><a href="<?= Url::to(['/site/proposal']) ?>">Задать вопрос</a></li>
        </div>
        <hr class="footer-hr">
        <div class="f">
            <p class="footer-p">© 2024 КнигаТут. 18+</p>
            <p class="footer-p">Проект разработан Лапиным Никитой В.</p>
        </div>
    </footer>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
