# PDFSolid Conversion SDK for PHP

PDFSolid Conversion SDK is a high-performance library designed for extracting and transforming the data within your PDF files, such as text, images, tables, links, and annotations, into various file formats. The Conversion SDK retains the original document layout and the properties of the file data, helping you build a reliable document conversion workflow in PHP applications.

The PHP SDK wraps the native C ABI through PHP FFI, so no Zend PHP extension needs to be built or installed.

## Supported Conversions

- Convert PDF to Word (.docx)
- Convert PDF to Excel (.xlsx)
- Convert PDF to PowerPoint (.pptx)
- Convert PDF to HTML (.html)
- Convert PDF to CSV (.csv)
- Convert PDF to Image (.png, .jpg, .jpeg, .jpeg2000, .bmp, .tiff, .tga, .gif, .webp)
- Convert PDF to Plain Text (.txt)
- Convert PDF to Rich Text Format (.rtf)
- Convert PDF to Searchable PDF (.pdf)
- Convert PDF to OFD (.ofd)
- Convert PDF to Structured Data (.json)
- Convert PDF to Markdown (.md)

## AI-Powered Document Tools

- Optical Character Recognition (OCR)
- Layout Analysis
- Table Recognition

## Requirements

| Development Platform | System Requirements | Development Environment | Notice |
| -------------------- | ------------------- | ----------------------- | ------ |
| Linux | - Linux x86_64.<br />- Need PHP 7.4 or higher. | PHP 7.4+ (PHP 8.x recommended) with `ext-ffi` enabled. | Samples have been tested on Ubuntu 20.04 / WSL x86_64. Conversion scripts must be started with `samples/pdfsolidphp` or `samples/run.sh`. |

PHP FFI must be enabled in `php.ini`:

```ini
extension=ffi
ffi.enable=true
```

Verify on Linux:

```bash
php -m | grep -i ffi
```

## SDK Package Structure

```text
PDFSolid_Conversion_Linux_php_1_1_0/
├── doc/
├── lib/linux/
│   ├── libpdfsolidconversionsdk.so
│   ├── libDocumentAI.so.4.0.0
│   ├── libonnxruntime.so.1.18.0
│   ├── libopencv_world.so.410
│   └── libpdfsolid_php_shim.so
├── license.xml
├── resource/models/documentai.model
├── samples/
│   ├── pdfsolidphp
│   ├── run.sh
│   ├── autoload.php
│   ├── direct_convert_demo.php
│   ├── version.php
│   ├── src/
│   ├── input_files/
│   └── output_files/
├── legal.txt
└── release_notes.txt
```

## Quick Start

### 1. Apply the License Key

```php
<?php
require __DIR__ . '/autoload.php';

use PDFSolidKit\Conversion\LibraryManager;
use PDFSolidKit\Conversion\ErrorCode;

$resourcePath = dirname(__DIR__);
$license      = $resourcePath . '/license.xml';
$deviceId     = '';
$appId        = '';

$code = LibraryManager::licenseVerify($license, $deviceId, $appId);
if (!ErrorCode::isSuccess($code)) {
    throw new RuntimeException('License verify failed: ' . ErrorCode::describe($code));
}

LibraryManager::initialize($resourcePath);
```

### 2. Convert PDF to Word

```php
use PDFSolidKit\Conversion\Conversion;
use PDFSolidKit\Conversion\ConvertOption;
use PDFSolidKit\Conversion\PageLayoutMode;

$option = new ConvertOption();
$option->pageLayoutMode = PageLayoutMode::FLOW;
Conversion::convert('Word', 'input.pdf', '', 'output.docx', $option);
```

### 3. Run the Demo

```shell
samples/run.sh
```

Output files will be generated in the **samples/output_files** folder.

## Conversion Examples

### PDF to Excel

```php
use PDFSolidKit\Conversion\ExcelWorksheetOption;

$option = new ConvertOption();
Conversion::convert('Excel', 'input.pdf', '', 'output.xlsx', $option);

$option->excelAllContent      = true;
$option->excelWorksheetOption = ExcelWorksheetOption::FOR_DOCUMENT;
Conversion::convert('Excel', 'input.pdf', '', 'output_all.xlsx', $option);
```

### PDF to HTML

```php
use PDFSolidKit\Conversion\HtmlOption;
use PDFSolidKit\Conversion\PageLayoutMode;

$option = new ConvertOption();
Conversion::convert('Html', 'input.pdf', '', 'output.html', $option);

$option->pageLayoutMode = PageLayoutMode::BOX;
$option->htmlOption     = HtmlOption::MULTI_PAGE_WITH_BOOKMARK;
Conversion::convert('Html', 'input.pdf', '', 'output_multi.html', $option);
```

