<?php
$ds = DIRECTORY_SEPARATOR;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . "/../vendor/composer/ClassLoader.php";

$appPath = realpath(__DIR__ . $ds . ".." . $ds . "src");

function registerNamespace($namespace, $path) {
    $classLoader = new \Composer\Autoload\ClassLoader();
    $classLoader->add($namespace, $path);
    $classLoader->register(true);
}

registerNamespace('Controllers', $appPath);
registerNamespace('Services', $appPath);