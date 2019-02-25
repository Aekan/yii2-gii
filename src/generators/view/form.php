<?php
    $nsDropdownItems = [
        "backend" => "Backend module",
        "frontend" => "Frontend module",
        "api" => "API module",
        "storage" => "Storage module"
    ];
?>
<div class="module-form">
    <?php
        echo $form->field($generator, 'moduleNS')
                ->dropDownList($nsDropdownItems, ['prompt' => 'Select Option']);

        echo $form->field($generator, 'moduleName');

        echo $form->field($generator, 'viewName');

        echo $form->field($generator, 'reactClassName');

        echo $form->field($generator, 'adminNeeded')
                ->checkbox([
                    'value' => true,
                    'uncheck' => false,
                    $generator->adminNeeded ? 'checked' : ''
                ]);
    ?>
</div>
