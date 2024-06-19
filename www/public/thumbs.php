<?php
error_reporting(E_ALL);
ini_set("display_errors", "on");

// Устанавливаем значения переменных
$basedir = $_REQUEST['basedir'] ?? null;
$width = isset($_REQUEST['width']) ? abs($_REQUEST['width']) : null;
$height = isset($_REQUEST['height']) ? abs($_REQUEST['height']) : null;
$image = isset($_REQUEST['image']) ? basename($_REQUEST['image']) : null;
$crop = isset($_GET['crop']) ? boolval($_GET['crop']) : null;
$x1 = isset($_GET['x1']) && preg_match("/^[0-9]+(\\.[0-9]+)?+$/", $_GET['x1']) ? $_GET['x1'] : null;
$y1 = isset($_GET['y1']) && preg_match("/^[0-9]+(\\.[0-9]+)?$/", $_GET['y1']) ? $_GET['y1'] : null;
$x2 = isset($_GET['x2']) && preg_match("/^[0-9]+(\\.[0-9]+)?$/", $_GET['x2']) ? $_GET['x2'] : null;
$y2 = isset($_GET['y2']) && preg_match("/^[0-9]+(\\.[0-9]+)?$/", $_GET['y2']) ? $_GET['y2'] : null;

$src_path = $basedir . $image;
$dst_dir = $basedir . $width . "x" . $height . "/";
$dst_path = $dst_dir . $image;

if (
    !$basedir || (!$width && !$height) || !$image
    || !preg_match("/^upload\\/[a-z0-9_\\/]+$/i", $basedir)
    || !preg_match("/^[a-z0-9\\-\\/]+\\.(?:jpe?g|png|gif)$/i", $image)
    || !file_exists($basedir)
    || !file_exists($src_path)
    || !file_exists($dst_dir)
    || !is_dir($dst_dir)
) {

    header("HTTP/1.1 404 Not found", true, 404);
    echo "<html lang='en'><head><title></title></head><body><h1>Image not found</h1>";
    echo "<p>Click here: <a href=\"/\">/</a></p></body></html>";
    exit();
}

if (
    !is_readable($src_path)
    || !is_writable($dst_dir)
) {

    header("HTTP/1.1 403 Forbidden", true, 403);
    echo "<html lang='en'><head><title></title></head><body><h1>Permission denied</h1>";
    echo "<p>Click here: <a href=\"/\">/</a></p></body></html>";
    exit();
}

if (file_exists($dst_path)) {
    if (is_readable($dst_path) && is_file($dst_path)) {
        if (!headers_sent()) {
            header("Content-type: " . mime_content_type($dst_path));
        }

        exit(readfile($dst_path));
    } else {
        unlink($dst_path); // file is unreadable, but dir is writable. Recreates
    }
}

try {
    require_once '../src/St/Images/ImageCropper.php';
    require_once '../src/St/Images/ImageException.php';

    $image_resizer = new \St\Images\ImageCropper();

    $image_resizer
        ->setSrcFilePath($src_path)
        ->setDstFilePath($dst_path)
        ->setResizeGeometry($width, $height)
        ;

    if (isset($x1) && isset($y1) && isset($x2) && isset($y2)) {
        $image_resizer->setSelectedArea(abs($x1), abs($y1), abs($x2), abs($y2));
    }

    $image_resizer->setCrop($crop)
        ->setAutofixFileExt(false)
        ->setUnknownExtOutputFormat("")
        ->open()
        ->resize()
        ->save();
   exit();
    if (file_exists($dst_path) && is_readable($dst_path)) {
        if (!headers_sent()) {
            header("Content-type: " . mime_content_type($dst_path));
        }

        exit(readfile($dst_path));
    } else {
        throw new Exception("Can't resize image. File not saved");
    }

} catch (Exception $e) {
    header("HTTP/1.1 500 Internal server error", true, 500);
    echo "<html lang='en'><head><title></title></head><body><h1>Resize image failed</h1>";
    echo "<p>{$e->getMessage()}</p>";
    echo "<p>Click here: <a href=\"/\">/</a></p></body></html>";
    exit();
}