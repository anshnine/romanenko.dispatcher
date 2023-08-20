<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Type;
use \Romanenko\Dispatcher\DispatcherTable;
use \Romanenko\Dispatcher\ObjectTable;
use Bitrix\Main\Entity;

class DispatcherClass extends CBitrixComponent
{
    protected function ckeckModules()
    {
        if (!Loader::includeModule('romanenko.dispatcher')) {
            ShowError(Loc::getMessage('ROMANENKO_DISPATCHER_MODULE_NOT_INSTALLED'));
            return false;
        }

        return true;
    }

    function addDispatcher()
    {
        $result = DispatcherTable::add(array(
            'ACTIVE' => true,
            'CREATED_AT' => new Type\DateTime('04.09.2023 00:00:00'),
            'ENDED_AT' => new Type\DateTime('04.09.2025'),
            'USER_ID' => 1,
            'OBJECT_ID' => 1,
            'ACCESS_LEVEL' => 5,
            'COMMENT' => 'Тестовое значение'

        ));

        return $result;
    }

    function addObject()
    {
        $result = ObjectTable::add(array(
            'CREATED_AT' => new Type\DateTime('04.09.2023 00:00:00'),
            'NAME' => 'Тестовое имя',
            'ADRESS' => 'Тестовый адрес',
            'COMMENT' => 'тестовый комент'

        ));
        return $result;
    }


    public function executeComponent()
    {
        $this->includeComponentLang('class.php');
        if ($this->ckeckModules()) {
            if ($this->startResultCache()) {
                $dispatcherList = DispatcherTable::getList([
                    'filter' => ['ACTIVE' => true],
                    'select' => ['ID', 'FIRST_NAME', 'SECOND_NAME', 'ACCESS_LEVEL', 'COMMENT', 'OBJECT_NAME' => 'OBJECT.NAME','LAST_LOGIN'=>'USER.LAST_LOGIN'],
                    'cache' => ['ttl' => 3600]
                ])->fetchAll();

                $this->arResult['dispatcherList'] = $dispatcherList;

                $this->arResult['dispatcherList'] = $dispatcherList;
                $this->includeComponentTemplate();

                $this->endResultCache();
            }
        }
    }
}



