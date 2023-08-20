<?php

use \Bitrix\Main\Localization\Loc as Loc;
use \Bitrix\Main\Config\Configuration as Conf;

if (!check_bitrix_sessid()) {
    return;
}
$install_count = Conf::getInstance()->get('romanenko_dispatcher');
if ($ex = $GLOBALS["APPLICATION"]->GetException())
    echo CAdminMessage::ShowMessage(array(
        "TYPE" => "ERROR",
        "MESSAGE" => Loc::getMessage("MOD_UNINST_ERR"),
        "DETAILS" => $ex->GetString(),
        "HTML" => true,
    ));
else
    echo CAdminMessage::ShowNote(Loc::getMessage("MOD_UNINST_OK"));
echo CAdminMessage::ShowMessage(array("MESSAGE"=>Loc::getMessage("ROMANENKO_DISPATCHER_UNINSTALL_COUNT").$install_count["uninstall"],"TYPE"=>"OK"))
?>
<form action="<? echo $GLOBALS["APPLICATION"]->GetCurPage(); ?>">
    <input type="hidden" name="lang" value="<? echo LANGUAGE_ID ?>">
    <input type="submit" name="lang" value="<? echo Loc::getMessage("MOD_BACK"); ?>">
</form>
