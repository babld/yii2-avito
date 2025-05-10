<?php

namespace babld\avito\helpers;

use babld\avito\models\Avito;
use yii\helpers\ArrayHelper;

class Repository
{
    protected Avito $model;

    public const string FIELD_IS_ACTIVE = 'Active';
    public const string FIELD_VIDEO = 'VideoURL';
    public const string FIELD_ID = 'Id';
    public const string FIELD_PRICE = 'Price';
    public const string FIELD_DESCRIPTION = 'Description';
    public const string FIELD_MANAGER_NAME = 'ManagerName';
    public const string FIELD_CONTACT_PHONE = 'ContactPhone';
    public const string FIELD_ADDRESS = 'Address';
    public const string FIELD_LATITUDE = 'Latitude';
    public const string FIELD_LONGITUDE = 'Longitude';
    public const string FIELD_CONTACT_METHOD = 'ContactMethod';
    public const string FIELD_INTERNET_CALLS = 'InternetCalls';
    public const string FIELD_SAFE_DEMONSTRATION = 'SafeDemonstration';
    public const string FIELD_LAND_ADDITIONALLY = 'LandAdditionally';
    public const string FIELD_BATHROOM_MULTI = 'BathroomMulti';
    public const string FIELD_HOUSE_ADDITIONALLY = 'HouseAdditionally';
    public const string FIELD_ELECTRICITY = 'Electricity';
    public const string FIELD_GAS_SUPPLY = 'GasSupply';
    public const string FIELD_HEATING = 'Heating';
    public const string FIELD_HEATING_TYPE = 'HeatingType';
    public const string FIELD_WATER_SUPPLY = 'WaterSupply';
    public const string FIELD_SEWERAGE = 'Sewerage';
    public const string FIELD_TRANSPORT_ACCESSIBILITY = 'TransportAccessibility';
    public const string FIELD_INFRASTRUCTURE = 'Infrastructure';
    public const string FIELD_PARKING_TYPE = 'ParkingType';
    public const string FIELD_AVITO_ID = 'AvitoId';
    public const string FIELD_HOUSE_SERVICES = 'HouseServices';
    public const string FIELD_ROOMS = 'Rooms';
    public const string FIELD_BUILT_YEAR = 'BuiltYear';
    public const string FIELD_LEASE_MULTIMEDIA = 'LeaseMultimedia';
    public const string FIELD_PROPERTY_RIGHTS = 'PropertyRights';
    public const string FIELD_OBJECT_TYPE = 'ObjectType';
    public const string FIELD_FLOORS = 'Floors';
    public const string FIELD_WALLS_TYPE = 'WallsType';
    public const string FIELD_SQUARE = 'Square';
    public const string FIELD_LAND_AREA = 'LandArea';
    public const string FIELD_LAND_STATUS = 'LandStatus';
    public const string FIELD_SALE_OPTIONS = 'SaleOptions';
    public const string FIELD_RENOVATION = 'Renovation';

    public const string FIELD_STATIC_CATEGORY = 'Category';
    public const string FIELD_STATIC_OPERATION_TYPE = 'OperationType';

    public const int INPUT_TYPE_TEXT = 1;
    public const int INPUT_TYPE_SELECT = 2;
    public const int INPUT_TYPE_MULTI_SELECT = 3;
    public const int INPUT_TYPE_CHECKBOX_LIST = 4;
    public const int INPUT_TYPE_TEXTAREA = 5;
    public const int INPUT_TYPE_CHECKBOX = 6;

