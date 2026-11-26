<?php
declare(strict_types=1);

if (PHP_VERSION_ID < 70400 || !extension_loaded('ffi')) {
    throw new RuntimeException('PDFSolid Conversion SDK requires PHP 7.4 or later with FFI enabled.');
}

spl_autoload_register(static function (string $class): void {
    $prefix = 'PdfSolidConversion\\';
    $legacy = 'Conversion\\';
    if (strncmp($class, $prefix, strlen($prefix)) === 0) {
        $relative = substr($class, strlen($prefix));
    } elseif (strncmp($class, $legacy, strlen($legacy)) === 0) {
        $relative = substr($class, strlen($legacy));
    } else {
        return;
    }

    $file = __DIR__ . '/src/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require_once $file;
        // Keep 1.2 clients and the canonical namespace on the same class identity.
        if (!class_exists($legacy . $relative, false)) {
            class_alias($prefix . $relative, $legacy . $relative);
        }
    }
});

return true;
