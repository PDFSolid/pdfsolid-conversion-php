# PDFSolid Conversion SDK for PHP

High-performance PHP SDK for converting PDF to Word, Excel, PowerPoint, HTML, Image, TXT, RTF, CSV, JSON, Markdown, Searchable PDF, and OFD with AI-powered OCR, layout analysis, and table recognition.

## Features

- **PDF to Word** (.docx) — Flow and Box layout modes
- **PDF to Excel** (.xlsx) — per-table, per-page, or per-document worksheet options
- **PDF to PowerPoint** (.pptx)
- **PDF to HTML** (.html) — single/multi-page with optional bookmark navigation
- **PDF to CSV** (.csv)
- **PDF to Image** (.png, .jpg, .jpeg, .jpeg2000, .bmp, .tiff, .tga, .gif, .webp) — color/grayscale/binary, configurable scaling
- **PDF to Plain Text** (.txt) — optional table format preservation
- **PDF to RTF** (.rtf)
- **PDF to Searchable PDF** (.pdf) — OCR with transparent text layer
- **PDF to OFD** (.ofd) — OCR, page background preservation, transparent text layer
- **PDF to JSON** (.json) — structured data with table extraction
- **PDF to Markdown** (.md)

### AI-Powered Document Tools

- **OCR** — Optical Character Recognition for scanned documents and images
- **Layout Analysis** — AI-based document structure parsing
- **Table Recognition** — AI-based table structure reconstruction
- **Custom AI Models** — plug in your own OCR, layout, or table engine via callbacks (SDK v1.1.0+)

## Requirements

| Platform | System Requirements | Development Environment |
| -------- | ------------------- | ----------------------- |
| Linux | Linux x86_64, GLIBC 2.31+ | PHP 7.4+ with ext-ffi |

## Quick Start

### 1. Get a License

Contact [sales@pdfsolid.com](mailto:sales@pdfsolid.com) for a 30-day free trial or commercial license.

### 2. Apply License and Initialize

```php
<?php
require __DIR__ . '/autoload.php';

use PDFSolidKit\Conversion\LibraryManager;
use PDFSolidKit\Conversion\ErrorCode;

$resourcePath = dirname(__DIR__);

$code = LibraryManager::licenseVerify($resourcePath . '/license.xml', '', '');
if (!ErrorCode::isSuccess($code)) {
    throw new RuntimeException('License verify failed: ' . ErrorCode::describe($code));
}

LibraryManager::initialize($resourcePath);
```

### 3. Convert

```php
use PDFSolidKit\Conversion\Conversion;
use PDFSolidKit\Conversion\ConvertOption;

$option = new ConvertOption();
Conversion::convert('Word', 'input.pdf', '', 'output.docx', $option);
```

### Release Resources

```php
LibraryManager::releaseDocumentAIModel();
LibraryManager::release();
```

## Conversion Examples

### PDF to Excel

```php
use PDFSolidKit\Conversion\ExcelWorksheetOption;

$option = new ConvertOption();
$option->excelWorksheetOption = ExcelWorksheetOption::FOR_TABLE;
Conversion::convert('Excel', 'input.pdf', '', 'output.xlsx', $option);
```

### PDF to Image

```php
use PDFSolidKit\Conversion\ImageType;

$option = new ConvertOption();
$option->imageType = ImageType::PNG;
$option->imageScaling = 2.0;
Conversion::convert('Image', 'input.pdf', '', 'output', $option);
```

### PDF to Searchable PDF (OCR)

```php
use PDFSolidKit\Conversion\OcrLanguage;

$option = new ConvertOption();
$option->enableOcr = true;
$option->languages = [OcrLanguage::ENGLISH];
$option->transparentText = true;
Conversion::convert('SearchablePdf', 'scan.pdf', '', 'output.pdf', $option);
```

### PDF to JSON with Table Extraction

```php
$option = new ConvertOption();
$option->enableAiLayout = true;
$option->jsonContainTable = true;
Conversion::convert('Json', 'input.pdf', '', 'output.json', $option);
```

### Custom AI Engine (SDK v1.1.0+)

```php
use PDFSolidKit\Conversion\ConvertCallback;

$cb = new ConvertCallback();
$cb->onOcr = static function (string $imagePath) use (&$ocrJson): bool {
    $ocrJson = MyOcrModel::run($imagePath);
    return $ocrJson !== '';
};
$cb->onOcrResult = static function () use (&$ocrJson): string {
    return $ocrJson;
};

$option = new ConvertOption();
$option->enableOcr = true;
$option->enableAiLayout = true;
Conversion::pdfToWord('input.pdf', '', 'output.docx', $option, $cb);
```

## Documentation

- [Developer Guide](doc/developer_guide_php.md)
- [API Reference](doc/api_reference_php.html)

## Contact

- Website: [https://www.pdfsolid.com](https://www.pdfsolid.com/)
- Sales: [sales@pdfsolid.com](mailto:sales@pdfsolid.com)
- Support: [support@pdfsolid.com](mailto:support@pdfsolid.com)
