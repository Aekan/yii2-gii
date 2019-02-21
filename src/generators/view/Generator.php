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
    public $moduleNS;

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
            [['viewName'], 'filter', 'filter' => 'trim'],
            [['viewName'], 'required'],
            [['viewName'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Only word characters and dashes are allowed.'],
            [['viewName'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'viewName' => 'View Name',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function hints() {
        return [
            'viewName' => 'This refers to the name of the module, e.g., <code>MyView</code>.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function successMessage() {
        $output = <<<EOD
<p>The view has been generated successfully.</p>
<p>To access the view, you need to add this to your application configuration:</p>
EOD;
        $code = <<<EOD
<?php
    ......
    'modules' => [
        '{$this->moduleID}' => [
            'class' => {$this->moduleNSClass}::class,
        ],
    ],
    ......
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
            $this->createViewFiles()
        );

        return $files;
    }

    public function createViewFiles() {
        return [
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleID . '/views/default/index.php',
                $this->render("react.php")
            ),
        ];
    }
}
