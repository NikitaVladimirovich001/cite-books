<?php

use yii\helpers\Html;

$this->title = 'Результаты поиска';

?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php if (!empty($books)): ?>
    <ul>
        <?php foreach ($books as $book): ?>
            <li><?= Html::a(Html::encode($book->name), ['book/view', 'id' => $book->id]) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Книги не найдены.</p>
<?php endif; ?>