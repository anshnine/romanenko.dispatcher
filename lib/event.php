<?php


namespace Romanenko\Dispatcher;


class Event
{
    public function eventHandler(Bitrix\Main\Event $event)
    {
        $userId = $event->getParameter('id');
        $isActive = $event->getParameter('fields')['ACTIVE'];

        if (!$isActive) {
            // Получаем запись диспетчера по USER_ID и деактивируем ее
            $dispatcher = DispatcherTable::getList([
                'filter' => ['USER_ID' => $userId]
            ])->fetch();

            if ($dispatcher) {
                DispatcherTable::update($dispatcher['ID'], ['ACTIVE' => false]);
            }
        }
    }
}