<?php

use babld\avito\helpers\Repository;
use yii\db\ActiveRecord;
use babld\avito\models\Avito;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use skeeks\yii2\ckeditor\CKEditorPresets;
use skeeks\yii2\ckeditor\CKEditorWidget;
use mihaildev\elfinder\ElFinder;

/**
 * @var $form
 * @var string $modelName
 * @var ActiveRecord $model
 * @var Avito $avitoModel
 * @var Repository $repository
 */

?>

<div class="panel panel-default">
    <div class="panel-body">
        <h4>Avito</h4>


        <div class="has-error" style="color:red">
            <?php foreach($model->getErrors() as $key => $error): ?>
                <p><?php var_dump($key, $error); ?></p>
            <?php endforeach ?>

            <br>
            <?= Html::errorSummary($model, ['class' => 'alert alert-danger']) ?>
        </div>

        <div class="row">
            <?= $form->field($avitoModel, 'model_name')->hiddenInput(['value' => $modelName])->label(false); ?>
            <?php foreach ($repository->getHouseSales($model->id, $modelName) as $key => $val): ?>
                <?php
                $avitoModel->clearErrors();
                $baseValue = ArrayHelper::getValue($repository->houseSales, $key);
                $hasError = in_array('Avito[' . $key . ']', array_keys($model->getErrors()));

                if ($hasError) {
                    $error = ArrayHelper::getValue($model->getErrors(), 'Avito[' . $key . ']');
                    $avitoModel->addError('field_name', implode(', ', $error));
                }
                ?>

                <div class="col-xs-12">
                    <?php if (is_array($baseValue) && $baseValue['type'] === Repository::INPUT_TYPE_SELECT): ?>

                        <?= $form->field($avitoModel, 'field_name[' . $key . ']')
                            ->dropDownList($baseValue['values'], ['prompt' => 'Выберите', 'value' => $val['selected']])
                            ->label($key) ?>

                    <?php elseif (is_array($baseValue) && $baseValue['type'] === Repository::INPUT_TYPE_MULTI_SELECT): ?>

                        <?= $form->field($avitoModel, 'field_name[' . $key . ']')
                            ->dropDownList($baseValue['values'], ['prompt' => '', 'value' => $val['selected'], 'multiple' => true])
                            ->label($key) ?>

                    <?php elseif (is_array($baseValue) && $baseValue['type'] === Repository::INPUT_TYPE_TEXTAREA): ?>

                        <?= $form->field($avitoModel, 'field_name[' . $key . ']')
                            ->label($key)
                            ->widget(CKEditorWidget::class, [
                                'options' => ['rows' => 3],
                                'preset' => CKEditorPresets::FULL,
                                'clientOptions' => ElFinder::ckeditorOptions('elfinder', ['language' => 'ru']),
                            ])
                        ?>

                    <?php elseif (is_array($baseValue) && $baseValue['type'] === Repository::INPUT_TYPE_CHECKBOX_LIST): ?>

                        <?= $form->field($avitoModel, 'field_name[' . $key . ']')
                            ->label($key)
                            ->checkboxList(
                                $baseValue['values'],
                                ['value' => $val['selected']]
                            )
                        ?>

                    <?php elseif (is_array($baseValue) && $baseValue['type'] === Repository::INPUT_TYPE_CHECKBOX): ?>

                        <?= $form->field($avitoModel, 'field_name[' . $key . ']')
                            ->checkbox(['label' => $key, 'checked' => $val == 1])
                        ?>

                    <?php elseif (is_array($baseValue) && $baseValue['type'] === Repository::INPUT_TYPE_TEXT): ?>

                        <?= $form->field($avitoModel, 'field_name[' . $key . ']', [
                            'options' => ['class' =>  $hasError ? 'has-error' : ''],
                        ])
                            ->textInput([
                                'maxlength' => true,
                                'value' => ArrayHelper::getValue($val, 'value'),
                                'disabled' => ArrayHelper::getValue($val, 'disabled'),
                            ])
                            ->label($key)
                        ?>

                    <?php else: ?>

                        <?= $form->field($avitoModel, 'field_name[' . $key . ']')
                            ->textInput(['maxlength' => true, 'value' => $val])
                            ->label($key) ?>

                    <?php endif ?>
                </div>
            <?php endforeach; ?>

        </div>

        <p><strong>Неизменяемые параметры</strong></p>
        <div class="row">
            <?php foreach ($repository->houseSalesStatic as $key => $val): ?>

                <div class="col-sm-6 col-xs-12">
                    <label><?= $key ?></label>
                    <?= Html::textInput('test', $val, ['class' => 'form-control', 'disabled' => true]) ?>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>