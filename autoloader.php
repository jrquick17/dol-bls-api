<?php
spl_autoload_register(
    function($class) {
        $prefix = 'Encounting\\DolBls\\';

        $len = strlen($prefix);
        if (strncmp( $prefix, $class, $len ) !== 0) {
            return;
        }

        $base_dir = __DIR__ . '/src/';

        $relative_class = substr($class, $len);

        $file = $base_dir.str_replace('\\', '/', $relative_class).'.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
);