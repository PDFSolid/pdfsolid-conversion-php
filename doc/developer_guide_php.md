# 1. Overview

PDFSolid Conversion SDK is a high-performance library designed for extracting and transforming the data within your PDF files, such as text, images, tables, links, and annotations, into various file formats. The Conversion SDK retains the original document layout and the properties of the file data, helping you build a reliable document conversion workflow in PHP applications.

Effortlessly integrate the PDFSolid Conversion SDK into your PHP projects in just a few steps, and enable the following file format conversions:

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

To enhance format conversion results, PDFSolid also provides AI-powered document tools with the following capabilities:

- Optical Character Recognition (OCR)
- Layout Analysis
- Table Recognition

## 1.1 Why PDFSolid Conversion SDK

- Mature Technology

  With years of technology accumulation, PDFSolid has established a complete mechanism of product iteration to offer a continuous guarantee for product competitiveness.

- Complete PDF and Format Conversion Functionalities

  The comprehensive feature set can meet diverse conversion needs and is easy for customers to use without training costs.

- High-quality Service

  Professional service and technical support can quickly respond to users' feedback through onsite service or remote support such as telephone and email.

- Independent Intellectual Property Rights

  The technology is independent and compliant with ISO, helping enterprises conduct international business without copyright risks.

## 1.2 PDFSolid Conversion SDK for PHP

The PDFSolid Conversion SDK is designed to convert PDF files into many other formats while preserving the original layout and formatting of the documents. In this guide, we will demonstrate how to use the PHP SDK in your projects. The PHP SDK wraps the native C ABI through PHP FFI, so no Zend PHP extension needs to be built or installed.

## 1.3 License & Trial

The PDFSolid Conversion SDK is a commercial SDK that requires a license to grant developers the right to develop and distribute their applications. In development mode, each license is only valid for one device ID. PDFSolid provides flexible licensing models. Please contact [our marketing team](mailto:sales@pdfsolid.com) for more information. Even if you have a license, it is prohibited to distribute any documents, sample code, or source code of the PDFSolid Conversion SDK to any third parties.

If you do not have a license, please contact the PDFSolid Team at sales@pdfsolid.com to obtain a trial license for PDFSolid Conversion SDK.

# 2. Get Started

## 2.1 Requirements
Before starting, please make sure that you have already met the following prerequisites.

### 2.1.1 Get PDFSolid License Key

PDFSolid provides two types of license key: 30-day free trial license, and commercial license.

#### How to Get Free Trial License

Contact our sales team at sales@pdfsolid.com and we will send you a 30-day free trial license for PDFSolid Conversion SDK.

#### How to Get Commercial License

PDFSolid Conversion SDK is a commercial SDK that requires a license for application release. Any documents, sample code, or source code distribution from the released package of PDFSolid to any third party is prohibited.

**Contact Sales**

To get a commercial license for PDFSolid Conversion SDK, feel free to contact our sales team at sales@pdfsolid.com.

For PHP Conversion SDK, the commercial license must be bound to your developer device ID (How to find the developer device ID), and each license is only valid for one device ID in development mode.

### 2.1.2 Download Conversion SDK

Contact us at sales@pdfsolid.com to obtain the PDFSolid PHP Conversion SDK.

### 2.1.3 System Requirements

| Development Platform | System Requirements                                          | Development Environment                                      | Notice                                                                                                                            |
| -------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------- |
| Linux                | - Linux x86_64.<br />- Need PHP 7.4 or higher.               | PHP 7.4+ (PHP 8.x recommended) with `ext-ffi` enabled.       | Samples have been tested on Ubuntu 20.04 / WSL x86_64. Conversion scripts must be started with `samples/pdfsolidphp` or `samples/run.sh`. |

PHP FFI must be enabled in `php.ini`:

```ini
extension=ffi
ffi.enable=true
```

Verify on Linux:

```bash
php -m | grep -i ffi
```

## 2.2 SDK Package Structure

You can contact us at sales@pdfsolid.com to get the PDF format conversion SDK package. The PDFSolid Conversion PHP SDK contains the following files:

- ***"doc"*** - API reference and developer guide.
- ***"lib"*** - Native dynamic libraries (Linux `.so` files).
- ***"license.xml"*** - License XML file used by the bundled samples.
- ***"resource"*** - DocumentAI model resources.
- ***"samples"*** - PHP sample scripts, the sample launcher (`pdfsolidphp`), the runner (`run.sh`), the autoloader (`autoload.php`), and the PHP SDK source code (`src`).
- ***"legal.txt"*** - Legal and copyright information.
- ***"release_notes.txt"*** - Release information.

Typical directory structure:

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

## 2.3 Apply the License Key
If you don't have a license key, please check out [how to obtain a license key](#211-get-pdfsolid-license-key).

PDFSolid Conversion SDK currently supports offline authentication to verify license keys.

*Learn about:*

