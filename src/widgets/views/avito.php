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
<style>
    .avito-height {
        height: 100px;
    }
</style>
<div class="panel panel-default">
    <div class="panel-body">
        <h4>Avito</h4>

        <?= $form->field($avitoModel, 'is_active')->checkbox() ?>

        <div class="avito-dropdown <?= $avitoModel->is_active ? '' : 'hide' ?>">
            <h5>Обязательные поля</h5>
            <?= $form->field($avitoModel, 'description')->textInput(['maxlength' => true])->widget(CKEditorWidget::class, [
                'options' => ['rows' => 6],
                'preset' => CKEditorPresets::FULL,
                'clientOptions' => ElFinder::ckeditorOptions('elfinder', ['language' => 'ru']),
            ]) ?>
            <div class="row">
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'address')->textInput(['maxlength' => true, 'placeholder' => 'ул. Солнечная, уч.15']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'price')->textInput(['maxlength' => true, 'placeholder' => '25000000']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'square')->textInput(['maxlength' => true, 'placeholder' => '5000']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'land_area')->textInput(['maxlength' => true, 'placeholder' => '250']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'object_type')->dropDownList($avitoModel->objectType) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'rooms')->dropDownList($avitoModel->roomValues, ['prompt' => 'Выберите']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'property_rights')->dropDownList($avitoModel->propertyRights) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'floors')->dropDownList($avitoModel->floorValues, ['prompt' => 'Выберите']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'walls_type')->dropDownList($avitoModel->wallsType, ['prompt' => 'Выберите']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'land_status')->dropDownList($avitoModel->landStatus, ['prompt' => 'Выберите']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'renovation')->dropDownList($avitoModel->renovationValues, ['prompt' => 'Выберите']) ?>
                </div>
            </div>

            <h4>Необязательные поля</h4>
            <div class="row">
                <div class="col-xs-6 col-xs-12">
                    <?= $form->field($avitoModel, 'built_year')->textInput(['maxlength' => true, 'placeholder' => '2025']) ?>
                </div>
                <div class="col-xs-6 col-xs-12">
                    <?= $form->field($avitoModel, 'video_url')->textInput(['maxlength' => true, 'placeholder' => 'https://rutube.ru/video/cbe29e13e0f638a5b9faece3b75b12d8']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'external_id')->textInput(['maxlength' => true, 'placeholder' => '7378930804']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'manager_name')->textInput(['maxlength' => true, 'placeholder' => 'Андрей']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'phone')->textInput(['maxlength' => true, 'placeholder' => '+79052070490']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'contact_method')->dropDownList($avitoModel->contactMethods) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'safe_demonstration')->dropDownList($avitoModel->safeDemonstrations) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'land_additionally')->dropDownList($avitoModel->landAdditionally, ['prompt' => 'Выберите']) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'bathroom_multi')->dropDownList($avitoModel->bathroomMulti) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'house_additionally')->dropDownList($avitoModel->houseAdditionally) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'transport_accessibility')->dropDownList($avitoModel->transportAccessibility) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'parking_type')->dropDownList($avitoModel->parkingType) ?>
                </div>
                <div class="col-sm-6 col-xs-12 avito-height">
                    <?= $form->field($avitoModel, 'electricity')->dropDownList($avitoModel->electricityValues) ?>
                </div>
            </div>
            
            <?php // = $form->field($avitoModel, 'house_services')->dropDownList($avitoModel->houseServices, ['prompt' => 'Выберите']) ?>
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