<?php

if (PHP_VERSION_ID < 80301) {
    printf("PHP >= 8.3 Required (current %s)", PHP_VERSION);
    exit(1);
}

require __DIR__ . "/../src/boostrap.php";