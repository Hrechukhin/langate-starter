<?php

/**
 * Load files recursively from a directory
 *
 * @param  string $dir Directory to load files from
 * @return void
 */
function load_files($dir)
{
    if (!is_dir($dir)) {
        error_log("Directory does not exist or is not accessible: $dir");
        return;
    }

    $files = glob($dir . '/*.php');

    foreach ($files as $file) {
        if (is_file($file)) {
            require_once($file);
        }
    }

    $directories = glob($dir . '/*', GLOB_ONLYDIR);
    foreach ($directories as $directory) {
        load_files($directory);
    }
}

/**
 * Small autoload function that initiates the file loading process
 *
 * @return void
 */
function autoload_app()
{
    load_files(__DIR__ . '/includes');
}

/**
 * Start autoloading process
 */
autoload_app();