[*What is the authentication mechanism of PDFSolid's license?*]

### 2.3.1 Copy the License Key

Accurately obtaining the license key is crucial for the application of the license.

1. In the email you received, locate the XML file containing the license key.
2. Open the XML file, and determine the license type based on the `<type>` field. If `<type>online</type>` is present, it indicates an online license. If `<type>offline</type>` is present or if the field is absent, it indicates an offline license.

**Online License**:

```xml
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<license version="1">
    <platform>windows</platform>
    <starttime>xxxxxxxx</starttime>
    <endtime>xxxxxxxx</endtime>
    <type>online</type>
    <key>LICENSE_KEY</key>
</license>
```

**Offline License**:

```xml
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<license version="1">
    <platform>windows</platform>
    <starttime>xxxxxxxx</starttime>
    <endtime>xxxxxxxx</endtime>
    <key>LICENSE_KEY</key>
</license>
```

3. The bundled sample package ships the XML file as `license.xml` in the package root. The PHP samples pass this XML file path directly to `LibraryManager::licenseVerify()`; you do not need to copy the `<key>` value out of the XML manually.

### 2.3.2 Apply the License Key

You can perform offline authentication using the following method:

```php
<?php
// Load the sample autoloader.
require __DIR__ . '/autoload.php';

use PDFSolidKit\Conversion\LibraryManager;
use PDFSolidKit\Conversion\ErrorCode;

// Verify the license. The Linux sample package ships license.xml in the
// package root, and accepts the XML path directly.
$resourcePath = dirname(__DIR__);
$license      = $resourcePath . '/license.xml';
$deviceId     = '';
$appId        = '';

$code = LibraryManager::licenseVerify($license, $deviceId, $appId);
if (!ErrorCode::isSuccess($code)) {
    throw new RuntimeException('License verify failed: ' . ErrorCode::describe($code));
}

// Initialize conversion resources.
LibraryManager::initialize($resourcePath);
```

## 2.4 How to Run a Demo

### **2.4.1 Linux**

PDFSolid Conversion SDK provides demos in the **"samples"** folder. Before running the demo, make sure PHP 7.4+ and `ext-ffi` are available. To run the demo, follow these steps:

1. Open a terminal and navigate to the root of the PDFSolid Conversion PHP SDK package.
2. Run the bundled runner:

```shell
samples/run.sh
```

Successful output is similar to:

```text
Resource: /path/to/PDFSolid_Conversion_Linux_php_1_1_0
DocumentAI model: /path/to/PDFSolid_Conversion_Linux_php_1_1_0/resource/models/documentai.model
SDK version: 1.1.0
pdf to word: 0
pdf to excel: 0
pdf to ppt: 0
pdf to csv: 0
pdf to html: 0
pdf to rtf: 0
pdf to image: 0
pdf to txt: 0
pdf to json: 0
pdf to markdown: 0
pdf to searchable pdf: 0
pdf to ofd: 0
OK: all conversion smoke tests succeeded
```

Output files (Word, Excel, PowerPoint, etc.) will be generated in the **"samples/output_files"** folder.

You can also run a single PHP script through the sample launcher:

```bash
samples/pdfsolidphp samples/version.php
samples/pdfsolidphp samples/direct_convert_demo.php
```

`samples/pdfsolidphp` configures `LD_LIBRARY_PATH` and uses `LD_PRELOAD` to load the native dependencies before the PHP process starts, which avoids native loading-order issues caused by lazy FFI loading.

# 3. Conversion Guides

PDFSolid Conversion SDK allows developers to use a simple API to convert PDF to commonly used file formats such as Word, Excel, PowerPoint, HTML, CSV, PNG, JPEG, RTF, TXT, Searchable PDF, OFD, JSON, and Markdown. It provides a wide range of customized conversion options, such as whether to include images or annotations in PDF documents, whether to enable OCR, whether to enable layout analysis, and more.

## 3.1 Initialize Library Resources
**Overview**

Initialize the necessary file and memory resources required by the PDFSolid Conversion SDK.

**Notes**

- You must initialize SDK resources before calling any conversion interface.
- When using OCR, Layout Analysis, Table Recognition, PDF to Searchable PDF, or PDF to OFD, make sure the DocumentAI model resource under `resource/models/documentai.model` is available.

**Example**

```php
use PDFSolidKit\Conversion\LibraryManager;

// Initialize SDK resources. The path should be the package root that contains
// the "resource" directory (which holds the DocumentAI model).
LibraryManager::initialize('PDFSolid_Conversion_Linux_php_1_1_0');
```

## 3.2 Set DocumentAI Model

**Overview**

Before using OCR, Layout Analysis, Table Recognition, PDF to Searchable PDF, or PDF to OFD, the SDK needs to load the DocumentAI model. The model lifecycle is exposed through three static methods on `LibraryManager`:

| Method | Purpose |
| :----- | :------ |
| `setDocumentAIModel(string $modelPath, int $gpuId = -1): int` | Load the model. Pass `-1` for `$gpuId` to disable GPU acceleration, or a non-negative GPU device index to enable it. |
| `setDocumentAIModelCount(int $layoutModelCount, int $tableModelCount): void` | Configure how many concurrent Layout / Table model instances the SDK keeps in memory. Increase the counts to improve throughput when many conversions run in parallel. |
| `releaseDocumentAIModel(): void` | Free the model (and its GPU resources) without shutting down the rest of the SDK. After this call AI features become unavailable until `setDocumentAIModel()` is invoked again. |

**Notes**

- `setDocumentAIModel()` must be called after `LibraryManager::initialize()` and before any conversion that relies on AI features.
- The method returns an `int` error code; use `ErrorCode::isSuccess()` / `ErrorCode::describe()` to interpret it.

**Example**

```php
use PDFSolidKit\Conversion\ErrorCode;
use PDFSolidKit\Conversion\LibraryManager;

LibraryManager::initialize(__DIR__ . '/../');

$rc = LibraryManager::setDocumentAIModel(__DIR__ . '/../resource/models/documentai.model', -1);
if (!ErrorCode::isSuccess($rc)) {
    throw new RuntimeException('setDocumentAIModel failed: ' . ErrorCode::describe($rc));
}

// Keep one layout model and one table model in memory.
LibraryManager::setDocumentAIModelCount(1, 1);
```

If you want to run OCR, Layout Analysis or Table Recognition with your own model or a third-party service instead of the bundled DocumentAI model, see [3.11 Use Custom AI Models via Callbacks](#311-use-custom-ai-models-via-callbacks).

## 3.3 Get Conversion Progress

Every `Conversion::pdfTo*()` method accepts an optional [`ConvertCallback`](../../../pdfsolid_sdk/php/src/ConvertCallback.php) argument that mirrors the C++ `CConvertCallback` struct. Assigning a callable to `$onProgress` makes the SDK invoke it after each page is processed.

The callback is invoked synchronously from the same OS thread that called the conversion function — PHP FFI does not support cross-thread callbacks.

```php
use PDFSolidKit\Conversion\Conversion;
use PDFSolidKit\Conversion\ConvertCallback;
use PDFSolidKit\Conversion\ConvertOption;

$cb = new ConvertCallback();
$cb->onProgress = static function (int $currentPage, int $totalPage): void {
    printf("progress: %d / %d\n", $currentPage, $totalPage);
};

$option = new ConvertOption();
Conversion::pdfToWord('input.pdf', '', 'output.docx', $option, $cb);
```

## 3.4 Cancel Conversion Task

Assign a callable to `$onCancel` on the `ConvertCallback` to abort a long-running task. The SDK polls the callback periodically; returning `true` causes the conversion to stop and the corresponding `Conversion::pdfTo*()` call to return `ErrorCode::CANCEL` (value `1`).

```php
use PDFSolidKit\Conversion\Conversion;
use PDFSolidKit\Conversion\ConvertCallback;
use PDFSolidKit\Conversion\ConvertOption;
use PDFSolidKit\Conversion\ErrorCode;

$cb = new ConvertCallback();
$pagesDone = 0;
$cb->onProgress = static function (int $current, int $total) use (&$pagesDone): void {
    $pagesDone = $current;
};
$cb->onCancel = static function () use (&$pagesDone): bool {
    return $pagesDone >= 1; // stop after the first page
};

$option = new ConvertOption();
$code = Conversion::pdfToWord('input.pdf', '', 'output.docx', $option, $cb);
echo ErrorCode::describe($code) . PHP_EOL; // "Cancel"
```

## 3.5 Select Page Range for Conversion

PDFSolid Conversion SDK supports converting a specified page range. When an empty string is passed, all pages will be converted. If the page range exceeds one page, you can also choose to enable the `outputDocumentPerPage` option to output each PDF page as a separate file. The following example demonstrates how to specify a page range when performing a conversion task:

```php
use PDFSolidKit\Conversion\Conversion;
use PDFSolidKit\Conversion\ConvertOption;

$option = new ConvertOption();
$option->outputDocumentPerPage = true;
$option->pageRanges            = '1-3,5,7-9';

Conversion::convert('Word', 'input.pdf', '', 'output.docx', $option);
```

## 3.6 Contain Image and Annotation Options

### **Overview**

In the process of converting PDF documents into various formats, PDFSolid Conversion SDK offers two additional options for users: one option to determine whether images are included in the generated document, and another to decide if annotations from the PDF file are to be retained.

- With the "Include Images" option enabled, PDFSolid Conversion SDK will extract the images from the PDF document and embed them in the corresponding pages and positions in the output file. For areas with overlapping images, PDFSolid Conversion SDK merges these images into one and embeds it into the exact location on the corresponding page of the output file.
- When the "Include Annotations" option is selected, most annotations are converted into raster images and embedded at the respective positions within your document. However, certain types of annotations, such as highlights, underlines, strikeouts, and squiggly, are converted into their respective formatting equivalents in the converted Word, PPT, and HTML documents, and are marked over the corresponding text. It is important to note that the conversion won't be 100% accurate in every instance.

In the PDFSolid Conversion SDK, the options of including image and annotation are commonly used in the following format conversion:

- PDF to Word
- PDF to Excel
- PDF to PowerPoint
- PDF to HTML
- PDF to RTF
- Extract PDF to JSON
- Extract PDF to Markdown

### **About Text Markup Annotation**

- **Highlight:** When converting PDF to Word format keeping the highlight markups, it is important to note that Microsoft Word only supports 15 highlighter colors. To approximate the original document's appearance as closely as possible, text in the Word document will be marked with a text background color that matches the color of the original document's highlight annotation. For conversions to Microsoft PPT format, the native highlighting feature within the format is used to mark the text. In the case of converting to HTML format, a unique `<span>` tag is created for the marked text, and the background style is set to match the color of the corresponding annotation in the original document.
- **Underlines & Squiggly:** When converting PDF to Word or PPT formats keeping the underline and squiggly markups, the marked text will be marked with the same style in Microsoft Office. When converted to HTML format, the marked text will be styled to display the same effect. However, if a paragraph of text in the original document is marked by both underline and squiggly, then the text will only be marked with one type (Because squiggly is actually a type of underline in Word, PPT, and HTML formats).
- **Strikeout:** When converting strikeout markups to Word and PowerPoint formats, the marked text will be added with a strikeout natively supported by Microsoft Office. However, in these two file formats, the color of the strikeout itself cannot be the same as that in the original PDF document because the strikeout color in Word and PPT will only change according to the color of the marked text font itself. When converted to HTML format, the same strikeout color as the original document will be displayed.

### **Sample**

This Sample demonstrates how to use the PDFSolid Conversion SDK to convert a PDF document to a Word document with the selected options: Include images and annotations.

```php
$option = new ConvertOption();
// Setting contains image and contains annotation.
$option->containImage      = true;
$option->containAnnotation = true;

Conversion::convert('Word', 'input.pdf', '', 'output.docx', $option);
```

## 3.7 Page Layout Mode

In certain formats, the page layout mode plays a key role in the quality of the converted document. PDFSolid Conversion SDK supports two layout modes: Flow Layout and Box Layout.

- **Flow Layout:** This layout uses paragraph indentations, columns, and tab positions to adjust the content. Its main advantage is flexibility; content can flow automatically as the document is edited, and it adapts to various screen sizes on different devices. This layout also supports structured maintenance and can implement consistent global formatting through style templates (e.g., titles, body text). Common use cases include documents that are frequently modified, such as reports, manuals, and dynamic tables.
- **Box Layout:** Based on the PDF's "digital paper" model, this layout accurately positions every element (text, images, tables) on the page using a coordinate system (e.g., text is positioned 5 cm from the top and 3 cm from the left). The main advantage is high-precision rendering, which ensures consistency across different platforms. This layout is particularly useful for documents requiring precise reproduction, such as contracts, design drafts, and academic papers.

In the PDFSolid Conversion SDK, page layout modes are commonly used in the following format conversions:

- PDF to Word
- PDF to HTML

### **Sample**

This example demonstrates how to convert a PDF document to Word with Flow Layout and Box Layout:

```php
use PDFSolidKit\Conversion\PageLayoutMode;

$option = new ConvertOption();

// Set Flow Layout mode.
$option->pageLayoutMode = PageLayoutMode::FLOW;
Conversion::convert('Word', 'input.pdf', '', 'output_flow.docx', $option);

// Set Box Layout mode.
$option->pageLayoutMode = PageLayoutMode::BOX;
Conversion::convert('Word', 'input.pdf', '', 'output_box.docx', $option);
```

## 3.8 OCR

### **Overview**

OCR (Optical Character Recognition) is the process of converting images of typed, handwritten, or printed text into machine-encoded text.

OCR is commonly used for text recognition and extraction from the following types of documents:

- Non-editable scanned PDF files.
- Photographs of documents.
- Scene photos such as advertising layouts, signboards, etc.
- Identification cards, passports, vehicle license plates, and other official plates.
- Invoices, bills, receipts, and other financial documents.

The following features support OCR:

- PDF to Word
- PDF to Excel
- PDF to PowerPoint (PPT)
- PDF to HTML
- PDF to Rich Text Format (RTF)
- PDF to Text (TXT)
- PDF to CSV
- PDF to Searchable PDF
- Extract PDF to JSON
- Extract PDF to Markdown

OCR Language Support (`OcrLanguage` constants):

| Constant                 | Meaning                                |
| ------------------------ | -------------------------------------- |
| `OcrLanguage::AUTO`      | Auto-detect language.                  |
| `OcrLanguage::ENGLISH`   | English (Latin).                       |
| `OcrLanguage::CHINESE`   | Chinese (Simplified).                  |
| `OcrLanguage::CHINESE_TRA` | Chinese (Traditional).               |
| `OcrLanguage::JAPANESE`  | Japanese.                              |
| `OcrLanguage::KOREAN`    | Korean.                                |
| `OcrLanguage::LATIN`     | Latin-script languages (German, French, Spanish, Portuguese, Italian, Dutch, Danish, Swedish, etc.). |
| `OcrLanguage::DEVANAGARI`| Devanagari-script languages.           |
| `OcrLanguage::CYRILLIC`  | Cyrillic-script languages.             |
| `OcrLanguage::ARABIC`    | Arabic.                                |
| `OcrLanguage::TAMIL`     | Tamil.                                 |
| `OcrLanguage::TELUGU`    | Telugu.                                |
| `OcrLanguage::KANNADA`   | Kannada.                               |
| `OcrLanguage::THAI`      | Thai.                                  |
| `OcrLanguage::GREEK`     | Greek.                                 |
| `OcrLanguage::ESLAV`     | Eastern Slavic / extended Slavic.      |

### **Set OCR Language**

In the current mainline PHP SDK, OCR languages are passed through `ConvertOption::$languages` for each conversion task, rather than through a separate global interface.

```php
use PDFSolidKit\Conversion\OcrLanguage;

$option = new ConvertOption();
$option->enableOcr = true;
$option->languages = [OcrLanguage::ENGLISH];

Conversion::convert('Word', 'word.pdf', 'password', 'output.docx', $option);
```

### **OCR Options**

Different OCR options can be selected according to actual needs. Below are the currently supported OCR options.

- **`OcrOption::INVALID_CHARACTER`:** Recognizes invalid/garbled characters in the PDF document through OCR, while normal characters are not processed by OCR.
- **`OcrOption::SCAN_PAGE`:** Recognizes scanned pages in the PDF document through OCR, while editable pages are not processed by OCR.
- **`OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE`:** Recognizes both invalid characters and scanned pages in the PDF document through OCR.
- **`OcrOption::ALL`:** Recognizes all pages and characters in the PDF document through OCR.

### **Preserve Page Background**

When OCR is enabled, you can choose whether to enable the `containPageBackgroundImage` option. If this option is enabled, the original page background image of the PDF will be preserved. If it is disabled, the image result detected during page layout analysis will be retained.

### **Notice**

- The quality of the OCR result depends on the quality of the input image. If the input image has a low resolution, the OCR result quality will be affected. A good rule of thumb is that the more pixels in the character shapes, the better. If the character bounding box is smaller than 20x20 pixels, OCR quality will drop exponentially. The ideal image is a grayscale image with a resolution around 300 DPI.
- When performing OCR, make sure the OCR language setting matches the language in the PDF document to achieve the best OCR conversion quality.
- OCR functionality currently does not support operating systems lower than Windows 10.

### Converting Images to Other Document Formats

The OCR function also supports converting input images into Word, Excel, PPT, HTML, CSV, RTF, TXT, JSON, and other formats. This sample demonstrates how to use the PDFSolid OCR function to convert image files to a DOCX file.

```php
$option = new ConvertOption();
// Enable OCR option.
$option->enableOcr = true;
// Set the OCR language for this task.
$option->languages = [OcrLanguage::ENGLISH];

// Supports jpg, jpeg, png, bmp, tiff, and webp formats.
Conversion::convert('Word', 'input.png', '', 'output.docx', $option);
```

### **Sample**

This Sample demonstrates how to use the PDFSolid OCR function to convert a PDF to DOCX file.

```php
$option = new ConvertOption();
$option->enableOcr = true;
$option->languages = [OcrLanguage::ENGLISH];

Conversion::convert('Word', 'word.pdf', 'password', 'output.docx', $option);
```

## 3.9 Layout Analysis

### **Overview**

Layout analysis is the process of leveraging Artificial Intelligence (AI) technology to parse and understand the structure of a document's layout. Its primary goal is to extract text, images, tables, layers, and other data from the input documents.

Layout analysis has several common use cases, including:

- **Intelligent recognition of tables within PDF documents:** This feature is particularly useful for analyzing company financial statements, invoices, bank statements, experimental data, medical test reports, and more.
- **Smart extraction of text, images, or tables from PDF documents through layout analysis:** This functionality greatly aids in the analysis and extraction of information from identification cards, receipts, licenses, documents, ancient books, and other various types of files.

Features that support Layout Analysis:

- PDF to Word
- PDF to Excel
- PDF to PowerPoint (PPT)
- PDF to HTML
- PDF to RTF
- PDF to TXT
- PDF to CSV
- Extract PDF to JSON
- Extract PDF to Markdown

### **Notice**

- The DocumentAI model is loaded automatically by `LibraryManager::initialize($resourcePath)`. Make sure `resource/models/documentai.model` is present in the package.
- When OCR is enabled, layout analysis is automatically enabled.
- AI table recognition is a separate stage controlled by its own option. See [3.10 Table Recognition](#310-table-recognition) for details.

### **Sample**

This Sample demonstrates how to use Layout Analysis to convert a PDF to a DOCX file.

```php
$option = new ConvertOption();
// Enable layout analysis option.
$option->enableAiLayout = true;

Conversion::convert('Word', 'word.pdf', 'password', 'output.docx', $option);
```

## 3.10 Table Recognition

### **Overview**

Table Recognition reconstructs the internal structure of tables detected during layout analysis, including rows, columns, merged cells, and cell boundaries, so that the converted document preserves the original tabular semantics instead of producing a flat grid of text fragments.

It is controlled by the independent option `enableAiTableRecognition`, which is exposed on `ConvertOption`. The table model is only invoked for table regions reported by layout analysis whose detection confidence is below the trusted threshold; high-confidence native PDF tables bypass the model to save inference time.

Typical scenarios that benefit from Table Recognition:

- **Borderless or partially bordered tables**, where ruling lines alone cannot describe the structure.
- **Tables with merged header cells, multi-row headers, or spanning cells**, such as financial statements, lab reports, and invoices.
- **Scanned tables processed by OCR**, where geometric reconstruction is required before cell-level data extraction.

Features that support Table Recognition:

- PDF to Word
- PDF to Excel
- PDF to PowerPoint (PPT)
- PDF to HTML
- PDF to RTF
- PDF to CSV
- Extract PDF to JSON
- Extract PDF to Markdown

### **Notice**

- Table Recognition runs only when layout analysis is active (i.e. `enableAiLayout = true`, or implicitly when `enableOcr = true`).
- The DocumentAI model is loaded by `LibraryManager::initialize` from `resource/models/documentai.model`.
- Setting `enableAiTableRecognition = false` disables the table model entirely; detected table regions will then fall back to geometric reconstruction from the underlying page objects.

### **Sample**

This sample demonstrates how to convert a PDF to a DOCX file with Table Recognition enabled.

```php
$option = new ConvertOption();
// Layout analysis must be enabled for Table Recognition to take effect.
$option->enableAiLayout           = true;
// Enable AI table recognition (set to false to disable).
$option->enableAiTableRecognition = true;

Conversion::convert('Word', 'word.pdf', 'password', 'output.docx', $option);
```

## 3.11 Use Custom AI Models via Callbacks

### Overview

Starting with SDK v1.1.0, the PHP SDK exposes the same callback-based extension point as the C++ SDK: you can plug in your own AI inference engine for OCR, Layout Analysis, and Table Recognition and return the result as a JSON string. When the relevant callback pair is registered on `ConvertCallback`, the SDK skips its built-in DocumentAI invocation for that capability and consumes your JSON output instead. If a pair is left unset, the SDK falls back to the built-in DocumentAI model.

### Callback Pairs

Each AI capability uses two callbacks: a trigger that receives the path to a page image (saved as PNG in a temporary directory) and a result getter that returns the JSON string.

| Capability | Trigger callback | Result getter callback | Triggered when |
| ---------- | ---------------- | ---------------------- | -------------- |
| OCR | `$onOcr` | `$onOcrResult` | `enableOcr = true` |
| Layout Analysis | `$onLayout` | `$onLayoutResult` | `enableAiLayout = true` or `enableOcr = true` |
| Table Recognition | `$onTable` | `$onTableResult` | `enableAiTableRecognition = true` and a table region is detected by layout analysis |

Rules:

- The trigger receives a UTF-8 path to a PNG file. Return `true` if inference succeeded, or `false` to make the SDK ignore the result for that page.
- The getter must return a UTF-8 JSON string. The PHP SDK keeps the returned string alive in an internal buffer for the SDK to read.
- Both callbacks for a capability must be set together. If only one is provided, the SDK falls back to the built-in path.
- Coordinates in your JSON must be in the pixel space of the image received by the trigger, with top-left origin, X to the right, and Y down.

### Sample

```php
use PDFSolidKit\Conversion\Conversion;
use PDFSolidKit\Conversion\ConvertCallback;
use PDFSolidKit\Conversion\ConvertOption;
use PDFSolidKit\Conversion\LibraryManager;
use PDFSolidKit\Conversion\OcrLanguage;

LibraryManager::licenseVerify('LICENSE_KEY', 'device_id', 'app_id');
LibraryManager::initialize(__DIR__ . '/../');

$ocrJson    = '';
$layoutJson = '';
$tableJson  = '';

$cb = new ConvertCallback();

$cb->onOcr = static function (string $imagePath) use (&$ocrJson): bool {
    $ocrJson = MyOcrModel::run($imagePath); // your own engine
    return $ocrJson !== '';
};
$cb->onOcrResult = static function () use (&$ocrJson): string {
    return $ocrJson;
};

$cb->onLayout = static function (string $imagePath) use (&$layoutJson): bool {
    $layoutJson = MyLayoutModel::run($imagePath);
    return $layoutJson !== '';
};
$cb->onLayoutResult = static function () use (&$layoutJson): string {
    return $layoutJson;
};

$cb->onTable = static function (string $imagePath) use (&$tableJson): bool {
    $tableJson = MyTableModel::run($imagePath);
    return $tableJson !== '';
};
$cb->onTableResult = static function () use (&$tableJson): string {
    return $tableJson;
};

$option = new ConvertOption();
$option->enableOcr      = true;
$option->enableAiLayout = true;
$option->languages      = [OcrLanguage::ENGLISH];

Conversion::pdfToWord('input.pdf', '', 'output.docx', $option, $cb);
LibraryManager::release();
```

You can register only the capabilities you want to override and leave the rest unset to keep the built-in behavior.

### Thread Safety and Lifetime

- Callbacks are invoked synchronously from the same OS thread that called the conversion function. PHP FFI does not support cross-thread callbacks, so you do not need any locking for the PHP closures themselves.
- The PNG image at the path passed to the trigger lives in the SDK temporary directory and may be deleted shortly after the trigger returns. Copy or process it before returning.
- The `ConvertCallback` instance and the `Conversion::pdfTo*()` call own the trampolines together; do not modify the callback object until the call returns.

### OCR Result JSON Schema

Returned by `$onOcrResult`. The SDK populates each `text_spans[].chars[]` either from `words[]` if provided, or by uniformly splitting the span rect.

```json
{
  "text_spans": [
    {
      "text": "Hello World",
      "confidence": 0.98,
      "rotation": 0.0,
      "rect": { "left": 120, "top": 80, "right": 320, "bottom": 110 },
      "style": {
        "font_size": 18.0,
        "font_color": { "r": 0, "g": 0, "b": 0 }
      },
      "words": [
        { "text": "Hello", "rect": { "left": 120, "top": 80, "right": 200, "bottom": 110 } },
        { "text": "World", "rect": { "left": 210, "top": 80, "right": 320, "bottom": 110 } }
      ]
    }
  ]
}
```

| Field | Type | Required | Description |
| ----- | ---- | -------- | ----------- |
| `text_spans` | array | Yes | Recognized text spans on the page. |
| `text` | string | Yes | UTF-8 text content of the span. |
| `confidence` | number | No | 0.0 – 1.0. Spans below 0.1 are discarded. |
| `rotation` | number | No | Text rotation in degrees. Default 0. |
| `rect` | object | Yes | Bounding box in image pixels (`left`/`top`/`right`/`bottom`). |
| `style.font_size` | number | No | Estimated font size in pixels. |
| `style.font_color` | object | No | `{ r, g, b }` 0 – 255. |
| `words` | array | No | Per-word boxes. If omitted, the SDK splits the span rect evenly. Strongly recommended for CJK + Latin mixed lines for correct glyph spacing. |

### Layout Analysis Result JSON Schema

Returned by `$onLayoutResult`. Objects with `confidence < 0.45` are discarded.

```json
{
  "objects": [
    { "type": "title", "confidence": 0.95, "rect": { "left": 60, "top": 50, "right": 540, "bottom": 90 } },
    { "type": "paragraph", "confidence": 0.97, "rect": { "left": 60, "top": 100, "right": 540, "bottom": 220 } },
    { "type": "figure", "confidence": 0.92, "rect": { "left": 80, "top": 240, "right": 520, "bottom": 460 } },
    { "type": "table", "confidence": 0.93, "rect": { "left": 60, "top": 480, "right": 540, "bottom": 700 } }
  ]
}
```

Supported `type` values:

| Value | Meaning |
| ----- | ------- |
| `paragraph` | Body text paragraph |
| `title` | Heading |
| `figure` | Image or figure |
| `figure_title` | Figure caption header |
| `figure_caption` | Figure caption text |
| `table` | Table region. Whether the table is bordered or borderless is determined by the table recognition stage, not by the layout label. |
| `table_title` | Table caption header |
| `table_caption` | Table caption text |
| `ordered_list` | Ordered list |
| `unordered_list` | Unordered list |
| `catalogue` | Table of contents |
| `formula` | Math formula |
| `code` | Code block |
| `algorithm` | Algorithm block |
| `header` | Page header |
| `footer` | Page footer |
| `page_number` | Page number |
| `reference` | Reference or citation |

Objects with a `type` value that is not listed above are ignored. Use the values in this table as the canonical layout labels in your custom output.

### Table Recognition Result JSON Schema

Returned by `$onTableResult` once per detected table region. Polygons use eight integers `[x0, y0, x1, y1, x2, y2, x3, y3]` in the order top-left, top-right, bottom-right, bottom-left.

```json
{
  "type": "table_with_line",
  "position": [60, 480, 540, 480, 540, 700, 60, 700],
  "rows": 3,
  "cols": 2,
  "angle": 0.0,
  "height_of_rows": [40, 60, 60],
  "width_of_cols": [200, 280],
  "table_cells": [
    {
      "start_row": 0,
      "end_row": 0,
      "start_col": 0,
      "end_col": 0,
      "cell_background_color_r": 240,
      "cell_background_color_g": 240,
      "cell_background_color_b": 240,
      "position": [60, 480, 260, 480, 260, 520, 60, 520]
    }
  ]
}
```

| Field | Type | Description |
| ----- | ---- | ----------- |
| `type` | string | `table_with_line` for bordered tables; any other value is treated as a non-standard (borderless) table. |
| `position` | int[8] | Table polygon in image pixels. |
| `rows` / `cols` | int | Row / column counts. |
| `angle` | number | Skew angle in degrees. |
| `height_of_rows` | int[] | Per-row pixel heights (length = `rows`). |
| `width_of_cols` | int[] | Per-column pixel widths (length = `cols`). |
| `table_cells[]` | array | One entry per merged cell. |
| `start_row` / `end_row` | int | Inclusive row span of the cell. |
| `start_col` / `end_col` | int | Inclusive column span of the cell. |
| `cell_background_color_*` | int | Cell background color components (0 – 255). |
| `position` | int[8] | Cell polygon in image pixels. |

### Tip: Validate Your JSON

If you need a reference output to compare against, run a conversion once with the built-in DocumentAI model. The SDK uses the same JSON shape internally, so your custom output should follow the same structure.

## 3.12 Output Font Option

**Overview**

In some output formats, you can set the preferred font name to unify the default font style in the output document.

### **Supported Formats**

The `fontName` option currently applies to the following formats:

- PDF to Word
- PDF to Excel
- PDF to PowerPoint
- PDF to Searchable PDF
- PDF to OFD

For Searchable PDF and OFD, `fontName` controls the font used for the invisible (or visible) text layer that is overlaid on the page background. For Word, Excel and PowerPoint, it sets the preferred default font of the generated document.

### **Example**

The following example demonstrates how to set the preferred font name for the output document.

```php
$option = new ConvertOption();
$option->fontName = 'Arial';

Conversion::convert('Word', 'word.pdf', 'password', 'output.docx', $option);
```

## 3.13 Convert PDF to Word

### **Overview**

Converting PDF to Word is an operation that converts the PDF format file into a editing Word format file. By converting PDF to Word, you can easily edit, modify, insert, or delete text and pictures, adjust layout and properties.

### **Layout differences**

- **Word's Streaming Layout:** Ideal for editing, with your editing, the content dynamically adapts to different positions. However, a Word file would display differently due to the incompatibility of various software or app versions. It makes it unsuitable for precise documentation like electronic files or certificates.
- **PDF's Fixed Page Layout:** Ensures a stable, uniform appearance and print quality across all devices. The content and formatting are locked upon creation, making alterations difficult without affecting the overall layout. It's preferred for formal documentation such as business reports and official electronic records.

### **Sample**

This sample demonstrates how to convert from a PDF to DOCX file.

```php
use PDFSolidKit\Conversion\PageLayoutMode;

$option = new ConvertOption();

// Set Reserved page layout.
$option->pageLayoutMode = PageLayoutMode::BOX;
Conversion::convert('Word', 'word.pdf', 'password', 'output_box.docx', $option);

// Set Streaming layout.
$option->pageLayoutMode = PageLayoutMode::FLOW;
Conversion::convert('Word', 'word.pdf', 'password', 'output_flow.docx', $option);
```

### **Convert Formulas to Images**

When a document contains complex formulas and you want to preserve visual consistency in the output document, you can enable the `formulaToImage` option.

```php
$option = new ConvertOption();
$option->formulaToImage = true;

Conversion::convert('Word', 'word.pdf', 'password', 'output.docx', $option);
```

## 3.14 Convert PDF to Excel

### **Overview**

PDFSolid Conversion SDK supports converting PDF documents to Microsoft Excel format (.xlsx). By extracting, parsing, and importing data from PDF into Excel, users can further edit, analyze, or share Excel files. This feature helps increase productivity, reduce manual entry errors, and simplify complex document processing tasks.

### **Set the content options for Excel**

When converting PDF files to Excel files, you need to pay attention to the settings of the following options, which will directly affect the content written to the Excel file.

- Content options:
  If you set the `excelAllContent` option, the converted XLSX file will contain all the contents in the PDF.
- Worksheet options:

  | Option                                | Description                                   |
  | ------------------------------------- | --------------------------------------------- |
  | `ExcelWorksheetOption::FOR_TABLE`     | Create one sheet for one table.               |
  | `ExcelWorksheetOption::FOR_PAGE`      | Create one sheet for one PDF page.            |
  | `ExcelWorksheetOption::FOR_DOCUMENT`  | Create one sheet for the entire PDF document. |

### **Sample**

This sample demonstrates how to convert from a PDF to XLSX file.

```php
use PDFSolidKit\Conversion\ExcelWorksheetOption;

$option = new ConvertOption();
Conversion::convert('Excel', 'excel.pdf', 'password', 'output.xlsx', $option);

// Set all content options.
$option->excelAllContent      = true;
$option->excelWorksheetOption = ExcelWorksheetOption::FOR_DOCUMENT;
Conversion::convert('Excel', 'excel.pdf', 'password', 'output_all.xlsx', $option);
```

## 3.15 Convert PDF to PowerPoint

### **Overview**

PDFSolid Conversion SDK provides the function of converting PDF files to PowerPoint files and restoring the layout and format of the original document, which can meet the needs of users for the presentation and editing of document content in Microsoft PowerPoint.

### **Sample**

This sample demonstrates how to convert from a PDF to PPTX file.

```php
$option = new ConvertOption();
// PDF to PPT.
Conversion::convert('Ppt', 'ppt.pdf', 'password', 'output.pptx', $option);
```

## 3.16 Convert PDF to HTML

### **Overview**

PDFSolid Conversion SDK provides the PDF to HTML function, which can convert PDF files to HTML files while maintaining the layout and format of the original document, allowing users to browse and view the document on Web.

### **Notice**

When converting PDF to HTML format, PDFSolid Conversion SDK provides the following four options to create HTML files:

| **Options**                                | **Description**                                              |
| ------------------------------------------ | ------------------------------------------------------------ |
| `HtmlOption::SINGLE_PAGE`                  | Convert the entire PDF file into a single HTML file, where all PDF pages are connected in sequence according to page number, displayed on the same HTML page. |
| `HtmlOption::SINGLE_PAGE_WITH_BOOKMARK`    | Convert the PDF file into a single HTML file with an outline for navigation at the beginning of the HTML page. Still, all PDF pages are connected in sequence according to page number, displayed on the same HTML page. |
| `HtmlOption::MULTI_PAGE`                   | Convert the PDF file into multiple HTML files. Each HTML file corresponds to a PDF page, and users can navigate to the next HTML file via a link at the bottom of the HTML page. |
| `HtmlOption::MULTI_PAGE_WITH_BOOKMARK`     | Convert the PDF file into multiple HTML files. Each HTML file corresponds to a PDF page, and users can navigate to the next HTML file via a link at the bottom of the HTML page. The links of all the HTML files are presented in an outline HTML file for navigation. |

### **Sample**

This sample demonstrates how to convert from a PDF to HTML file.

```php
use PDFSolidKit\Conversion\HtmlOption;
use PDFSolidKit\Conversion\PageLayoutMode;

$option = new ConvertOption();
// Convert using default options.
Conversion::convert('Html', 'html.pdf', 'password', 'output.html', $option);

// Set the html page display method to HtmlOption::MULTI_PAGE_WITH_BOOKMARK.
$option->pageLayoutMode = PageLayoutMode::BOX;
$option->htmlOption     = HtmlOption::MULTI_PAGE_WITH_BOOKMARK;
Conversion::convert('Html', 'html.pdf', 'password', 'output_multi.html', $option);
```

## 3.17 Convert PDF to CSV

### **Overview**

PDFSolid Conversion SDK supports converting PDF documents to CSV (Comma-Separated Values). Converting PDF to CSV is a common need, usually used to extract tabular or structured data from PDF documents and convert them into CSV files.

In the PHP SDK, CSV output is produced through the Excel pipeline with `excelCsvFormat = true`.

### **Set Whether to Automatically Create Folders**

When multiple CSV files may be output, you can control whether to automatically create folders to store the CSV files by setting the `autoCreateFolder` option. When this option is enabled, a folder with the same name as the output file will be automatically created in the output path to store the CSV files.

### **Sample**

This sample demonstrates how to convert from a PDF to CSV file.

```php
use PDFSolidKit\Conversion\ExcelWorksheetOption;

$option = new ConvertOption();
$option->excelCsvFormat   = true;
$option->autoCreateFolder = true;
Conversion::convert('Excel', 'csv.pdf', 'password', 'output.csv', $option);

// Merge all tables into one CSV file.
$option->excelWorksheetOption = ExcelWorksheetOption::FOR_DOCUMENT;
Conversion::convert('Excel', 'csv.pdf', 'password', 'output_all.csv', $option);
```

## 3.18 Convert PDF to Image

### **Overview**

PDFSolid Conversion SDK provides an API for converting PDF to images. Integrate PDFSolid Conversion SDK to your apps to convert PDF into images easily.

### **Setting Image Formats**

In PDFSolid Conversion SDK, supported image formats include:

- JPG
- JPEG
- JPEG2000
- PNG
- BMP
- TIFF
- TGA
- GIF
- WEBP

### **Setting Image Color Modes**

Supported image color modes in PDFSolid Conversion SDK include:

- **Color (`ImageColorMode::COLOR`):** Color mode, where the image effect is consistent with the original PDF page.
- **Gray (`ImageColorMode::GRAY`):** Grayscale mode.
- **Binary (`ImageColorMode::BINARY`):** Black and white mode, which applies binarization to the original effect.

### **Setting Image Scaling**

The SDK supports setting image scaling. The default scaling is 1.0, which maintains the original PDF page size. If you want to double the image size, you can set `imageScaling` to 2.0; similarly, to reduce the image size by half, set `imageScaling` to 0.5.

### **Enhancing Image Path Display**

The SDK supports an option called `imagePathEnhance` for enhancing the display of image paths. This option can be enabled when you want to enhance the display effect of paths within the PDF page.

- Disable `imagePathEnhance` option:
  ![Disable imagePathEnhance](/image/1.png)
- Enable `imagePathEnhance` option:
  ![Enable imagePathEnhance](/image/2.png)

### **Notice**

- A higher `imageScaling` value results in images with higher resolution, but it also increases memory usage and slows down the conversion.
- A higher `imageScaling` value does not necessarily equate to higher clarity; the clarity also depends on the original image resolution in the document.

### **Sample**

The following complete example code demonstrates how to convert a PDF document into PNG format.

```php
use PDFSolidKit\Conversion\ImageType;

$option = new ConvertOption();

// Convert PDF to Image (JPEG).
$option->imageType = ImageType::JPEG;
Conversion::convert('Image', 'jpeg.pdf', 'password', 'output_jpeg', $option);

// Convert PDF to Image (PNG) and set imageScaling to double the original PDF size.
$option->imageType    = ImageType::PNG;
$option->imageScaling = 2.0;
Conversion::convert('Image', 'png.pdf', 'password', 'output_png', $option);
```

## 3.19 Convert PDF to RTF

### **Overview**

RTF is a popular text format that can retain the format and style data of the text, and it is convenient for most text readers to read and write. Integrate PDFSolid Conversion SDK to convert PDF to RTF files now.

### **Sample**

This sample demonstrates how to convert from a PDF to RTF file.

```php
$option = new ConvertOption();
// PDF to RTF.
Conversion::convert('Rtf', 'rtf.pdf', 'password', 'output.rtf', $option);
```

## 3.20 Convert PDF to TXT

### **Overview**

When you need to extract the text content in the PDF file, in order for data analysis, text mining, information retrieval, etc. Using PDFSolid Convert SDK, you can easily extract the text in the PDF into the TXT file.

### **Preserving Table Format**

The SDK supports an option called `txtTableFormat` that preserves the table format when writing the TXT file, meaning that the original table structure is maintained. It is generally recommended to enable this option, especially useful for data extraction scenarios.

### **Sample**

This sample demonstrates how to convert from a PDF to TXT file.

```php
$option = new ConvertOption();
$option->txtTableFormat = true;

// PDF to TXT.
Conversion::convert('Txt', 'txt.pdf', 'password', 'output.txt', $option);
```

## 3.21 Convert PDF to Searchable PDF

### **Overview**

To make a searchable PDF by adding invisible text to an image based PDF such as a scanned document using OCR.

### **Set Transparent Text Layer**

When outputting a searchable PDF, you can use the following option to control the hidden text layer:

- `transparentText`: Whether to output a transparent text layer.

### **Sample**

The following example demonstrates how to convert a PDF document to a searchable PDF file.

```php
use PDFSolidKit\Conversion\OcrLanguage;

$option = new ConvertOption();
$option->enableOcr       = true;
$option->languages       = [OcrLanguage::ENGLISH];
$option->transparentText = true;

Conversion::convert('SearchablePdf', 'scan.pdf', 'password', 'output.pdf', $option);
```

## 3.22 Convert PDF to OFD

### **Overview**

PDFSolid Conversion SDK supports converting PDF documents to OFD documents. Similar to searchable PDF, OFD conversion also supports OCR, page background preservation, and transparent text layers.

### **Notice**

- If you need to generate searchable OFD output, you can enable `transparentText`.
- When `enableOcr` is enabled, it is recommended to specify the OCR language through `languages`.

### **Sample**

```php
use PDFSolidKit\Conversion\OcrLanguage;

$option = new ConvertOption();
$option->enableOcr                  = true;
$option->languages                  = [OcrLanguage::ENGLISH];
$option->containPageBackgroundImage = true;
$option->transparentText            = true;

Conversion::convert('Ofd', 'scan.pdf', 'password', 'output.ofd', $option);
```

## 3.23 Releasing Library Resources

### **Overview**

Releases the files and memory resources occupied by the PDFSolid Conversion SDK.

### **Notice**

- After calling this interface to release library resources, the PDFSolid Conversion SDK will no longer function properly and must be reloaded.
- If you only want to release resources occupied by the AI model rather than all SDK resources, call `LibraryManager::releaseDocumentAIModel()` instead. AI features become unavailable until `LibraryManager::setDocumentAIModel()` is called again.

### **Sample**

```php
// Release only the DocumentAI model (keep the rest of the SDK alive).
LibraryManager::releaseDocumentAIModel();

// Release all library resources.
LibraryManager::release();
```

# 4 Data Extraction Guide

Unleash the Power of Data with PDFSolid Conversion SDK's Data Extraction to detect, recognize, analyze, and extract the PDF text, image, table, etc.

## 4.1 Extract PDF To JSON

### **Overview**

Extract text, tables and images from PDF documents to a JSON file.

### **Standard table and non-standard table**

Commonly, tables can be divided into two categories: standard tables and non-standard tables. The specific definitions are as follows:

- **Standard table:** The table border and the inner lines of the table are complete and clear. There is no need to manually add table lines to divide the table content.
  ![Standard table example](/image/3.png)
- **Non-Standard Tables:** Tables lacking borders or clear inner lines, requiring manual additions of table lines to separate contents.
  ![Non-standard table example](/image/4.png)

### **Table Extraction Option**

PDFSolid Conversion SDK supports the option `jsonContainTable`. When enabled, it will extract table content from PDFS and output the table structure; otherwise, table content will be treated as regular text.

### **Notice**

- Without enabling AI layout analysis or OCR options, tables in the original PDF cannot be extracted. It is recommended to enable AI layout analysis or OCR for high-precision table recognition.

### **Sample**

Full sample code which illustrates the text extraction capabilities.

```php
$option = new ConvertOption();
$option->enableAiLayout    = true;
$option->jsonContainTable  = true;

// Extract PDF to JSON.
Conversion::convert('Json', 'json.pdf', 'password', 'output.json', $option);
```

## 4.2 Extract PDF To Markdown

### **Overview**

Extract text, tables and images from PDF documents to a Markdown file.

### **Sample**

Full code sample which shows how to convert from a PDF to Markdown file.

```php
$option = new ConvertOption();
$option->enableAiLayout = true;

// Extract PDF to Markdown.
Conversion::convert('Markdown', 'markdown.pdf', 'password', 'output.md', $option);
```

# 5. Support

## 5.1 FAQ

- **Does OCR work on x86 architecture?**

  Currently, the OCR only works on x64 architecture.

- **PHP FFI is not enabled.**

  Make sure `extension=ffi` and `ffi.enable=true` are set in `php.ini`, then verify with `php -m | grep -i ffi`.

- **PHP script crashes when run directly with `php`.**

  Always start PHP scripts that call the SDK through `samples/pdfsolidphp` (or `samples/run.sh`). The launcher preloads the native dependencies before PHP starts, avoiding native loading-order issues caused by lazy FFI loading.

- **License invalid.**

  - Make sure `license.xml` exists in the package root.
  - Make sure the license platform matches the current runtime platform.
  - Pass the XML file path directly to `LibraryManager::licenseVerify()`.
  - If your license requires a device ID or application ID, pass them as the second and third parameters of `LibraryManager::licenseVerify()`.

- **Native library directory is not found.**

  Make sure `lib/linux/libpdfsolidconversionsdk.so`, `lib/linux/libDocumentAI.so.4.0.0`, `lib/linux/libonnxruntime.so.1.18.0`, `lib/linux/libopencv_world.so.410`, and `lib/linux/libpdfsolid_php_shim.so` are present. If they are stored in another directory, set `PDFSOLID_LIB_DIR` before running the sample.

## 5.2 Contact Us

Thanks for your interest in PDFSolid Conversion SDK, the easy-to-use and powerful development solution. If you encounter technical questions or bug issues when using PDFSolid Conversion SDK, please submit the problem report to the [PDFSolid team](mailto:support@pdfsolid.com). More information as follows would help us to solve your problem:

- PDFSolid Conversion SDK product and version.
- Your operating system and PHP version.
- Detailed descriptions of the problem.
- Any other related information, such as an error screenshot.

### Contact Information

- Website: [https://www.pdfsolid.com](https://www.pdfsolid.com/)
- Sales: [sales@pdfsolid.com](mailto:sales@pdfsolid.com)
- Support: [support@pdfsolid.com](mailto:support@pdfsolid.com)

Thanks,
