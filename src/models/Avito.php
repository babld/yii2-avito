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
 * @property int $floors
 * @property int $land_status
 * @property int $renovation
 * @property int $safe_demonstration
 * @property int $transport_accessibility
 * @property int $parking_type
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
        1 => 'Дом',
        2 => 'Дача',
        3 => 'Коттедж',
        4 => 'Таунхаус'
    ];

    public array $floorValues = [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => '4 и более',
    ];

    public array $wallsType = [
        1 => 'Кирпич',
        2 => 'Брус',
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

    public array $houseAdditionally = [
        1 => 'Терраса или веранда',
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

    public array $parkingType = [
        1 => 'Гараж',
        2 => 'Парковочное место',
        3 => 'Нет',
    ];

    public function rules()
    {
        return [
            [['description', 'internal_id', 'category', 'address', 'price', 'operation_type', 'rooms',
                'property_rights', 'object_type', 'floors', 'renovation', 'land_status', 'land_area',
                'walls_type', 'square'], 'required'],
            [['is_active'], 'boolean'],
            [['description', 'internal_id', 'video_url', 'external_id', 'category', 'address', 'manager_name', 'phone',
                'built_year'], 'string'],
            [['price'], 'number'],
            [['rooms', 'property_rights', 'object_type', 'walls_type', 'renovation', 'safe_demonstration',
                'bathroom_multi', 'house_additionally', /*'house_services',*/ 'transport_accessibility', 'parking_type'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'external_id' => 'Avito ID',
            'address' => 'Адрес',
            'description' => 'Описание',
            'price' => 'Цена',
            'rooms' => 'Количество комнат',
            'property_rights' => 'Право собственности',
            'object_type' => 'Вид объекта',
            'floors' => 'Этажей в доме',
            'walls_type' => 'Материал стен',
            'square' => 'Площадь',
            'land_area' => 'Площадь участка, в сотках — десятичное число',
        ];
    }
}