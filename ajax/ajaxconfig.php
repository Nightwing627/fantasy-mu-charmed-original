<?php


@ini_set("default_charset", "utf-8");
$filepath = str_replace("\\", "/", dirname(__FILE__));
$rootpath = dirname(dirname(dirname($filepath)));
define("__ROOT_DIR__", $rootpath . "/");
define("__PATH_INCLUDES__", __ROOT_DIR__ . "includes/");
define("__PATH_CLASSES__", __PATH_INCLUDES__ . "classes/");
define("__PATH_LANGUAGES__", __ROOT_DIR__ . "languages/");
if (!(include_once __PATH_INCLUDES__ . "config.php")) {
    throw new Exception("Could not load the configurations file.");
}
if (!(include_once __PATH_CLASSES__ . "class.validator.php")) {
    throw new Exception("Could not load class (validator).");
}
if (!(include_once __PATH_INCLUDES__ . "functions/function.config.php")) {
    throw new Exception("Could not load the configurations function file.");
}
if (!(include_once __PATH_INCLUDES__ . "functions/function.global.php")) {
    throw new Exception("Could not load the global function file.");
}
if (!(include_once __PATH_CLASSES__ . "class.database.php")) {
    throw new Exception("Could not load class (database).");
}
define("__PATH_TEMPLATE_ROOT__", __ROOT_DIR__ . "templates/" . $config["website_template"] . "/");
if (!(include_once __PATH_TEMPLATE_ROOT__ . "inc/template.functions.php")) {
    throw new Exception("Could not load template functions");
}
$dB = new dB($config["SQL_DB_HOST"], $config["SQL_DB_PORT"], $config["SQL_DB_NAME"], $config["SQL_DB_USER"], $config["SQL_DB_PASS"], $config["SQL_PDO_DRIVER"]);
if ($dB->dead) {
    if (config("error_reporting", true)) {
        throw new Exception($dB->error);
    }
    throw new Exception("Connection to database server failed. [01]");
}
if ($config["SQL_USE_2_DB"]) {
    $dB2 = new dB($config["SQL_DB_HOST"], $config["SQL_DB_PORT"], $config["SQL_DB_2_NAME"], $config["SQL_DB_USER"], $config["SQL_DB_PASS"], $config["SQL_PDO_DRIVER"]);
    if ($dB2->dead) {
        if (config("error_reporting", true)) {
            throw new Exception($dB2->error);
        }
        throw new Exception("Connection to database server failed. [02]");
    }
}
$loadLanguage = check_value($_SESSION["language_display"]) ? $_SESSION["language_display"] : $config["language_default"];
$loadLanguage = config("language_switch_active", true) ? $loadLanguage : $config["language_default"];
if (!file_exists(__PATH_LANGUAGES__ . $loadLanguage . "/language.php")) {
    throw new Exception("The chosen language cannot be loaded (" . $loadLanguage . ").");
}
include __PATH_LANGUAGES__ . $loadLanguage . "/language.php";

?>