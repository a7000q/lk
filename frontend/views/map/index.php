<?

use common\assets\YandexMapAsset;
use kartik\form\ActiveForm;

YandexMapAsset::register($this);

$this->title = $map->name;
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/map/script.js', ['depends' => 'common\assets\YandexMapAsset', 'position' => \yii\web\View::POS_HEAD]);
?>

<div class="tables-index">

    <h2><?=$this->title;?></h2>

    <div id="myMap" style="weight: 100%; height: 600px;"></div>
    <?$form = ActiveForm::begin()?>
    <?ActiveForm::end();?>

    <div id="points" style="display: none;">
        <?foreach ($map->mapPoints as $point):?>
            <div class="point">
                <input type="hidden" class="name" value="<?=$point->name?>">
                <input type="hidden" class="description" value="<?=$point->description?>">
                <input type="hidden" class="coords" value="<?=$point->value?>">
            </div>
        <?endforeach;?>
    </div>
</div>


