<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);


if (!empty($arResult['dispatcherList'])) {
    ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        thead th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tbody td {
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <table>
        <thead>
        <tr>
            <th><?= GetMessage('ROMANENKO_DISPATCHER_ID') ?></th>
            <th><?= GetMessage('ROMANENKO_DISPATCHER_FIRST_NAME') ?></th>
            <th><?= GetMessage('ROMANENKO_DISPATCHER_SECOND_NAME') ?></th>
            <th><?= GetMessage('ROMANENKO_DISPATCHER_ACCESS_LEVEL') ?></th>
            <th><?= GetMessage('ROMANENKO_DISPATCHER_COMMENT') ?></th>
            <th><?= GetMessage('ROMANENKO_DISPATCHER_OBJECT_NAME') ?></th>
            <th><?= GetMessage('ROMANENKO_DISPATCHER_LAST_LOGIN') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($arResult['dispatcherList'] as $dispatcher) { ?>
            <tr>
                <td><?= $dispatcher['ID'] ?></td>
                <td><?= $dispatcher['FIRST_NAME'] ?></td>
                <td><?= $dispatcher['SECOND_NAME'] ?></td>
                <td><?= $dispatcher['ACCESS_LEVEL'] ?></td>
                <td><?= $dispatcher['COMMENT'] ?></td>
                <td><?= $dispatcher['OBJECT_NAME'] ?></td>
                <td><?= $dispatcher['LAST_LOGIN'] ? $dispatcher['LAST_LOGIN']->format('d.m.Y H:i:s') : '' ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
} else {
    echo GetMessage('ROMANENKO_DISPATCHER_EMPTY_LIST');
}
?>