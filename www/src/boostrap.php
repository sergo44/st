<?php

use St\ApplicationError as ApplicationError;
use St\FrontController\Dispatcher as Dispatcher;
use St\HttpError404Exception as HttpError404Exception;

error_reporting(E_ALL);
ini_set("display_errors", "on");


const ST_SRC_PATH = __DIR__ . "/";
const ST_PUBLIC_WEB_PATH = ST_SRC_PATH . "/../public/";

define("ST_SERVER_PROTOCOL", $_SERVER['SERVER_PROTOCOL'] ?? "HTTP/1.0");

try {

    $host = $_SERVER['HTTP_HOST'] ?? null;

    if (!$host || PHP_SAPI === "cli") {
        if (strpos(__FILE__, "st.test")) {
            $host = "st.test";
        }
    }

    define("ST_HOST", $host);

    if (!isset($host)) {
        throw new Error("Host is not defined", 503);
    }

    require __DIR__ . "/../vendor/autoload.php";

    switch ($host) {
        case "st.test":
            require_once "config.local.php";
            break;

        default:
            throw new Error("Can't load configuration file: unknown host");
    }

    ini_set("session.save_handler", "redis");
    ini_set("session.save_path", ST_REDIS_SESSION_PATH);

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
