<?php

namespace backend\components;

use common\models\Lots;
use dvizh\gallery\models\Image;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class Avito
{
    public static function generateXml(array $lots): array
    {
        $return = '<Ads formatVersion="3" target="Avito.ru">';

        return $return;
    }


    protected function getList($lots) {
        $return = '';

        foreach($lots as $lot) {
            /** @var Lots $lot */
            list ($latitude, $longitude) = $this->getCoords($lot);

            $return .= '<Ad>';
            $return .= '<Images>';
            foreach ($lot->images as $image) {
                /** @var Image $image */
                $return .= '<Image url="' . \yii\helpers\Url::to(['/images/store/' . $image->filePath]). '"/>';
            }
            $return .= '</Images>';
            $return .= '<VideoURL>https://rutube.ru/video/cbe29e13e0f638a5b9faece3b75b12d8/</VideoURL>';
            $return .= '<Id>' . $this->getId($lot) . '</Id>';
//            $return .= '<DateBegin>' . new \DateTime()->format('Y-m-d H:i') . '</DateBegin>'; // Это дата и время размещения объявления
//            $return .= '<DateEnd></DateEnd>';
//            $return .= '<ListingFee></ListingFee>';
//            $return .= '<AdStatus></AdStatus>';
//            $return .= '<AvitoId></AvitoId>'; // TODO: как то определять avitoId при последующих выгрузках и заполнять этот параметр
            $return .= '<Category>Дома, дачи, коттеджи</Category>';
            $return .= '<Price>' . $lot->price . '</Price>';

            $return .= '<Description><![CDATA[' . strip_tags($lot->short_text) . ']]></Description>'; // FIXME: Уточнить откуда брать
            $return .= '<ManagerName>' . $lot->manager_name . '</ManagerName>';
            $return .= '<ContactPhone>' . $this->getPhone($lot) . '</ContactPhone>';
            $return .= '<Address>' . $this->getAddress($lot) . '</Address>';

            if ($latitude && $longitude) {
                $return .= '<Latitude>' . $latitude . '</Latitude>';
                $return .= '<Longitude>' . $longitude . '</Longitude>';
            }

            $return .= '<ContactMethod>По телефону</ContactMethod>';
            $return .= '<InternetCalls>Нет</InternetCalls>';
            $return .= '<CallsDevices></CallsDevices>';
            $return .= '<OperationType>Продам</OperationType>';
            $return .= '<SafeDemonstration>Не хочу</SafeDemonstration>';

            $return .= '<LandAdditionally>';
//            $return .= '<Option>Баня или сауна</Option>';
//            $return .= '<Option>Бассейн</Option>';
            $return .= '</LandAdditionally>'; // FIXME: завести доп параметр в админке

            $return .= '<BathroomMulti>';
            $return .= '<Option>В доме</Option>';
//            $return .= '<Option>На улице</Option>';
            $return .= '</BathroomMulti>'; // FIXME: завести доп параметр в админке

            $return .= '<HouseAdditionally>';
//            $return .= '<Option>Терраса или веранда</Option>';
            $return .= '</HouseAdditionally>';

            $return .= '<Electricity>Есть</Electricity>';
            $return .= '<GasSupply></GasSupply>';
            $return .= '<Heating>' . $lot->heating . '</Heating>';

            if ($lot->heating) {
                $return .= '<HeatingType>' . $this->heating_type . '</HeatingType>';
            }

            $return .= '<WaterSupply>' . $lot->water_supply . '</WaterSupply>';
            $return .= '<Sewerage>' . $lot->sewerage . '</Sewerage>';
            $return .= '<TransportAccessibility></TransportAccessibility>';
            $return .= '<Infrastructure></Infrastructure>';
            $return .= '<ParkingType></ParkingType>';
            $return .= '<Rooms></Rooms>';
            $return .= '<BuiltYear></BuiltYear>';
            $return .= '<LeaseMultimedia></LeaseMultimedia>';
            $return .= '<PropertyRights>Собственник</PropertyRights>';
            $return .= '<ObjectType></ObjectType>';
            $return .= '<Floors></Floors>';
            $return .= '<WallsType></WallsType>';
            $return .= '<Square>' . $lot->sq_house . '</Square>';
            $return .= '<LandArea>' . $lot->square . '</LandArea>';
            $return .= '<LandStatus></LandStatus>';
            $return .= '<SaleOptions></SaleOptions>'; // FIXME
            $return .= '<Renovation></Renovation>';
            $return .= '</Ad>';
        };
        return $return;
    }

    protected function getId($model)
    {
        return StringHelper::basename($model::class) . '_' . $model->id;
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

    protected function getAddress(Lots $model): string
    {
        $base = 'Ленинградская область, Приозерский район, Громовское сельское поселение, посёлок Портовое, ';
        $suffix = $model->address;

        return $base . $suffix;
    }

    protected function getPhone($lot): string
    {
        return $lot->contact_phone;
    }
}