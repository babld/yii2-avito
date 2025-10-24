<?php

namespace babld\avito\components;

use dvizh\gallery\models\Image;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii;
use yii\helpers\Url;

class Avito
{
    public function generateXml($class, $itemIds): string
    {
        $xml = '<Ads formatVersion="3" target="Avito.ru">' . "\n";

        $xml .= $this->generateAds($class, $itemIds);

        $xml .= '</Ads>';

        return $xml;
    }

    protected function generateAds($class, $itemIds)
    {
        $return = '';
        $modelName = StringHelper::basename($class);

        $query = \babld\avito\models\Avito::find()->where(['item_id' => $itemIds, 'model_name' => $modelName]);

        foreach ($query->each() as $avito) {
            /** @var \babld\avito\models\Avito $avito */

            if (!$avito->is_active) {
                continue;
            }

            $model = $class::findOne($avito->item_id);

            $return .= "<Ad>\n";
            $return .= "\t<Images>\n";
            foreach ($model->images as $image) {
                /** @var Image $image */
                $return .= "\t\t" . '<Image url="' . Url::to(['/images/store/' . $image->filePath], true). '"/>' . "\n";
            }
            $return .= "\t" .'</Images>' . "\n";

            $return .= $this->getStringField('VideoURL', $avito->video_url);
            $return .= $this->getStringField('Id', $avito->internal_id);
            $return .= $this->getStringField('AvitoId', $avito->external_id);
            $return .= $this->getStringField('Category', $avito->category);
            $return .= $this->getStringField('Price', $avito->price);
            $return .= "\t" .'<Description><![CDATA[' . strip_tags($avito->description) . ']]></Description>' . "\n"; // FIXME: Уточнить откуда брать
            $return .= $this->getStringField('ManagerName', $avito->manager_name);
            $return .= $this->getStringField('Address', $this->getAddress($avito->address));
            $return .= $this->getArrayField('ContactMethod', $avito->contactMethods, $avito->contact_method);
            $return .= $this->getArrayField('SafeDemonstration', $avito->safeDemonstrations, $avito->safe_demonstration);
            $return .= $this->getStringField('InternetCalls', 'Нет');
            $return .= $this->getStringField('OperationType', $avito->operation_type);
            $return .= $this->getArrayField('PropertyRights', $avito->propertyRights, $avito->property_rights);
            $return .= $this->getArrayField('ObjectType', $avito->objectType, $avito->object_type);
            $return .= $this->getArrayField('Floors', $avito->floorValues, $avito->floors);
            $return .= $this->getArrayField('WallsType', $avito->wallsType, $avito->walls_type);
            $return .= $this->getStringField('Square', $avito->square);
            $return .= $this->getStringField('LandArea', $avito->land_area);
            $return .= $this->getStringField('BuiltYear', $avito->built_year);
            $return .= $this->getStringField('ListingFee ', $avito->listing_fee);
            $return .= $this->getArrayField('LandStatus', $avito->landStatus, $avito->land_status);
            $return .= $this->getArrayField('Renovation', $avito->renovationValues, $avito->renovation);
            $return .= $this->getArrayField('TransportAccessibility', $avito->transportAccessibility, $avito->transport_accessibility);
            $return .= $this->getArrayField('ParkingType', $avito->parkingType, $avito->parking_type);
            $return .= $this->getArrayField('Rooms', $avito->roomValues, $avito->rooms);
            $return .= $this->getArrayField('Electricity', $avito->electricityValues, $avito->electricity);
            $return .= $this->getArrayField('HouseAdditionally', $avito->houseAdditionally, $avito->house_additionally);

            $return .= '</Ad>' . "\n\n";
        };
        return $return;
    }

    protected function getAddress(string $suffix): string
    {
        $base = 'Ленинградская область, Приозерский район, Громовское сельское поселение, посёлок Портовое, ';

        return $base . $suffix;
    }

    public function saveXml($xml): bool
    {
        $file = Yii::getAlias('@webroot/upload/avito.xml');

        $fp = fopen($file, 'w');
        $success = fwrite($fp, $xml);
        fclose($fp);

        return $success;
    }

    public function getStringField($name, $value)
    {
        if ($value === null) {
            return '';
        }

        return "\t<$name>$value</$name>\n";
    }

    public function getArrayField($name, $values, $value)
    {
        if (!$value) {
            return '';
        }

        return "\t<$name>" . ArrayHelper::getValue($values, $value) . "</$name>\n";
    }
}