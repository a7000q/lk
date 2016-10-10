<?
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\roles\Role;
use kartik\grid\GridView;
use yii\helpers\Url;
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-role").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-role"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-role'])?>
    <?$form = ActiveForm::begin(['id' => 'add-role-form', 'options' => ['data-pjax' => true]]);?>
        <table class="table">
            <tr>
                <td>
                    <?=Select2::widget([
                        'name' => 'role',
                        'data' => ArrayHelper::map(Role::getAll(), 'name', 'name')
                    ])?>
                </td>
                <td>
                    <?=\kartik\helpers\Html::submitButton('Добавить', ['class' => 'btn btn-success'])?>
                </td>
            </tr>
        </table>
    <?ActiveForm::end(); ?>
<?Pjax::end()?>
<?= GridView::widget([
    'dataProvider' => $model->_user->rolesDataProvider,
    'id' => 'grid-roles',
    'columns' => [
        [
            'attribute' => 'name',
            'label' => 'Название роли'
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{delete}',
            'urlCreator' => function ($action, $modelRole, $key, $index) use ($model){
                return Url::toRoute(['user/remove-role', 'id_role' => $modelRole->name, 'id_user' => $model->id]);
            }
        ],
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-role'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]); ?>


