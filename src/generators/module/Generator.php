<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\gii\generators\module;

use yii\gii\CodeFile;
use yii\helpers\Html;
use Yii;
use yii\helpers\StringHelper;

/**
 * This generator will generate the skeleton code needed by a module.
 *
 * @property string $controllerNamespace The controller namespace of the module. This property is read-only.
 * @property bool $modulePath The directory that contains the module class. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    public $moduleNS;
    public $moduleClass;
    public $moduleID;
    private $moduleNSClass;


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Module Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'This generator helps you to generate the skeleton code needed by a Madrapur module.';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['moduleID', 'moduleClass', 'moduleNS'], 'filter', 'filter' => 'trim'],
            [['moduleID', 'moduleClass', 'moduleNS'], 'required'],
            [['moduleID'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Only word characters and dashes are allowed.'],
            [['moduleClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['moduleClass'], 'validateModuleClass'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'moduleNS' => 'Module Namespace',
            'moduleID' => 'Module ID',
            'moduleClass' => 'Module Class',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        return [
            'moduleNS' => 'This refers to the namespace of the module, e.g., <code>backend\modules</code>.',
            'moduleID' => 'This refers to the ID of the module, e.g., <code>admin</code>.',
            'moduleClass' => 'This is the fully qualified class name of the module, e.g., <code>app\modules\admin\Module</code>.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function successMessage()
    {
        if (Yii::$app->hasModule($this->moduleID)) {
            $link = Html::a('try it now', Yii::$app->getUrlManager()->createUrl($this->moduleID), ['target' => '_blank']);

            return "The module has been generated successfully. You may $link.";
        }

        $output = <<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to add this to your application configuration:</p>
EOD;
        $code = <<<EOD
<?php
    ......
    'modules' => [
        '{$this->moduleClass}' => [
            'class' => {$this->moduleNSClass}\Module::class,
        ],
    ],
    ......
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {
        return ['module.php', 'controller.php', 'view.php'];
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $files = [];
        $this->setModuleNSClass();

        $files = array_merge(
            $files,
            $this->createModuleFile(),
            $this->createModelFiles(),
            $this->createControllerFiles(),
            $this->createViewFiles()
        );

        return $files;
    }

    public function createModuleFile() {
        return [
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleClass . '/Module.php',
                $this->render("module.php")
            )
        ];
    }

    public function createControllerFiles() {        
        return [
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleClass . '/controllers/DefaultController.php',
                $this->render("controller.php")
            ),
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleClass . '/controllers/' . $this->moduleClass . 'Controller.php',
                $this->render("specialController.php")
            ),
        ];
    }

    public function createModelFiles() {
        return [
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleClass . '/models/' . $this->moduleClass . '.php',
                $this->render("model.php")
            ),
        ];
    }

    public function createViewFiles() {
        return [
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleClass . '/views/default/index.php',
                $this->render("view.php")
            ),
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleClass . '/views/' . $this->moduleID . '/index.php',
                $this->render("view.php")
            ),
            new CodeFile(
                $this->getModulePath() .'/' . $this->moduleClass . '/views/' . $this->moduleID . '/admin.php',
                $this->render("view.php")
            ),
        ];
    }

    /**
     * Validates [[moduleClass]] to make sure it is a fully qualified class name.
     */
    public function validateModuleClass()
    {
        if (!$this->moduleNSClass) $this->setModuleNSClass();

        if (strpos($this->moduleNSClass, '\\') === false || Yii::getAlias('@' . str_replace('\\', '/', $this->moduleNSClass), false) === false) {
            $this->addError('moduleClass', 'Module class must be properly namespaced.');
        }
        if (empty($this->moduleNSClass) || substr_compare($this->moduleNSClass, '\\', -1, 1) === 0) {
            $this->addError('moduleClass', 'Module class name must not be empty. Please enter a fully qualified class name. e.g. "app\\modules\\admin\\Module".');
        }
    }

    /**
     * @return bool the directory that contains the module class
     */
    public function getModulePath()
    {
        if (!$this->moduleNSClass) $this->setModuleNSClass();

        //echo Yii::getAlias('@' . str_replace('\\', '/', substr($this->moduleNSClass, 0, strrpos($this->moduleNSClass, '\\'))));
        return Yii::getAlias('@' . str_replace('\\', '/', substr($this->moduleNSClass, 0, strrpos($this->moduleNSClass, '\\'))));
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function getControllerNamespace()
    {
        if (!$this->moduleNSClass) $this->setModuleNSClass();

        return $this->moduleNSClass . '\controllers';
    }

    /**
     * @return string the model namespace of the module.
     */
    public function getModelNamespace()
    {
        if (!$this->moduleNSClass) $this->setModuleNSClass();

        return $this->moduleNSClass . '\models';
    }

    public function setModuleNSClass() {
        if (!strpos($this->moduleNS, "\\modules")) $this->moduleNS .= "\\modules";;

        $this->moduleNSClass = $this->moduleNS . '\\' . $this->moduleClass;
    }

    public function getModuleNSClass() {
        return $this->moduleNSClass;
    }
}
