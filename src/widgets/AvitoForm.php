<?php

namespace babld\avito\widgets;

use babld\avito\models\Avito;
use Yii;
use yii\helpers\ArrayHelper;

class AvitoForm extends \yii\base\Widget
{
    public $model = null;
    public $modelName = null;
    public $form = null;
    public $title = 'Avito';

    public function init()
    {
        if (empty($this->modelName)) {
            $this->modelName = $this->model->getOwnerClassName();
        }

        parent::init();
    }

    public function run()
    {
        $avitoModel = $this->model->findModel() ?? new Avito;

        if (Yii::$app->request->post()) {
            $avitoModel->load(Yii::$app->request->post());
        }

        $avitoErrors = ArrayHelper::getValue($this->model->errors, 'Avito', []);
        foreach ($this->model->errors as $attribute => $errors) {
            if (stripos($attribute, 'Avito.') === 0) {
                $errorAttr = substr($attribute, 6);
                $avitoErrors[$errorAttr] = $errors;

                foreach ($errors as $error) {
                    $avitoModel->addError($errorAttr, $error);
                }
            }
        }

        return $this->render('avito', [
            'avitoModel' => $avitoModel,
            'form' => $this->form,
            'model' => $this->model,
        ]);
    }
}
