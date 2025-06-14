<?php

namespace babld\avito\models;

use yii\db\ActiveRecord;

/**
 * @property string $description
 * @property string $model_name
 * @property int $item_id
 * @property string $video_url
 * @property boolean $is_active
 * @property string $internal_id
 * @property string $external_id
 * @property string $category
 * @property string $address
 * @property numeric $price
 * @property string $operation_type
 * @property string $property_rights
 * @property int $object_type
 * @property string $walls_type
 * @property string $square
 * @property string $manager_name
 * @property string $phone
 * @property string $land_area
 * @property string $built_year
 * @property string $contact_method
 * @property int $rooms
 * @property int $house_additionally //FIXME: вариант выбора один - переделать на стринг
 * @property int $floors
 * @property int $land_status
 * @property int $renovation
 * @property int $safe_demonstration
 * @property int $transport_accessibility
 * @property int $parking_type
 * @property int $electricity
 * @property int $land_additionally
 */

class Avito extends ActiveRecord
{
    public array $roomValues = [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => '10 и более',
        11 => 'Свободная планировка',
    ];

    public array $propertyRights = [
        1 => 'Собственник',
        2 => 'Посредник',
    ];

    public array $objectType = [
        3 => 'Коттедж',
        1 => 'Дом',
        2 => 'Дача',
        4 => 'Таунхаус'
    ];

    public array $floorValues = [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => '4 и более',
    ];

    const int WALL_TYPE_BRICK = 1;
    const int WALL_TYPE_TIMBER = 2;

    public array $wallsType = [
        self::WALL_TYPE_TIMBER => 'Брус',
        self::WALL_TYPE_BRICK => 'Кирпич',
        3 => 'Бревно',
        4 => 'Газоблоки',
        5 => 'Металл',
        6 => 'Пеноблоки',
        7 => 'Сэндвич-панели',
        8 => 'Ж/б панели',
        9 => 'Экспериментальные материалы',
    ];

    public array $contactMethods = [
        1 => 'По телефону',
        2 => 'В сообщениях',
        3 => 'По телефону и в сообщениях',
    ];

    public array $renovationValues = [
        1 => 'Требуется',
        2 => 'Косметический',
        3 => 'Евро',
        4 => 'Дизайнерский'
    ];

    public array $landStatus = [
        1 => 'Индивидуальное жилищное строительство (ИЖС)',
        2 => 'Садовое некоммерческое товарищество (СНТ)',
        3 => 'Дачное некоммерческое партнёрство (ДНП)',
        4 => 'Фермерское хозяйство',
        5 => 'Личное подсобное хозяйство (ЛПХ)'
    ];

    public array $safeDemonstrations = [
        1 => 'Не хочу',
        2 => 'Могу',
    ];

    public array $landAdditionally = [
        1 => 'Баня или сауна',
        2 => 'Бассейн',
    ];

    const HOUSE_ADDITIONALLY_TERRACE = 1;

    public array $houseAdditionally = [
        self::HOUSE_ADDITIONALLY_TERRACE => 'Терраса или веранда',
    ];

    public array $bathroomMulti = [
        1 => 'В доме',
        2 => 'На улице',
    ];

    public array $houseServices = [
        1 => 'Электричество',
        2 => 'Газ',
        3 => 'Отопление',
        4 => 'Канализация'
    ];

    public array $transportAccessibility = [
        1 => 'Асфальтированная дорога',
        2 => 'Остановка общественного транспорта',
        3 => 'Железнодорожная станция',
    ];

    const int PARKING_TYPE_GARAGE = 1;
    const int PARKING_TYPE_SPACE = 2;
    const int PARKING_TYPE_NO = 3;

    public array $parkingType = [
        self::PARKING_TYPE_SPACE => 'Парковочное место',
        self::PARKING_TYPE_GARAGE => 'Гараж',
        self::PARKING_TYPE_NO => 'Нет',
    ];

    public array $electricityValues = [
        1 => 'Есть',
        2 => 'Нет',
    ];

    public function rules()
    {
        return [
            [['description', 'internal_id', 'category', 'address', 'price', 'operation_type', 'rooms',
                'property_rights', 'object_type', 'floors', 'renovation', 'land_status', 'land_area',
                'walls_type', 'square'], 'required', 'when' => function () {
                    return $this->is_active;
                }, 'whenClient' => "function (attribute, value) {
                        return $('.field-avito-is_active input:checked').length;
                    }"
            ],
            [['is_active'], 'boolean'],
            [['internal_id', 'external_id', 'category', 'address', 'manager_name', 'phone',
                'built_year', 'contact_method'], 'string'],
            [['video_url'], 'url'],
            [['description'], 'string', 'max' => 7500],
            [['price'], 'number'],
            [['rooms', 'property_rights', 'object_type', 'walls_type', 'renovation', 'safe_demonstration',
                'bathroom_multi', 'house_additionally', /*'house_services',*/ 'transport_accessibility', 'parking_type',
                'electricity', 'land_additionally'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'external_id' => 'Avito ID (Номер объявления на Авито)',
            'address' => 'Адрес',
            'description' => 'Описание',
            'price' => 'Цена',
            'rooms' => 'Количество комнат',
            'property_rights' => 'Право собственности',
            'object_type' => 'Вид объекта',
            'floors' => 'Этажей в доме',
            'walls_type' => 'Материал стен',
            'square' => 'Площадь (от 10 до 5000)',
            'land_area' => 'Площадь участка, в сотках — десятичное число (от 1 до 1200)',
            'land_additionally' => 'Дополнительно (на участке)',
            'is_active' => 'Активировать экспорт на авито',
            'land_status' => 'Статус участка',
            'renovation' => 'Ремонт',
            'built_year' => 'Год постройки -  целое число',
            'manager_name' => 'Имя менеджера, контактного лица компании по данному объявлению — строка не более 40 символов',
            'phone' => 'Телефон',
            'contact_method' => 'Способ связи',
            'safe_demonstration' => 'Онлайн показ',
            'bathroom_multi' => 'Санузел',
            'house_additionally' => 'Дополнительно (в доме)',
            'transport_accessibility' => 'Транспортная доступность',
            'parking_type' => 'Тип парковки',
            'electricity' => 'Электричество',
        ];
    }
}