    public array $houseSales = [
        self::FIELD_IS_ACTIVE => [
            'type' => self::INPUT_TYPE_CHECKBOX,
        ],
        self::FIELD_ID => [
            'type' => self::INPUT_TYPE_TEXT,
            'disabled' => true,
            'value' => 'calculated',
            'function' => 'getId',
            'required' => true,
        ],
        self::FIELD_DESCRIPTION => [
            'type' => self::INPUT_TYPE_TEXTAREA,
            'required' => true,
        ],
        self::FIELD_ADDRESS => [
            'required' => true,
            'type' => self::INPUT_TYPE_TEXT,
        ],
        self::FIELD_VIDEO => 'https://rutube.ru/video/cbe29e13e0f638a5b9faece3b75b12d8/',
        self::FIELD_PRICE => null,
        self::FIELD_OBJECT_TYPE => [
            'values' => ['Дом', 'Дача', 'Коттедж', 'Таунхаус'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => [],
        ],
        self::FIELD_FLOORS => [
            'values' => [1, 2, 3, '4 и более'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => [],
        ],
        self::FIELD_RENOVATION => [
            'values' => ['Требуется', 'Косметический', 'Евро', 'Дизайнерский'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => [],
            'required' => true,
        ],
        self::FIELD_WALLS_TYPE => [
            'values' => ['Кирпич', 'Брус', 'Бревно', 'Газоблоки', 'Металл', 'Пеноблоки', 'Сэндвич-панели', 'Ж/б панели', 'Экспериментальные материалы'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => [],
        ],
        self::FIELD_SALE_OPTIONS => [
            'values' => ['Можно в ипотеку', 'Продажа доли', 'Аукцион'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => [],
        ],
        self::FIELD_LAND_STATUS => [
            'values' => ['Индивидуальное жилищное строительство (ИЖС)', 'Садовое некоммерческое товарищество (СНТ)', 'Дачное некоммерческое партнёрство (ДНП)', 'Фермерское хозяйство' ,'Личное подсобное хозяйство (ЛПХ)'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => [],
        ],
        self::FIELD_SQUARE => null,
        self::FIELD_LAND_AREA => null,
        self::FIELD_MANAGER_NAME => null,
        self::FIELD_CONTACT_PHONE => null,
        self::FIELD_LATITUDE => null,
        self::FIELD_LONGITUDE => null,
        self::FIELD_CONTACT_METHOD => [
            'values' => ['По телефону и в сообщениях', 'По телефону', 'В сообщениях',],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_INTERNET_CALLS => [
            'values' => [
                1 => 'Да',
                2 => 'Нет'
            ],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_SAFE_DEMONSTRATION => [
            'values' => ['Могу провести', 'Не хочу'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_LAND_ADDITIONALLY => [
            'values' => ['Баня или сауна', 'Бассейн'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => [],
        ],
        self::FIELD_HOUSE_SERVICES => [
            'values' => ['Электричество', 'Газ', 'Отопление', 'Канализация'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => [],
        ],
        // multi select
        self::FIELD_BATHROOM_MULTI => [
            'values' => ['В доме', 'На улице'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => [],
        ],
        // multi select
        self::FIELD_HOUSE_ADDITIONALLY => [
            'values' => ['Терраса или веранда'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => [],
        ],
        // select
        self::FIELD_ELECTRICITY => [
            'values' => ['Есть', 'Нет'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        // select
        self::FIELD_GAS_SUPPLY => [
            'values' => ['Нет', 'По границе участка', 'В доме'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        // select
        self::FIELD_ROOMS => [
            'values' => [1, 2, 3, 4, 5, 6, 7, 8, 9, '10 и более', 'Свободная планировка'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        // select
        self::FIELD_HEATING => [
            'values' => ['Нет', 'Есть'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_HEATING_TYPE => [
            'values' => ['Центральное', 'Газовое', 'Электрическое', 'Жидкотопливный котёл', 'Печь', 'Камин', 'Другое'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => []
        ],
        self::FIELD_WATER_SUPPLY => [
            'values' => ['Нет', 'Центральное', 'Скважина', 'Колодец'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_SEWERAGE => [
            'values' => ['Центральная', 'Септик', 'Выгребная яма', 'Станция биоочистки', 'Нет'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_TRANSPORT_ACCESSIBILITY => [
            'values' => ['Асфальтированная дорога', 'Остановка общественного транспорта', 'Железнодорожная станция'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => []
        ],
        self::FIELD_INFRASTRUCTURE => [
            'values' => ['Магазин', 'Аптека', 'Детский сад', 'Школа'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => []
        ],
        self::FIELD_PARKING_TYPE => [
            'values' => ['Нет', 'Гараж', 'Парковочное место'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_PROPERTY_RIGHTS => [
            'values' => ['Собственник', 'Посредник'],
            'type' => self::INPUT_TYPE_SELECT,
            'selected' => ''
        ],
        self::FIELD_AVITO_ID => null,
        self::FIELD_BUILT_YEAR => null,
        self::FIELD_LEASE_MULTIMEDIA => [
            'values' => ['Wi-Fi', 'Телевидение'],
            'type' => self::INPUT_TYPE_CHECKBOX_LIST,
            'selected' => []
        ],
    ];

    public array $houseSalesStatic = [
        self::FIELD_STATIC_CATEGORY => 'Дома, дачи, коттеджи',
        self::FIELD_STATIC_OPERATION_TYPE => 'Продам',
    ];

    public function getHouseSales($itemId, $modelName): array
    {
        $items = Avito::find()->where(['item_id' => $itemId, 'model_name' => $modelName]);
        $result = $this->houseSales;

        foreach ($items->each() as $avito) {
            /** @var Avito $avito */

            $this->model = $avito;

            $baseValue = ArrayHelper::getValue($this->houseSales, $avito->field_name);

            if (!$baseValue) {
                continue;
            }

            if (
                is_array($baseValue)
                && (
                    $baseValue['type'] === self::INPUT_TYPE_MULTI_SELECT ||
                    $baseValue['type'] === self::INPUT_TYPE_CHECKBOX_LIST
                )
            ) {
                $result[$avito->field_name]['selected'][] = $avito->value;
                continue;
            }

            if (is_array($baseValue) && $baseValue['type'] === self::INPUT_TYPE_SELECT) {
                $result[$avito->field_name]['selected'] = $avito->value;
                continue;
            }

            if (
                is_array($baseValue)
                && $baseValue['type'] === self::INPUT_TYPE_TEXT
                && ArrayHelper::getValue($baseValue, 'value') === 'calculated'
                && ArrayHelper::getValue($baseValue, 'function')
            ) {
                $result[$avito->field_name] = [
                    'value' => $this->{$baseValue['function']}(),
                    'disabled' => ArrayHelper::getValue($baseValue, 'disabled')
                ];
                continue;
            }

            $result[$avito->field_name] = $avito->value;

//            if ($avito->field_name == self::FIELD_VIDEO) {
//                var_dump($result);exit;
//
//            }
        }

        return $result;
    }

    protected function getId(): string
    {
        return $this->model->model_name . '_' . $this->model->item_id;
    }
}