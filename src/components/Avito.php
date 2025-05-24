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
            $return .= "\t" .'<VideoURL>' . $avito->video_url . '</VideoURL>' . "\n";
            $return .= "\t" .'<Id>' . $avito->internal_id . '</Id>' . "\n";
            $return .= "\t" .'<AvitoId>' . $avito->external_id . '</AvitoId>' . "\n";
            $return .= "\t" .'<Category>' . $avito->category . '</Category>' . "\n";
            $return .= "\t" .'<Price>' . $avito->price . '</Price>' . "\n";

            $return .= "\t" .'<Description><![CDATA[' . strip_tags($avito->description) . ']]></Description>' . "\n"; // FIXME: Уточнить откуда брать
//            $return .= '<ManagerName>' . $avito->manager_name . '</ManagerName>' . "\n";
//            $return .= '<ContactPhone>' . $this->getPhone($avito) . '</ContactPhone>' . "\n";
            $return .= "\t" .'<Address>' . $this->getAddress($avito->address) . '</Address>' . "\n";

//            if ($latitude && $longitude) {
//                $return .= '<Latitude>' . $latitude . '</Latitude>' . "\n";
//                $return .= '<Longitude>' . $longitude . '</Longitude>' . "\n";
//            }

            $return .= "\t" .'<ContactMethod>По телефону</ContactMethod>' . "\n";
            $return .= "\t" .'<InternetCalls>Нет</InternetCalls>' . "\n";
//            $return .= '<CallsDevices></CallsDevices>' . "\n";
            $return .= "\t" .'<OperationType>' . $avito->operation_type .'</OperationType>' . "\n";
            $return .= "\t" .'<SafeDemonstration>Не хочу</SafeDemonstration>' . "\n";

            $return .= "\t" .'<LandAdditionally>' . "\n";
//            $return .= '<Option>Баня или сауна</Option>' . "\n";
//            $return .= '<Option>Бассейн</Option>' . "\n";
            $return .= "\t" .'</LandAdditionally>' . "\n";

            $return .= "\t" .'<BathroomMulti>' . "\n";
            $return .= "\t\t" .'<Option>В доме</Option>' . "\n";
//            $return .= '<Option>На улице</Option>' . "\n";
            $return .= "\t" .'</BathroomMulti>' . "\n";

//            $return .= '<HouseAdditionally>' . "\n";
//            $return .= '<Option>Терраса или веранда</Option>' . "\n";
//            $return .= '</HouseAdditionally>' . "\n";

            $return .= "\t" .'<Electricity>Есть</Electricity>' . "\n";
            $return .= "\t" .'<GasSupply></GasSupply>' . "\n";
//            $return .= '<Heating>' . $avito->heating . '</Heating>' . "\n";

//            if ($avito->heating) {
//                $return .= '<HeatingType>' . $this->heating_type . '</HeatingType>' . "\n";
//            }

//            $return .= '<WaterSupply>' . $avito->water_supply . '</WaterSupply>' . "\n";
//            $return .= '<Sewerage>' . $avito->sewerage . '</Sewerage>' . "\n";
            $return .= "\t" .'<TransportAccessibility></TransportAccessibility>' . "\n";
            $return .= "\t" .'<Infrastructure></Infrastructure>' . "\n";
            $return .= "\t" .'<ParkingType></ParkingType>' . "\n";
            $return .= "\t" .'<Rooms>' . $avito->rooms . '</Rooms>' . "\n";
            $return .= "\t" .'<BuiltYear></BuiltYear>' . "\n";
            $return .= "\t" .'<LeaseMultimedia></LeaseMultimedia>' . "\n";
            $return .= "\t" .'<PropertyRights>' . $avito->property_rights . '</PropertyRights>' . "\n";
            $return .= "\t" .'<ObjectType>' . $avito->object_type. '</ObjectType>' . "\n";
            $return .= "\t" .'<Floors>' . $avito->floors . '</Floors>' . "\n";
            $return .= "\t" .'<WallsType>' . $avito->walls_type . '</WallsType>' . "\n";
            $return .= "\t" .'<Square>' . $avito->square . '</Square>' . "\n";
//            $return .= '<LandArea>' . $avito->square . '</LandArea>' . "\n";
            $return .= "\t" .'<LandStatus>' . $avito->land_status . '</LandStatus>' . "\n";
            $return .= "\t" .'<SaleOptions></SaleOptions>' . "\n"; // FIXME
            $return .= "\t" .'<Renovation>' . $avito->renovation . '</Renovation>' . "\n";
            $return .= '</Ad>' . "\n\n";
        };
        return $return;
    }

    protected function getCoords($model): array
    {
        if (empty($model->coords)) {
            return [null, null];
        }

        $firstCoords = explode(';', $model->coords);

        if (empty($firstCoords) || !ArrayHelper::getValue($firstCoords, '0')) {
            return [null, null];
        }

        $coords = explode(',', ArrayHelper::getValue($firstCoords, '0'));

        if (empty($coords) || count($coords) < 2) {
            return [null, null];
        }

        return $coords;
    }

    protected function getAddress(string $suffix): string
    {
        $base = 'Ленинградская область, Приозерский район, Громовское сельское поселение, посёлок Портовое, ';

        return $base . $suffix;
    }

    protected function getPhone($lot): string
    {
        return $lot->contact_phone;
    }

    public function saveXml($xml): bool
    {
        $file = Yii::getAlias('@webroot/upload/avito.xml');

        $fp = fopen($file, 'c');
        $success = fwrite($fp, $xml);
        fclose($fp);

        return $success;
    }
}