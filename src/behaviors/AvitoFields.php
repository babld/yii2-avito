<?php

namespace babld\avito\behaviors;

use babld\avito\helpers\Repository;
use babld\avito\models\Avito;
use yii\helpers\ArrayHelper;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii;
use yii\base\Event;
use yii\db\Exception;

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

    public function getAvitoClassName()
    {
        $model = explode('\\', $this->owner::class);

        return end($model);
    }

    /**
     * @throws Exception
     */
    public function updateFields(Event $event)
    {
        if (isset(Yii::$app->request) && method_exists(Yii::$app->request, 'post')) {
            $post = Yii::$app->request->post();
            $modelName = $this->getAvitoClassName();

            if (Avito::findOne(['item_id' => $this->owner->id, 'model_name' => $modelName])) {
                Avito::deleteAll(['item_id' => $this->owner->id, 'model_name' => $modelName]);
            }

            $items = [];
            foreach ($post['Avito']['field_name'] as $key => $value) {

                $baseValue = new Repository()->houseSales[$key];
                $type = ArrayHelper::getValue($baseValue, 'type');
                $avitoRequest = Yii::$app->request->post('Avito');

                if (
                    is_array($baseValue)
                    && in_array($type, [Repository::INPUT_TYPE_MULTI_SELECT, Repository::INPUT_TYPE_CHECKBOX_LIST])
                ) {

                    if (!is_array(Yii::$app->request->post('Avito')['field_name'][$key])) {
                        continue;
                    }

                    foreach (Yii::$app->request->post('Avito')['field_name'][$key] ?? [] as $val) {
                        $items[] = [
                            'item_id' => $this->owner->id,
                            'model_name' => $modelName,
                            'value' => $val,
                            'field_name' => $key,
                        ];
                    }
                } else {
                    $items[] = [
                        'item_id' => $this->owner->id,
                        'model_name' => $modelName,
                        'value' => $value,
                        'field_name' => $key,
                    ];
                }
            }

            Yii::$app->db->createCommand()
                ->batchInsert(Avito::tableName(), ['item_id', 'model_name', 'value', 'field_name'], $items)
                ->execute();
        }
    }

    public function deleteFields($event)
    {
        if ($this->owner->avito) {
            $this->owner->avito->delete();
        }

        return true;
    }

    public function getAvito()
    {
        if ($model = Avito::find()->where(['item_id' => $this->owner->id, 'modelName' => $this->getAvitoClassName()])->one()) {
            return $model;
        } else {
            return new Avito;
        }
    }

    public function validateFields(Event $event)
    {
        $avitoRequest = Yii::$app->request->post('Avito');
        $avitoFields = ArrayHelper::getValue($avitoRequest, 'field_name');

        $isActive = (bool) ArrayHelper::getValue($avitoFields, Repository::FIELD_IS_ACTIVE, false);

//        echo "<pre>"; var_dump($isActive, $avitoRequest);exit;

        if ($isActive) {

             $event->isValid = false;
    //        $this->owner->addErrors([
    //            ["Avito[Address]" => 'Необходимо заполнить адрес'],
    //            ["Avito[field_name][Address]" => 'error 2'],
    //            ['price' => 'error 3'],
    //        ]);
            $this->owner->addError('Lots[price]', 'price error');
            $this->owner->addError('Avito[' . Repository::FIELD_ADDRESS. ']', 'address error');
            //echo "<pre>"; var_dump($avitoRequest);exit;
        }
    }
}