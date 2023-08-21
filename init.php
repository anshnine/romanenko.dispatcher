<?php

use Bitrix\Main\EventManager;

// Регистрируем обработчик события на изменение пользователя
$eventManager = EventManager::getInstance();
$eventManager->addEventHandler('main', 'OnAfterUserUpdate', 'onUserUpdate');

function debug($object)
{
    ob_start();
    print_r($object);
    $contents = ob_get_contents();
    ob_end_clean();
    error_log($contents, 3, $_SERVER["DOCUMENT_ROOT"] . "/debug.log");
}

function onUserUpdate($fields)
{

    $user_id = $fields["ID"];
    $is_active = $fields["ACTIVE"];
    if ($is_active !== "Y") {
        $dispatcher = \Romanenko\Dispatcher\DispatcherTable::getList([
            'filter' => ['USER_ID' => $user_id]
        ])->fetch();

        if ($dispatcher) {
            \Romanenko\Dispatcher\DispatcherTable::update($dispatcher['ID'], ['ACTIVE' => false]);
        }
    } else {
        $dispatcher = \Romanenko\Dispatcher\DispatcherTable::getList([
            'filter' => ['USER_ID' => $user_id]
        ])->fetch();

        if ($dispatcher) {
            \Romanenko\Dispatcher\DispatcherTable::update($dispatcher['ID'], ['ACTIVE' => true]);
        }

    }
}

