<?php

use yii\helpers\Html;
?>
<p>Вы ввели следующую информацию:</p>

<ul>
    <li><label>username</label>: <?= Html::encode($model->username) ?></li>
    <li><label>tracker</label>: <?= Html::encode($model->tracker) ?></li>
</ul>