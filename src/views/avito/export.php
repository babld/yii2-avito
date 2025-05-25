<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var bool $success
 */
?>

<?php if ($success): ?>
    <p class="text-success">Экспорт в xml-файл прошел успешно.</p>
    <p>Посмотреть можно <?= Html::a('тут', Url::to(['/upload/avito.xml'], true), ['target' => '_blank']) ?>.</p>
    <br>
    На Авито загрузится согласно настройкам автозагрузки. Посмотреть настройки автозагруки авито можно <?= Html::a('тут', Url::to('https://www.avito.ru/autoload/settings'), ['target' => '_blank']) ?>
<?php else: ?>
    <p class="text-danger">Ошибка экспорта в файл</p>
<?php endif ?>


