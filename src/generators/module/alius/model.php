<?php
/**
 * This is the template for generating a model class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getModelNamespace() ?>;

use Yii;
use yii\db\ActiveRecord;

/**
 * Default model for the `<?= $generator->moduleClass ?>` module
 */
class <?= $generator->moduleClass ?> extends ActiveRecord {
 
    public static function tableName() {
        return 'YOUR-TABLE-NAME';
    }

    public function rules() {
        return [
            [['id'], 'integer'],
            [['source'], 'string', 'max' => 255],
            [['randomDate'], 'date', 'format' => 'yyyy-MM-dd'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'source' => Yii::t('app', 'Forrás'),
            'randomDate' => Yii::t('app', 'Véletlenszerű dátum'),
        ];
    }
}
