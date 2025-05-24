<?php

namespace babld\avito\behaviors;

use babld\avito\models\Avito;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii;
use yii\base\Event;
use yii\db\Exception;
use yii\helpers\StringHelper;

class AvitoFields extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updateFields',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateFields',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteFields',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'validateFields',
        ];
    }

    public function getOwnerClassName()
    {
        return StringHelper::basename($this->owner::className());
    }

    /**
     * @throws Exception
     */
    public function updateFields(Event $event)
    {
        if (!isset(Yii::$app->request) || !method_exists(Yii::$app->request, 'post')) {
            return;
        }

        $post = Yii::$app->request->post();

        if (!$model = $this->findModel()) {
            $model = new Avito;
        }

        $model->load($post);
        $this->feel($model);
        $model->save();
    }

    protected function feel(Avito &$model)
    {
        $model->item_id = $this->owner->id;
        $model->model_name = $this->getOwnerClassName();
        $model->internal_id = $this->getId();
        $model->category = 'Дома, дачи, коттеджи';
        $model->operation_type = 'Продам';
    }

    public function findModel(): ?Avito
    {
        return Avito::findOne(['item_id' => $this->owner->id, 'model_name' => $this->getOwnerClassName()]);
    }

    public function deleteFields($event)
    {
        if ($this->owner->avito) {
            $this->owner->avito->delete();
        }

        return true;
    }

    public function validateFields(Event $event)
    {
        /** @var Avito $avitoModel */
        if (!$avitoModel = $this->findModel()) {
            $avitoModel = new Avito;
        }

        if ($avitoModel->load(Yii::$app->request->post())) {
            $this->feel($avitoModel);

            if (!$avitoModel->is_active) {
                return true;
            }

            if (!$avitoModel->validate()) {
                foreach ($avitoModel->errors as $attribute => $errors) {
                    foreach ($errors as $error) {
                        $this->owner->addError('Avito.' . $attribute, $error);
                    }
                }
            }
        }
    }

    protected function getId(): string
    {
        return mb_strtolower($this->getOwnerClassName() . '_' . $this->owner->id);
    }
}