### PDF to Image

```php
use PDFSolidKit\Conversion\ImageType;

$option = new ConvertOption();
$option->imageType    = ImageType::PNG;
$option->imageScaling = 2.0;
Conversion::convert('Image', 'input.pdf', '', 'output', $option);
```

### PDF to Searchable PDF (OCR)

```php
use PDFSolidKit\Conversion\OcrLanguage;

$option = new ConvertOption();
$option->enableOcr       = true;
$option->languages       = [OcrLanguage::ENGLISH];
$option->transparentText = true;
Conversion::convert('SearchablePdf', 'scan.pdf', '', 'output.pdf', $option);
```

### Extract PDF to JSON

```php
$option = new ConvertOption();
$option->enableAiLayout   = true;
$option->jsonContainTable = true;
Conversion::convert('Json', 'input.pdf', '', 'output.json', $option);
```

### Extract PDF to Markdown

```php
$option = new ConvertOption();
$option->enableAiLayout = true;
Conversion::convert('Markdown', 'input.pdf', '', 'output.md', $option);
```

## Conversion Progress & Cancellation

```php
use PDFSolidKit\Conversion\ConvertCallback;

$cb = new ConvertCallback();
$cb->onProgress = static function (int $currentPage, int $totalPage): void {
    printf("progress: %d / %d\n", $currentPage, $totalPage);
};
$cb->onCancel = static function (): bool {
    return false; // return true to cancel
};

Conversion::pdfToWord('input.pdf', '', 'output.docx', $option, $cb);
```

## OCR Language Support

| Constant | Meaning |
| -------- | ------- |
| `OcrLanguage::AUTO` | Auto-detect language |
| `OcrLanguage::ENGLISH` | English (Latin) |
| `OcrLanguage::CHINESE` | Chinese (Simplified) |
| `OcrLanguage::CHINESE_TRA` | Chinese (Traditional) |
| `OcrLanguage::JAPANESE` | Japanese |
| `OcrLanguage::KOREAN` | Korean |
| `OcrLanguage::LATIN` | Latin-script languages |
| `OcrLanguage::DEVANAGARI` | Devanagari-script languages |
| `OcrLanguage::CYRILLIC` | Cyrillic-script languages |
| `OcrLanguage::ARABIC` | Arabic |
| `OcrLanguage::TAMIL` | Tamil |
| `OcrLanguage::TELUGU` | Telugu |
| `OcrLanguage::KANNADA` | Kannada |
| `OcrLanguage::THAI` | Thai |
| `OcrLanguage::GREEK` | Greek |
| `OcrLanguage::ESLAV` | Eastern Slavic / extended Slavic |

## Custom AI Models via Callbacks (SDK v1.1.0+)

You can plug in your own AI inference engine for OCR, Layout Analysis, and Table Recognition:

```php
$cb = new ConvertCallback();
$cb->onOcr = static function (string $imagePath) use (&$ocrJson): bool {
    $ocrJson = MyOcrModel::run($imagePath);
    return $ocrJson !== '';
};
$cb->onOcrResult = static function () use (&$ocrJson): string {
    return $ocrJson;
};

Conversion::pdfToWord('input.pdf', '', 'output.docx', $option, $cb);
```

See the [Developer Guide](doc/developer_guide_php.md) for full JSON schema documentation.

## Release Resources

```php
LibraryManager::releaseDocumentAIModel();
LibraryManager::release();
```

## Documentation

- [Developer Guide](doc/developer_guide_php.md) - Complete development guide with all conversion options
- [API Reference](doc/api_reference_php.html) - PHP API reference

## FAQ

- **Does OCR work on x86 architecture?** Currently, OCR only works on x64 architecture.
- **PHP FFI is not enabled.** Make sure `extension=ffi` and `ffi.enable=true` are set in `php.ini`.
- **PHP script crashes when run directly with `php`.** Always start PHP scripts through `samples/pdfsolidphp` or `samples/run.sh`. The launcher preloads native dependencies before PHP starts.

## License

The PDFSolid Conversion SDK is a commercial SDK that requires a license. Contact [sales@pdfsolid.com](mailto:sales@pdfsolid.com) for licensing information.

## Contact

- Website: [https://www.pdfsolid.com](https://www.pdfsolid.com/)
- Email: [support@pdfsolid.com](mailto:support@pdfsolid.com)
