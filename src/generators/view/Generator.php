<?php
namespace yii\gii\generators\view;

use yii\gii\CodeFile;
use yii\helpers\Html;
use Yii;
use yii\helpers\StringHelper;

/**
 * This generator will generate the skeleton code needed by a Madrapur view.
 *
 * @author Péter Alius <peter.alius92@gmail.com>
 */
class Generator extends \yii\gii\Generator {
    public $viewName;
    public $moduleName;
    public $moduleNS;
    public $adminNeeded;

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'View Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription() {
        return 'This generator helps you to generate the skeleton code needed by a Madrapur view.';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['viewName', 'moduleNS', 'moduleName', 'adminNeeded'], 'filter', 'filter' => 'trim'],
            [['viewName', 'moduleNS', 'moduleName'], 'required'],
            [['viewName'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Only word characters and dashes are allowed.'],
            [['viewName', ], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'viewName' => 'View Name',
            'moduleNS' => 'View Namespace',
            'moduleName' => 'Module Name',
            'adminNeeded' => 'Generate admin view?',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function hints() {
        return [
            'viewName' => 'This refers to the name of the view, e.g., <code>MyView</code>.',
            'moduleName' => 'This refers to the name of the module, e.g., <code>MyModule</code>.',
            'moduleNS' => 'This refers to the namespace module class, e.g., <code>backend</code>.',
            'adminNeeded' => 'Set to <code>true</code> if an admin view is necessary.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function successMessage() {
        $output = <<<EOD
<p>The view has been generated successfully.</p>
<p>To access the view, you need to do absolutely nothing, just navigate to the module!</p>
EOD;
        $code = <<<EOD
<?php

EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates() {
        return ['react.php'];
    }

    /**
     * {@inheritdoc}
     */
    public function generate() {
        $files = [];

        $files = array_merge(
            $files,
            $this->createViewFile()
        );

        if ($this->adminNeeded) {
            $files = array_merge(
                $files,
                $this->createViewFile('admin')
            );  
        }

        return $files;
    }

    public function createViewFile($fileName = 'index') {
        return [
            new CodeFile(
                $this->getModuleNSClass() . '/views/' . $this->viewName . '/' . $fileName . '.php',
                $this->render("react.php")
            ),
        ];
    }

    public function getModuleNS() {
        return Yii::getAlias('@' . $this->moduleNS);
    }

    public function getModuleNSClass() {
        return $this->getModuleNS() . "\\modules\\" . $this->moduleName;
    } 
}
