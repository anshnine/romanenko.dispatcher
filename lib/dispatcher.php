<?php

namespace Romanenko\Dispatcher;

use \Bitrix\Main\Type;
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\TextField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\DateField;
use Bitrix\Main\Entity\BooleanField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Entity\ReferenceField;

class DispatcherTable extends DataManager
{
    public static function getTableName()
    {
        return 'romanenko_dispatcher';
    }

    public static function getUfId()
    {
        return 'DISPATCHER_DISPATCHER';

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
            new StringField('FIRST_NAME'),
            new StringField('SECOND_NAME'),
            new BooleanField('ACTIVE'),
            new DatetimeField('CREATED_AT'),
            new DateField('ENDED_AT'),
            new IntegerField('OBJECT_ID', array(
                'validation' => function () {
                    return array(
                        new Validator\Unique()
                    );
                }
            )),
            new IntegerField('USER_ID', array(
                'validation' => function () {
                    return array(
                        new Validator\Unique()
                    );
                }
            )),
            new ReferenceField(
                'USER',
                'Bitrix\Main\UserTable',
                array('=this.USER_ID' => 'ref.ID')
            ),
            new ReferenceField(
                'OBJECT',
                '\Romanenko\Dispatcher\ObjectTable',
                array('=this.OBJECT_ID' => 'ref.ID')),
            new IntegerField('ACCESS_LEVEL', array(
                'validation' => function () {
                    return array(
                        new Validator\Range(1, 12)
                    );
                }
            )),
            new TextField('COMMENT'),
        );
    }

}