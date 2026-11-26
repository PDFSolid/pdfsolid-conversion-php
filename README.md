# PDFSolid Conversion SDK for PHP

High-performance PHP SDK for converting PDF to Word, Excel, PowerPoint, HTML, Image, TXT, RTF, CSV, JSON, Markdown, Searchable PDF, and OFD with AI-powered OCR, layout analysis, and table recognition. SDK v1.3.0 also converts Word documents (`.docx`) to PDF.

## Features

- **PDF to Word** (.docx) — Flow and Box layout modes
- **Word to PDF** (.docx → .pdf) — optional page ranges and PDF bookmarks
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
// For a script placed in the package root.
require __DIR__ . '/samples/autoload.php';

use PdfSolidConversion\LibraryManager;
use PdfSolidConversion\ErrorCode;

$code = LibraryManager::licenseVerify('/path/to/license.xml');
if (!ErrorCode::isSuccess($code)) {
    throw new RuntimeException('License verify failed: ' . ErrorCode::describe($code));
}

LibraryManager::initialize('');
```

Run the script from the package root through the SDK launcher, which preloads native libraries before PHP starts:

```sh
bash samples/pdfsolidphp -d ffi.enable=true your_script.php
```

### 3. Convert

```php
use PdfSolidConversion\Conversion;
use PdfSolidConversion\ConvertOption;

$option = new ConvertOption();
Conversion::convert('Word', 'input.pdf', '', 'output.docx', $option);
```

### Release Resources

```php
LibraryManager::releaseDocumentAIModel();
LibraryManager::release();
```

## Conversion Examples

### Word (DOCX) to PDF

Use the bundled Linux x86_64 PHP FFI binding, with `samples/autoload.php` loaded. After applying the license and initializing the SDK, pass a `.docx` input and a writable `.pdf` output.

```php
$status = \PdfSolidConversion\Conversion::wordToPdf('input.docx', 'output.pdf');
```

The default converts all pages without PDF bookmarks. On an optional `PdfSolidConversion\ConvertOption` passed as the third argument, set `pageRanges` to select pages (for example, `1-2`) and `wordPdfBookmarkMode` to generate bookmarks from headings or Word bookmarks. Check the returned status before using the PDF. `PdfSolidConversion\ErrorCode::UNSUPPORTED_FEATURE` means the input contains features that may affect fidelity; a PDF may still have been written.

See the [Word to PDF API reference](doc/html/word_to_pdf.html) and [PHP sample](samples/direct_convert_demo.php).

### PDF to Excel

```php
use PdfSolidConversion\ExcelWorksheetOption;

$option = new ConvertOption();
$option->excelWorksheetOption = ExcelWorksheetOption::FOR_TABLE;
Conversion::convert('Excel', 'input.pdf', '', 'output.xlsx', $option);
```

### PDF to Image

```php
use PdfSolidConversion\ImageType;

$option = new ConvertOption();
$option->imageType = ImageType::PNG;
$option->imageScaling = 2.0;
Conversion::convert('Image', 'input.pdf', '', 'output', $option);
```

### PDF to Searchable PDF (OCR)

```php
use PdfSolidConversion\OcrLanguage;

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
use PdfSolidConversion\ConvertCallback;

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
