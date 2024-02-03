<?php

function include_files_from_folder($folder)
{
    $paths = glob($folder . '*');

    if ($paths === false) {
        error_log("Failed to retrieve files from folder: $folder");
        return;
    }

    foreach ($paths as $path) {
        if (is_file($path) && is_readable($path)) {
            include_once $path;
        } else {
            error_log("Unable to include file: $path");
        }
    }
}

$folders = [
    'includes/',
    'includes/widgets/',
    'includes/shortcodes/',
    'includes/microdata/',
    'includes/post-types/',
    'includes/taxonomies/',
	'includes/custom-fields/',
];

foreach ($folders as $folder) {
    include_files_from_folder(__DIR__ . '/' . $folder);
}

