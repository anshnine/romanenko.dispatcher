<?

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\ModuleManager as ModuleManager;
use \Bitrix\Main\Application;
use \Bitrix\Main\Config\Configuration as Conf;
use \Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;


Loc::loadMessages(__FILE__);

class romanenko_dispatcher extends CModule
{


    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . "/version.php");
        $this->MODULE_ID = 'romanenko.dispatcher';
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("ROMANENKO_DISPATCHER_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("ROMANENKO_DISPATCHER_MODULE_DESC");

    }

    function DoInstall()
    {


        if ($this->isVersionD7()) {

            ModuleManager::registerModule($this->MODULE_ID);
            $this->InstallDB();
            $this->InstallFiles();
            $configuration = Conf::getInstance();
            $romanenko_dispatcher = $configuration->get('romanenko_dispatcher');
            $romanenko_dispatcher['install'] = $romanenko_dispatcher["install"] + 1;
            $configuration->add('romanenko_dispatcher', $romanenko_dispatcher);
            $configuration->saveConfiguration();

        } else {
            $GLOBALS["APPLICATION"]->ThrowException(Loc::getMessage("ROMANENKO_DISPATCHER_ERROR_VERSION"));
        }
        $GLOBALS["APPLICATION"]->IncludeAdminFile(Loc::getMessage("ROMANENKO_DISPATCHER_INSTALL_TITLE"), $this->GetPath() . "/install/step.php");

       EventManager::getInstance()->addEventHandler("main", "OnAfterUserUpdate", $this->MODULE_ID, "Romanenko\Dispatcher\Event", "eventHandler");
    }

    function DoUninstall()
    {
        $context = Application::GetInstance()->getContext();
        $request = $context->getRequest();
        if ($request["step"] < 2) {
            $GLOBALS["APPLICATION"]->IncludeAdminFile(Loc::getMessage("ROMANENKO_DISPATCHER_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep1.php");
        } elseif ($request["step"] == 2) {
            $this->UnInstallFiles();


            if ($request["savedata"] != "Y") {
                $this->UninstallDB();
            }
            ModuleManager::unRegisterModule($this->MODULE_ID);

            $configuration = Conf::getInstance();
            $romanenko_dispatcher = $configuration->get('romanenko_dispatcher');
            $romanenko_dispatcher['uninstall'] = $romanenko_dispatcher['uninstall'] + 1;
            $configuration->add('romanenko_dispatcher', $romanenko_dispatcher);
            $configuration->saveConfiguration();

            $GLOBALS["APPLICATION"]->IncludeAdminFile(Loc::getMessage("ROMANENKO_DISPATCHER_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep2.php");
        }
    }

    public function InstallFiles()
    {
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"] . "/local/modules/romanenko.dispatcher/install/components",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components", true, true);
        return true;
    }

    public function UnInstallFiles()
    {
        \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER["DOCUMENT_ROOT"] . '/bitrix/components/dispatcher.class');
        return true;
    }

    public function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        // Создаем таблицу диспетчеров
        if (!Application::getConnection(\Romanenko\Dispatcher\DispatcherTable::getConnectionName())->isTableExists(
            Base::getInstance('\Romanenko\Dispatcher\DispatcherTable')->getDBTableName()
        )
        ) {
            Base::getInstance('\Romanenko\Dispatcher\DispatcherTable')->createDbTable();
        }
        // Создаем таблицу объектов
        if (!Application::getConnection(\Romanenko\Dispatcher\ObjectTable::getConnectionName())->isTableExists(
            Base::getInstance('\Romanenko\Dispatcher\ObjectTable')->getDBTableName()
        )
        ) {
            Base::getInstance('\Romanenko\Dispatcher\ObjectTable')->createDbTable();
        }
    }

    public function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        Application::getConnection(\Romanenko\Dispatcher\DispatcherTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('Romanenko\Dispatcher\DispatcherTable')->getDBTableName());

        Application::getConnection(\Romanenko\Dispatcher\ObjectTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('Romanenko\Dispatcher\ObjectTable')->getDBTableName());
        Option::delete($this->MODULE_ID);

    }


    public function GetPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
        } else {
            return dirname(__DIR__);
        }
    }

    public function isVersionD7(): string
    {
        return CheckVersion(ModuleManager::getVersion('main'), '14.00.00');
    }
}




