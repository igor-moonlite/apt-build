<?php

define('CRLF', "\r\n");
$param=($argc > 1) ? $argv[1] : "";
include_once '/usr/share/moonlite/system/autoload.php';
\Aurora\System\Api::Init(true);

if ($param=="install") {
    $result = false;
    if (count($argv) >= 5) {
        $oSettings = \Aurora\System\Api::GetSettings();
        if ($oSettings) {
            $oSettings->SetConf('DBHost', 'localhost');
            $oSettings->SetConf('DBName', $argv[2]);
            $oSettings->SetConf('DBLogin', $argv[3]);
            $oSettings->SetConf('DBPassword', $argv[4]);
            $oSettings->SetConf('XFrameOptions', '');
            $result = $oSettings->Save();

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Core", "SiteName", "MoonLite");
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Core", "ProductName", "MoonLite");
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Core", "EnableFailedLoginBlock", false);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Core", "AllowPostLogin", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Core", "AllowGroups", false);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("Core");

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("SecuritySettingsWebclient", "Disabled", false);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("SecuritySettingsWebclient");

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("TwoFactorAuth", "Disabled", false);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("TwoFactorAuth");

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "XMailerValue", "MoonLite");
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "AllowIdentities", false);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "AllowTemplateFolders", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "AllowTemplateFolders", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "AllowInsertTemplateOnCompose", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "DisplayInlineCss", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "IgnoreImapSubscription", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "ExternalHostNameOfLocalImap", "mail.jino.ru");
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Mail", "ExternalHostNameOfLocalSmtp", "mail.jino.ru");
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("Mail");

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("Contacts", "AllowAddressBooksManagement", true);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("Contacts");

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("CoreWebclient", "HeaderModulesOrder", ["mail", "contacts"]);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("CoreWebclient", "LanguageNames", ["English"=>"English", "Russian"=>"Russian"]);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("CoreWebclient", "Theme", "MoonLite");
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("CoreWebclient", "ThemeList", ["MoonLite","Default","DefaultDark","DeepForest","Outlook","Funny","Sand"]);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("CoreWebclient", "AllowDesktopNotifications", true);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("CoreWebclient");

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "FoldersExpandedByDefault", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "ComposeToolbarOrder", ["back","send","save","confirmation"]);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "AllowHorizontalLineButton", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "AllowComposePlainText", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "AllowEditHtmlSource", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "AllowHorizontalLayout", true);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "AllowQuickReply", false);
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailWebclient", "AllowUserGroupsInComposeAutocomplete", false);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("MailWebclient");

            $poweredby = 'Powered by <a href="https://github.com/igor-moonlite/moonlite/" target="_blank">MoonLite</a> &copy; 2023';
            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("StandardLoginFormWebclient", "BottomInfoHtmlText", $poweredby);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("StandardLoginFormWebclient");

            \Aurora\System\Api::GetModuleManager()->setModuleConfigValue("MailLoginFormWebclient", "BottomInfoHtmlText", $poweredby);
            \Aurora\System\Api::GetModuleManager()->saveModuleConfigValue("MailLoginFormWebclient");

            \Aurora\System\Api::GetModuleDecorator('Core')->CreateTables();
            $bMailServerCreate = \Aurora\System\Api::GetModuleDecorator('Mail')->CreateServer(
                "localhost",
                "127.0.0.1",
                143,
                false,
                "127.0.0.1",
                25,
                false,
                \Aurora\Modules\Mail\Enums\SmtpAuthType::UseUserCredentials,
                "*",
		true,
		true
            );
        }
    }
    if ($result) {
        echo 'Installation is completed successfully.'.CRLF;
    } else {
        echo 'The package is installed, but setting up the database has failed.'.CRLF;
    }
    echo
    'Log into MoonLite admin interface at:'.CRLF.
    'http://localhost/moonlite/adminpanel/'.CRLF.
    'using login superadmin with empty password to configure the package.'.CRLF.
    'Users will be able to log into MoonLite at:'.CRLF.
    'http://localhost/moonlite/'.CRLF
    ;
} elseif ($param=="upgrade") {
    \Aurora\System\Api::GetModuleDecorator('Core')->CreateTables();
    \Aurora\System\Api::GetModuleManager()->SyncModulesConfigs();
} else {
    \Aurora\System\Api::GetModuleManager()->SyncModulesConfigs();
}
