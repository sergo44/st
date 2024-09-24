<?php

define("ST_START_MICROTIME", microtime(true));

use St\ApplicationError as ApplicationError;
use St\FrontController\Dispatcher as Dispatcher;
use St\HttpError404Exception as HttpError404Exception;

error_reporting(E_ALL);
ini_set("display_errors", "on");

ini_set("log_errors", 'on');
ini_set("error_log", __DIR__ . "/../../var/logs/php-error.log");

const ST_SRC_PATH = __DIR__ . "/";
const ST_PUBLIC_WEB_PATH = ST_SRC_PATH . "/../public/";
const ST_DEFAULT_UMASK = 0002;

define("ST_SERVER_PROTOCOL", $_SERVER['SERVER_PROTOCOL'] ?? "HTTP/1.0");

try {

    $host = $_SERVER['HTTP_HOST'] ?? null;

    if (strpos($host, ":")) {
        $host = explode(":", $host)[0];
    }

    if (!$host || PHP_SAPI === "cli") {
        if (strpos(__FILE__, "html")) {
            $host = "st.test";
        }
    }

    define("ST_HOST", $host);

    if (!isset($host)) {
        throw new Error("Host is not defined", 503);
    }

    require_once __DIR__ . "/../vendor/autoload.php";
    require_once __DIR__  . "/config.secret.php";

    if (file_exists(sprintf("%s/config.global.php", __DIR__))) {
        // Use sprintf to disable code inspection for this include
        require_once sprintf("%s/config.global.php", __DIR__);
    } else {
        require_once __DIR__ . "/config.local.php";
    }


    switch ($host) {
        case "192.168.56.101";
        case "st.test":
            define("ST_DEVELOPMENT_VERSION", true);
            break;

        case "soberitur.ru":
            define("ST_DEVELOPMENT_VERSION", false);
            break;

        default:
            throw new Error(sprintf("Can't load configuration file: unknown host [%s]", $host));
    }

    ini_set("session.save_handler", "redis");
    ini_set("session.save_path", ST_REDIS_SESSION_PATH);
    ini_set("session.gc_maxlifetime", 60*60*24*31);

    session_start();

    if (PHP_SAPI === "cli") {
        $path = $argv[1] ?? "/";
    } else {
        $url = sprintf("https://%s%s", $host, $_SERVER['REQUEST_URI']);
        $path = parse_url($url)['path'] ?? "/";
    }

    if ($path === "/") {
        $path = "/StaticContent/Index";
    }

    $dispatcher = new Dispatcher($path);
    if ($called_controller = $dispatcher->dispatch()) {
        $dispatcher->getCallableControllerEntity()->getLayout()
            ->setContent($dispatcher->getCallableControllerEntity()->getView()->fetch())
            ->out();
    } else {
        throw new HttpError404Exception(sprintf("Can't found route to %s", $route ?? "undefined"));
    }
} catch (HttpError404Exception $e) {
    $layout = new St\Layouts\Error404HtmlLayout();
    $layout->setMessage($e->getMessage());
    $layout->out();
} catch (\St\HttpError403Exception $e) {
    $layout = new St\Layouts\Error403HtmlLayout();
    $layout->out();
} catch (ApplicationError| Error $e) {
    if (!headers_sent()) {
        header(sprintf("%s 500 Internal Server Error", ST_SERVER_PROTOCOL), 500);
    }

    printf("<html lang=\"en\"><head><title>Fatal error occurred</title></head><body><h1>Error occurred (%s)</h1><p>%s</p><p>Trace:<br/>%s</p></body></html>", get_class($e), $e->getMessage(), nl2br($e->getTraceAsString()));
    exit(1);
}
