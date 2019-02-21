<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use Yii;
use backend\controllers\Controller;

/**
 * Controller for the `<?= $generator->moduleClass ?>` module
 */
class <?= $generator->moduleClass ?>Controller extends Controller {
    /**
     * Renders the admin view for the module
     * @return string
     */
    public function actionAdmin() {
        return $this->render('admin');
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
}
