# PDFSolid Conversion SDK for PHP 1.3.0 Upgrade Warnings

Applications using the 1.2 namespace can keep `use Conversion\LibraryManager;` and their other `Conversion\` imports. Load the bundled `samples/autoload.php`; both `Conversion\LibraryManager` and `PdfSolidConversion\LibraryManager` resolve to the same class.

Update the PHP source classes and the bundled `documentai.model` together
when upgrading from 1.2.0. The default table profile changed from high
accuracy to balanced.

`ConvertOption::$tableRecognitionAccuracy` defaults to
`TableRecognitionAccuracy::BALANCED` (`1`).
`TableRecognitionAccuracy::HIGH_ACCURACY` (`0`) requires the
`table_legacy.model` extension package to be loaded with
`LibraryManager::setDocumentAIModel()`. If it is not loaded, the conversion
still succeeds, but tables are recognized with the rule-based method instead, so
the result differs from the high-accuracy result.

`LibraryManager::getLicenseType()` returns `LicenseType::UNKNOWN`, `TRIAL`, or
`FORMAL` (`0`, `1`, `2`) for the license already verified in the process. It
does not verify again or consume page quota.

## Migration from earlier 1.3 development builds

`DocumentAITableModelProfile` was renamed to `TableRecognitionAccuracy`; the numeric values remain `HIGH_ACCURACY = 0` and `BALANCED = 1`.

The global `LibraryManager::setDocumentAIModelProfile()` API was removed. Set `tableRecognitionAccuracy` on each conversion options object instead. `LibraryManager` also no longer defines `TABLE_MODEL_HIGH_ACCURACY` or `TABLE_MODEL_BALANCED`; use `TableRecognitionAccuracy` constants. Loading a model does not select the profile for a task.

The `tableModelProfile` field from earlier 1.3 development builds was renamed to `tableRecognitionAccuracy`. The old field name is no longer supported.

## Model loading and runtime libraries

Upgrade the language wrapper, native library, and addon/bridge/shim together. Deploy the 1.3.0 `documentai.model`; the old file lacks balanced-profile resources. `LibraryManager::setDocumentAIModel()` merges packages incrementally and preserves already loaded capabilities if another package fails. Configure or reload models only when all conversion calls have returned; changes during conversion or release return code `60`.

## Image input

Image-to-image conversion does not run OCR or layout analysis; multi-page TIFF input is processed frame by frame, with page ranges selecting frames. With OCR disabled, image-to-TXT and image-to-CSV return `95` (`UNSUPPORTED_FEATURE`); enable `enableOcr` for these outputs. Other image-capable output formats retain the complete source image without recognized text when OCR is disabled.

`enableAutoPageSize` (default `false`) selects the nearest standard page size from image resolution. `customPageWidth` and `customPageHeight` (default `0`) set dimensions in points (1/72 inch). Setting both takes precedence over automatic sizing and fits the image proportionally without cropping. These options apply only to image input.

## Word to PDF

The new `Conversion::wordToPdf($in, $out, $opt, $cb)` uses `ConvertOption` and reads only `pageRanges` and `wordPdfBookmarkMode`. `WordPdfBookmarkMode` defines `NONE = 0`, `HEADINGS = 1`, and `WORD_BOOKMARKS = 2`. Defaults convert every page without bookmarks. Code `95` may accompany a produced PDF; check the output file.

## Linux Delivery ZIP

The delivery is `PDFSolid_Conversion_linux_php_1_3_0.zip`. Replace the binding, native libraries and model together, preserving the relative `doc/include/lib/resource/samples` layout. No npm, gem or Composer installation is required in this delivery.

The Linux core uses system fonts. Initialization and model loading are separate steps; do not pass the model directory as the initialization resource path. The bundled license has an expiration date. Validate the Word, Excel and PPT examples with:

```bash
bash samples/pdfsolidphp -d ffi.enable=true samples/direct_convert_demo.php --suite office
```

## Custom AI callbacks

The binding supports `onOcr/onOcrResult`, `onLayout/onLayoutResult`, `onTable/onTableResult` callback pairs. Triggers receive an image path and synchronously return a boolean; getters return JSON following the C/C++ schema. Callback exceptions are rethrown after native conversion returns.
