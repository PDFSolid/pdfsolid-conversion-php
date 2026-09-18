# PDFSolid Conversion SDK for PHP 1.2.0

Run PHP through `samples/pdfsolidphp -d ffi.enable=true your_script.php`.
The launcher loads the package libraries before PHP starts and locates them
relative to the package, so it works from any working directory.

## PDF to Word

Save this script in the package root and supply your input and output paths:

```php
<?php
require __DIR__ . '/samples/autoload.php';

use Conversion\Conversion;
use Conversion\ConvertOption;
use Conversion\ErrorCode;
use Conversion\LibraryManager;
use Conversion\PageLayoutMode;

$code = LibraryManager::licenseVerify(__DIR__ . '/samples/license.xml');
if ($code !== ErrorCode::SUCCESS) {
    throw new RuntimeException(ErrorCode::describe($code));
}
LibraryManager::initialize(__DIR__);
try {
    $options = new ConvertOption();
    $options->pageLayoutMode = PageLayoutMode::FLOW;
    Conversion::convert('Word', __DIR__ . '/samples/input_files/word.pdf', '',
        __DIR__ . '/word.docx', $options);
} finally {
    LibraryManager::release();
}
```

`Conversion::pdfToWord()` and the other `pdfTo*()` methods return error codes;
`Conversion::convert()` throws an exception on failure. All support an optional
`ConvertCallback` as their last argument. `0` means success, `1` cancellation.

Supported target methods: `pdfToWord`, `pdfToExcel`, `pdfToPpt`, `pdfToHtml`,
`pdfToRtf`, `pdfToImage`, `pdfToTxt`, `pdfToJson`, `pdfToMarkdown`,
`pdfToSearchablePdf`, `pdfToOfd`. For CSV use `pdfToExcel` with
`$options->excelCsvFormat = true`.

## DocumentAI and OCR

After initialization, load the supplied model explicitly:

```php
$code = LibraryManager::setDocumentAIModel(
    __DIR__ . '/resource/models/documentai.model', -1);
if ($code !== ErrorCode::SUCCESS) {
    throw new RuntimeException(ErrorCode::describe($code));
}
$options->enableAiLayout = true;
$options->enableAiTableRecognition = true;
// For OCR:
$options->enableOcr = true;
$options->languages = [\Conversion\OcrLanguage::ENGLISH];
```

`-1` selects CPU inference. Before releasing the SDK, call
`LibraryManager::releaseDocumentAIModel()`.

The native options also expose `enableDocumentOrientationClassification` and
`enableDocumentDewarp`, both false by default. They apply to OCR image
recognition and require the corresponding DocumentAI model capabilities.

## Progress and cancellation

```php
$callback = new \Conversion\ConvertCallback();
$callback->onProgress = static function (int $current, int $total): void {
    echo "$current/$total\n";
};
$callback->onCancel = static function (): bool { return false; };
$code = \Conversion\Conversion::pdfToWord($input, '', $output, $options, $callback);
```

Callbacks run synchronously on the calling thread. Return true from `onCancel`
to request cancellation. See `samples/callback_demo.php` for a complete example.

## Native compatibility

PHP uses `libcompdf_php_shim.so` to convert its option pointer into the SDK's
by-value `CConvertOption`. The bridge exports separate
`pdfsolid_php_convert_*` symbols; lifecycle and DocumentAI calls resolve to
the SDK dependency. Keep the PHP source, bridge and SDK from the same package.

On Linux x86_64 the current option structure is 576 bytes (previously 568).
The two new booleans are at offsets 568 and 569. The callback structure remains
72 bytes. This package includes the matching C headers under `native/include`.

This package uses the `Conversion\` PHP namespace. Replace older
`ComPDFKit\Conversion\` imports when migrating existing scripts.
