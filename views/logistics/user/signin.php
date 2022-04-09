<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group">
    <div>
        <?= Html::submitButton('Войти', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>