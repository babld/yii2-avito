<?php

use babld\avito\helpers\Repository;
use yii\db\ActiveRecord;
use babld\avito\models\Avito;
use yii\helpers\Html;
use skeeks\yii2\ckeditor\CKEditorPresets;
use skeeks\yii2\ckeditor\CKEditorWidget;
use mihaildev\elfinder\ElFinder;

/**
 * @var $form
 * @var string $modelName
 * @var Avito $avitoModel
 * @var ActiveRecord $model
 * @var Repository $repository
 */

?>

<div class="panel panel-default">
    <div class="panel-body">
        <h4>Avito</h4>

        <?= $form->field($avitoModel, 'is_active')->checkbox() ?>

        <div class="avito-dropdown <?= $avitoModel->is_active ? '' : 'hide' ?>">
            <?= $form->field($avitoModel, 'description')->textInput(['maxlength' => true])->widget(CKEditorWidget::class, [
                'options' => ['rows' => 6],
                'preset' => CKEditorPresets::FULL,
                'clientOptions' => ElFinder::ckeditorOptions('elfinder', ['language' => 'ru']),
            ]) ?>

            <?= $form->field($avitoModel, 'video_url')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'external_id')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'rooms')->dropDownList($avitoModel->roomValues, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'property_rights')->dropDownList($avitoModel->propertyRights) ?>
            <?= $form->field($avitoModel, 'object_type')->dropDownList($avitoModel->objectType, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'floors')->dropDownList($avitoModel->floorValues, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'walls_type')->dropDownList($avitoModel->wallsType, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'square')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'land_area')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'manager_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'phone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($avitoModel, 'land_status')->dropDownList($avitoModel->landStatus, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'renovation')->dropDownList($avitoModel->renovationValues, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'contact_method')->dropDownList($avitoModel->contactMethods) ?>
            <?= $form->field($avitoModel, 'safe_demonstration')->dropDownList($avitoModel->safeDemonstrations) ?>
            <?= $form->field($avitoModel, 'land_additionally')->dropDownList($avitoModel->landAdditionally, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'bathroom_multi')->dropDownList($avitoModel->bathroomMulti) ?>
            <?= $form->field($avitoModel, 'house_additionally')->dropDownList($avitoModel->houseAdditionally) ?>
            <?php // = $form->field($avitoModel, 'house_services')->dropDownList($avitoModel->houseServices, ['prompt' => 'Выберите']) ?>
            <?= $form->field($avitoModel, 'transport_accessibility')->dropDownList($avitoModel->transportAccessibility) ?>
            <?= $form->field($avitoModel, 'parking_type')->dropDownList($avitoModel->parkingType) ?>
            <?= $form->field($avitoModel, 'built_year')->textInput(['maxlength' => true]) ?>
        </div>

        <?= Html::error($model, 'description') ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.field-avito-is_active input').click(function() {
                $('.avito-dropdown').toggleClass('hide');
            });
        });
    </script>
</div>