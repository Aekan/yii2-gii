<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */

$nsDropdownItems = [
    "backend\\modules" => "Backend module",
    "frontend\\modules" => "Frontend module",
    "api\\modules" => "API module",
    "storage\\modules" => "Storage module"
];

?>
<div class="module-form">
    <?php
        echo $form->field($generator, 'moduleNS')->dropDownList($nsDropdownItems, ['prompt'=>'Select Option']);
        echo $form->field($generator, 'moduleClass');
        echo $form->field($generator, 'moduleID');
    ?>
</div>
