<?php

namespace Romanenko\Dispatcher;

use \Bitrix\Main\Type;
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\TextField;
use Bitrix\Main\Entity\DatetimeField;

class ObjectTable extends DataManager
{
    public static function getTableName()
    {
        return 'romanenko_object';
    }

    public static function getUfId()
    {
        return 'DISPATCHER_OBJECT';

    }

    public static function getConnectionName()
    {
        return 'default';

    }

    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new DatetimeField('CREATED_AT'),
            new TextField('NAME'),
            new TextField('ADRES'),
            new TextField('COMMENT')
        );
    }
}