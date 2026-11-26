# 1. Overview

PDFSolid Conversion SDK is a high-performance library designed for extracting and transforming the data within your PDF files, such as text, images, tables, links, and annotations, into various file formats. Our Conversion SDK retains the original document layout and the properties of the file data, ensuring a seamless document conversion experience.

Effortlessly integrate the PDFSolid Conversion SDK into your projects in just a few steps, and enable the following file format conversions:

- Convert PDF to Word (.docx)
- Convert PDF to Excel (.xlsx)
- Convert PDF to PowerPoint (.pptx)
- Convert PDF to HTML (.html)
- Convert PDF to CSV (.csv)
- Convert PDF to Image (.png, .jpg, .jpeg,.jpeg2000, .bmp, .tiff, .tga, .gif, .webp)
- Convert PDF to Plain Text (.txt)
- Convert PDF to Rich Text Format (.rtf)
- Convert PDF to Searchable PDF (.pdf)
- Convert PDF to OFD (.ofd)
- Convert PDF to Structured Data (.json)
- Convert PDF to Markdown (.md)
- Convert Word to PDF (.pdf)

Harness the power of PDFSolid Conversion SDK and take your document processing to the next level with intelligent tools designed for accuracy and efficiency. To enhance your format conversion results, PDFSolid Conversion SDK offers AI-powered document tools with the following capabilities:

- Optical Character Recognition (OCR)
- Layout Analysis
- Table Recognition


## 1.1 Why PDFSolid Conversion SDK

- Mature Technology

  With years of technology accumulation, we have established a complete mechanism of product iteration to offer a continuous guarantee for product competitiveness.

- Complete PDF and Format Conversion Functionalities

  Our comprehensive features can meet diverse needs and are easy for our customers to use without training costs.

- High-quality Service

  professional service and technical support to quickly respond to users' feedback through onsite service or remote support like telephone, email, etc.

- Independent Intellectual

  Property Rights
  Our technology is independent and compliant with ISO, helping enterprises conduct international business without considering copyright risks.


## 1.2 PDFSolid Conversion SDK

The PDFSolid Conversion SDK is designed to facilitate the effortless conversion of PDF files into various other formats, all while preserving the original layout and formatting of the documents. In this guide, we will explore the PDFSolid Conversion SDK and demonstrate how to utilize it within your PHP projects.

## 1.3 License & Trial

The PDFSolid Conversion SDK is a commercial SDK that requires a license to grant developers the right to develop and distribute their applications. In development mode, each license is only valid for one device ID. PDFSolid Conversion SDK provides flexible licensing models, please contact [our marketing team](mailto:support@pdfsolid.com) for more information. However, even if you have a license, it is prohibited to distribute any documents, sample code, or source code of the PDFSolid Conversion SDK to any third parties.

If you do not have a License, please feel free to contact the [PDFSolid Conversion SDK Team](https://www.pdfsolid.com/) to obtain a License to try the PDFSolid Conversion SDK.

# 2. Get Started

## 2.1 Requirements
Before starting, please make sure that you have already met the following prerequisites.

### 2.1.1 Get PDFSolid Conversion SDK License Key

PDFSolid Conversion SDK provides two types of license key: 30-day free trial license, and commercial license.

#### How to Get Free Trial License

[Contact our sales team](https://www.pdfsolid.com/) and we'll send you a 30-day free trial license for PDFSolid Conversion SDK.

#### How to Get Commercial License

PDFSolid Conversion SDK is a commercial SDK that requires a license for application release. Any documents, sample code, or source code distribution from the released package of PDFSolid Conversion SDK to any third party is prohibited.

**Contact Sales**

To get commercial license for PDFSolid Conversion SDK, feel free to [contact our sales team](https://www.pdfsolid.com/).

For PHP Conversion SDK, the commercial license must be bound to your developer device ID ([How to find the developer device ID](https://www.pdfsolid.com/)), and each license is only valid for one device ID in development mode.

### 2.1.2 Download Conversion SDK

[Contact us](https://www.pdfsolid.com/) to obtain the PDFSolid Conversion SDK for PHP.

### 2.1.3 System Requirements

| Development Platform | System Requirements                                          | Development Environment                                      | Notice                                                                                                                            |
| -------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------- |
| Linux                | - Linux x86_64.<br />- Need PHP 7.4 or higher.               | PHP 7.4+ (PHP 8.x recommended) with `ext-ffi` enabled.       | Samples have been tested on Ubuntu 20.04 / WSL x86_64. Conversion scripts must be started with `samples/pdfsolidphp`. |

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

- `doc/`: developer guide, upgrade notes and HTML API reference.
- `include/`: native SDK headers.
- `lib/linux/`: Linux x86_64 native libraries and the php binding runtime.
- `resource/models/documentai.model` and `resource/license/license.xml`: bundled model and sample license.
- `samples/demo/RunDemo.sh`, `samples/input_files/`, `samples/output_files/`: runnable example, inputs and results.

## 2.3 Apply the License Key

The SDK supports online and offline licenses. The bundled samples pass the path to `resource/license/license.xml` directly; there is no need to extract its `<key>` value. Online verification requires access to the license service. Offline verification uses the device/application binding in the license. Trial licenses expire; contact sales for a replacement when needed.

Place this code in an application script at the SDK package root. Supply device/application IDs as required by your license; the bundled XML can use the empty values shown here.

```php
<?php
require __DIR__ . '/samples/autoload.php';
$code = \Conversion\LibraryManager::licenseVerify(__DIR__ . '/resource/license/license.xml', '', '');
if ($code !== 0) {
    throw new RuntimeException('License verification failed: ' . $code);
}
\Conversion\LibraryManager::initialize('');
```

Start PHP scripts with `bash samples/pdfsolidphp -d ffi.enable=true your_script.php`.

## 2.4 How to Run a Demo

From the Linux package root, run:

```sh
bash samples/demo/RunDemo.sh
```

The demo reads `resource/license/license.xml` and `samples/input_files/word.docx`. In `samples/output_files/`, `word_to_pdf.pdf` uses the defaults (all pages, no bookmarks); `word_to_pdf_bookmarks.pdf` selects pages `1-2` and creates bookmarks from headings.

# 3. Conversion Guides

PDFSolid Conversion SDK allows developers to use a simple API to convert PDF to commonly used file formats such as Word, Excel, PowerPoint, HTML, CSV, PNG, JPEG, RTF, TXT, Searchable PDF, OFD, JSON, and Markdown. It provides a wide range of customized conversion options, such as whether to include images or annotations in PDF documents, whether to enable OCR, whether to enable layout analysis, and more.

## 3.1 Initialize Library Resources

Initialize the file and memory resources needed by the SDK after successful license verification. Load the required models before conversion using section 3.2; passing a resource path does not load a model. The current Linux core uses system fonts, and the delivery contains no `resource/fonts/` directory.

```php
\Conversion\LibraryManager::initialize('');
```

Conversion calls are synchronous. Wait for all calls to return before releasing the SDK, unloading its libraries or reconfiguring models.

## 3.2 Set DocumentAI Model

The delivery includes `resource/models/documentai.model` for layout analysis, balanced table recognition and base OCR. No additional download is needed for the default AI configuration. After initialization, load this file and check the return code. A GPU argument of `-1` selects CPU execution.

```php
\Conversion\LibraryManager::setDocumentAIModelCount(1, 1);
$code = \Conversion\LibraryManager::setDocumentAIModel(__DIR__ . '/resource/models/documentai.model', -1);
if ($code !== 0) {
    throw new RuntimeException('Model load failed: ' . $code);
}
```

The two instance-count arguments configure the layout and table model counts, respectively.

### **Model Package Reference**

Download optional model packages from https://www.pdfsolid.com/

| File | Size | Capability and use |
| --- | --- | --- |
| `documentai.model` | About 230 MB | Bundled base package: layout analysis, balanced tables and base OCR. |
| `table_legacy.model` | About 270 MB | Table extension required for the high-accuracy `tableRecognitionAccuracy` setting. |
| `ocr_server.model` | About 139 MB | Enhanced OCR for Chinese, English, Japanese and other languages. |
| `document_process.model` | About 37 MB | Orientation classification and dewarping for `enableDocumentOrientationClassification` or `enableDocumentDewarp`. |

**Incremental Loading and Version Compatibility:**

Each `\Conversion\LibraryManager::setDocumentAIModel` call adds the capabilities in one package to the capabilities already loaded; it does not replace them. Package order is unrestricted. A failed load preserves previously loaded capabilities; handle the returned error code. Base and extension packages must match the SDK version.

The 1.3.0 base package retains the filename `documentai.model` but adds balanced-profile resources. Upgrade the binding, native libraries and model together; do not reuse the 1.2.0 file. Selecting high-accuracy tables without loading its extension can still complete conversion, but uses rule-based table recognition. See [3.10 Table Recognition](#310-table-recognition).

`\Conversion\LibraryManager::releaseDocumentAIModel()` releases all loaded packages; reload them before using AI features again. Reconfigure only after all synchronous conversions have returned. Reconfiguration during conversion or pending release returns code `60`.

**Troubleshooting:**

| Symptom | Check |
| --- | --- |
| Model loading returns a nonzero code | Path, file completeness and SDK/model version compatibility. |
| High-accuracy tables differ from expectations | Load `table_legacy.model` and set the high-accuracy option for the task. |
| OCR returns code `29` | The license must include OCR permission; a model does not grant permission. |

The optional OpenVINO acceleration package in the Windows C/C++ guide applies only to Intel CPUs on Windows x64. Use the supplied runtime for this Linux delivery; do not deploy that Windows package.

## 3.3 Get Conversion Progress

Starting with the PHP SDK v1.1.0, every `Conversion::pdfTo*()` method accepts an optional [`ConvertCallback`](html/PdfSolidConversion_ConvertCallback.html) argument that mirrors the C++ `CConvertCallback` struct. Assigning a callable to `$onProgress` makes the SDK invoke it after each page is processed.

The callback is invoked synchronously from the same OS thread that called the conversion function — PHP FFI does not support cross-thread callbacks.

```php
use PdfSolidConversion\Conversion;
use PdfSolidConversion\ConvertCallback;
use PdfSolidConversion\ConvertOption;

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
use PdfSolidConversion\Conversion;
use PdfSolidConversion\ConvertCallback;
use PdfSolidConversion\ConvertOption;
use PdfSolidConversion\ErrorCode;

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
use PdfSolidConversion\Conversion;
use PdfSolidConversion\ConvertOption;

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
use PdfSolidConversion\PageLayoutMode;

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
use PdfSolidConversion\OcrLanguage;

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

### **Converting Images to Other Document Formats**

The OCR function also supports converting input images into Word, Excel, PPT, HTML, CSV, RTF, TXT, JSON, and other formats. This sample demonstrates how to use the PDFSolid Conversion SDK OCR function to convert image files to a DOCX file.

```php
$option = new ConvertOption();
// Enable OCR option.
$option->enableOcr = true;
// Set the OCR language for this task.
$option->languages = [OcrLanguage::ENGLISH];

// Supports jpg, jpeg, png, bmp, tiff, and webp formats.
Conversion::convert('Word', 'input.png', '', 'output.docx', $option);
```

Image-to-image conversion accepts supported images and multi-page TIFF, performs no OCR/layout analysis, and uses page ranges to select frames. With OCR disabled, image-to-TXT or image-to-CSV returns `95` (`UNSUPPORTED_FEATURE`); enable `enableOcr` for those outputs.

`enableAutoPageSize` defaults to `false`; setting it to `true` matches the nearest standard page size from image resolution. `customPageWidth` and `customPageHeight` default to `0`. Set both in points (1/72 inch) to override automatic sizing; the image is scaled proportionally without cropping. These options affect image input only.

### **Sample**

This Sample demonstrates how to use the PDFSolid Conversion SDK OCR function to convert a PDF to DOCX file.

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

- Initialization does not load models. After `LibraryManager::initialize('')`, load `resource/models/documentai.model` with `LibraryManager::setDocumentAIModel()` and check its return code before using AI layout analysis.
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

It is controlled by the independent option `enableAiTableRecognition`, which is exposed on `ConvertOption`.

`ConvertOption::$tableRecognitionAccuracy` selects the DocumentAI table recognition
profile. The default is `TableRecognitionAccuracy::BALANCED` (`1`).
`TableRecognitionAccuracy::HIGH_ACCURACY` (`0`) requires the
`table_legacy.model` extension package to be loaded with
`LibraryManager::setDocumentAIModel()`. If it is not loaded, the conversion
still succeeds, but tables are recognized with the rule-based method instead, so
the result differs from the high-accuracy result.

The table model is only invoked for table regions reported by layout analysis whose detection confidence is below the trusted threshold; high-confidence native PDF tables bypass the model to save inference time.

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
- Load `resource/models/documentai.model` explicitly with `LibraryManager::setDocumentAIModel()` after initialization.
- Setting `enableAiTableRecognition = false` disables the table model entirely; detected table regions will then fall back to geometric reconstruction from the underlying page objects.

### **Sample**

This sample demonstrates how to convert a PDF to a DOCX file with Table Recognition enabled.

```php
$option = new ConvertOption();
// Layout analysis must be enabled for Table Recognition to take effect.
$option->enableAiLayout           = true;
// Enable AI table recognition (set to false to disable).
$option->enableAiTableRecognition = true;
$option->tableRecognitionAccuracy = \Conversion\TableRecognitionAccuracy::BALANCED;

Conversion::convert('Word', 'word.pdf', 'password', 'output.docx', $option);
```

### **Table Model Profile**

Since 1.3.0, `LibraryManager::setDocumentAIModel()` loads model packages incrementally. The base `documentai.model` supplies layout analysis, balanced table recognition, and basic OCR. Additional calls merge the capabilities in extension packages; a failed load preserves already loaded capabilities. Replace any 1.2.0 model with the 1.3.0 file even though the filename is unchanged. Extension packages are available from https://www.pdfsolid.com/

To keep the 1.2.0 high-accuracy table behavior, load the extension and select the profile for each task. This example assumes that license verification and SDK initialization have succeeded:

```php
use PdfSolidConversion\LibraryManager;
use PdfSolidConversion\Conversion;
use PdfSolidConversion\ConvertOption;
use PdfSolidConversion\TableRecognitionAccuracy;

foreach (['/path/documentai.model', '/path/table_legacy.model'] as $path) {
    $code = LibraryManager::setDocumentAIModel($path, -1);
    if ($code !== 0) throw new RuntimeException("Model load failed: $code");
}
$option = new ConvertOption();
$option->enableAiLayout = true;
$option->enableAiTableRecognition = true;
$option->tableRecognitionAccuracy = TableRecognitionAccuracy::HIGH_ACCURACY;
Conversion::convert('Word', 'input.pdf', '', 'output.docx', $option);
```

The profile affects Word, Excel/CSV, PowerPoint, HTML, RTF, TXT, JSON, and Markdown table recognition. Image, searchable PDF, OFD, and Word to PDF conversions do not use it. Configure models only after all synchronous conversion calls finish. Model changes while converting or releasing return code `60`; call release after the conversion calls return.

## 3.11 Use Custom AI Models via Callbacks

### **Overview**

Starting with **SDK v1.1.0**, PDFSolid Conversion SDK exposes a callback-based extension point that lets you plug in your own AI inference engine for OCR, Layout Analysis, and Table Recognition. Instead of relying on the built-in DocumentAI model loaded by `LibraryManager::setDocumentAIModel`, you can:

- Run inference with any model or runtime you choose (e.g. your in-house engine, PaddleOCR, a cloud OCR API).
- Return the result to the SDK as a JSON string with a well-defined schema.

When the relevant callback pair is registered on `ConvertCallback`, the SDK skips its built-in model invocation for that capability and consumes your JSON output instead. If a pair is left as `null`, the SDK falls back to the built-in DocumentAI model (when available).

### **Callback Pairs**

Each AI capability uses **two callbacks**: a *trigger* (invoked by the SDK with the path to a page image saved as PNG in a temp directory) and a *result getter* (invoked by the SDK immediately afterwards to retrieve the JSON string).

| Capability         | Trigger callback | Result getter callback | Triggered when                                                                                  |
| ------------------ | ---------------- | ---------------------- | ----------------------------------------------------------------------------------------------- |
| OCR                | `onOcr`            | `onOcrResult`       | `enableOcr = true`                                                                             |
| Layout Analysis    | `onLayout`         | `onLayoutResult`    | `enableAiLayout = true`                                                |
| Table Recognition  | `onTable`          | `onTableResult`     | `enableAiTableRecognition = true` **and** a table region is detected by layout analysis      |

Rules:

- The trigger receives a UTF-8 path to a PNG file. Return `true` if your inference succeeded, `false` to make the SDK ignore the result for that page.
- The getter returns a UTF-8 JSON string, or `null` on failure. The binding retains its native buffer until the next call to the same getter or the end of conversion.
- Both callbacks for a capability must be set together. Supplying only one callback raises an argument error.
- Coordinates in your JSON must be in the **pixel space of the image the trigger received** (top-left origin, X right, Y down).
- Confidence filtering: OCR spans with `confidence < 0.1` and layout objects with `confidence < 0.45` are discarded by the SDK.

### **Sample**

```php
$ocrJson = $layoutJson = $tableJson = '';
$callback = new \Conversion\ConvertCallback();
$callback->onOcr = function (string $imagePath) use (&$ocrJson): bool {
    $ocrJson = runMyOcrModel($imagePath); return $ocrJson !== '';
};
$callback->onOcrResult = function () use (&$ocrJson): string { return $ocrJson; };
$callback->onLayout = function (string $imagePath) use (&$layoutJson): bool {
    $layoutJson = runMyLayoutModel($imagePath); return $layoutJson !== '';
};
$callback->onLayoutResult = function () use (&$layoutJson): string { return $layoutJson; };
$callback->onTable = function (string $imagePath) use (&$tableJson): bool {
    $tableJson = runMyTableModel($imagePath); return $tableJson !== '';
};
$callback->onTableResult = function () use (&$tableJson): string { return $tableJson; };
$options = new \Conversion\ConvertOption();
$options->enableOcr = true;
$options->enableAiLayout = true;
$options->enableAiTableRecognition = true;
$result = \Conversion\Conversion::pdfToWord('input.pdf', '', 'output.docx', $options, $callback);
```

You can register only the capabilities you want to override and leave the others as `null` to keep the built-in behaviour.

### **Thread Safety and Lifetime**

- Callbacks are invoked from the SDK conversion thread. Implement them in a thread-safe manner if your model engine is shared across calls.
- The PNG image at `image_path` lives in the SDK temp directory and may be deleted shortly after the trigger returns; copy or process it before returning.
- The binding owns the result buffers for the duration of the synchronous call. Callback exceptions request cancellation and are rethrown after the native conversion returns.

### **OCR Result JSON Schema**

Returned by `onOcrResult`. The SDK populates each `text_spans[].chars[]` either from `words[]` if provided, or by uniformly splitting the span rect.

```json
{
  "text_spans": [
    {
      "text": "Hello World",
      "confidence": 0.98,
      "rotation": 0.0,
      "rect":  { "left": 120, "top": 80, "right": 320, "bottom": 110 },
      "style": {
        "font_size":  18.0,
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

| Field                | Type    | Required | Description                                                                 |
| -------------------- | ------- | -------- | --------------------------------------------------------------------------- |
| `text_spans`         | array   | Yes      | Recognized text spans on the page.                                          |
| `text`               | string  | Yes      | UTF-8 text content of the span.                                             |
| `confidence`         | number  | No       | 0.0 – 1.0. Spans below 0.1 are discarded.                                   |
| `rotation`           | number  | No       | Text rotation in degrees. Default 0.                                        |
| `rect`               | object  | Yes      | Bounding box in image pixels (`left`/`top`/`right`/`bottom`).               |
| `style.font_size`    | number  | No       | Estimated font size in pixels.                                              |
| `style.font_color`   | object  | No       | `{ r, g, b }` 0 – 255.                                                      |
| `words`              | array   | No       | Per-word boxes. If omitted, the SDK splits the span rect evenly. Strongly recommended for CJK + Latin mixed lines for correct glyph spacing. |

### **Layout Analysis Result JSON Schema**

Returned by `onLayoutResult`. Objects with `confidence < 0.45` are discarded.

```json
{
  "objects": [
    { "type": "title",     "confidence": 0.95, "rect": { "left": 60, "top": 50,  "right": 540, "bottom": 90  } },
    { "type": "paragraph", "confidence": 0.97, "rect": { "left": 60, "top": 100, "right": 540, "bottom": 220 } },
    { "type": "figure",    "confidence": 0.92, "rect": { "left": 80, "top": 240, "right": 520, "bottom": 460 } },
    { "type": "table",     "confidence": 0.93, "rect": { "left": 60, "top": 480, "right": 540, "bottom": 700 } }
  ]
}
```

Supported `type` values:

| Value            | Meaning                                                                              |
| ---------------- | ------------------------------------------------------------------------------------ |
| `paragraph`      | Body text paragraph                                                                  |
| `title`          | Heading                                                                              |
| `figure`         | Image or figure                                                                      |
| `figure_title`   | Figure caption header                                                                |
| `figure_caption` | Figure caption text                                                                  |
| `onTable`          | Table region. Whether the table is bordered or borderless is determined by the table recognition stage, not by the layout label. |
| `table_title`    | Table caption header                                                                 |
| `table_caption`  | Table caption text                                                                   |
| `ordered_list`   | Ordered list                                                                         |
| `unordered_list` | Unordered list                                                                       |
| `catalogue`      | Table of contents                                                                    |
| `formula`        | Math formula                                                                         |
| `code`           | Code block                                                                           |
| `algorithm`      | Algorithm block                                                                      |
| `header`         | Page header                                                                          |
| `footer`         | Page footer                                                                          |
| `page_number`    | Page number                                                                          |
| `reference`      | Reference or citation                                                                |

Objects with a `type` value that is not listed above are ignored. Use the values in this table as the canonical layout labels in your custom output.

### **Table Recognition Result JSON Schema**

Returned by `onTableResult` once per detected table region. Polygons use 8 integers `[x0, y0, x1, y1, x2, y2, x3, y3]` in the order top-left, top-right, bottom-right, bottom-left.

```json
{
  "type": "table_with_line",
  "position": [60, 480, 540, 480, 540, 700, 60, 700],
  "rows": 3,
  "cols": 2,
  "angle": 0.0,
  "height_of_rows": [40, 60, 60],
  "width_of_cols":  [200, 280],
  "table_cells": [
    {
      "start_row": 0, "end_row": 0,
      "start_col": 0, "end_col": 0,
      "cell_background_color_r": 240,
      "cell_background_color_g": 240,
      "cell_background_color_b": 240,
      "position": [60, 480, 260, 480, 260, 520, 60, 520]
    }
  ]
}
```

| Field                       | Type    | Description                                                                               |
| --------------------------- | ------- | ----------------------------------------------------------------------------------------- |
| `type`                      | string  | `table_with_line` for bordered tables; any other value is treated as a non-standard (borderless) table. |
| `position`                  | int[8]  | Table polygon in image pixels.                                                            |
| `rows` / `cols`             | int     | Row / column counts.                                                                      |
| `angle`                     | number  | Skew angle in degrees.                                                                    |
| `height_of_rows`            | int[]   | Per-row pixel heights (length = `rows`).                                                  |
| `width_of_cols`             | int[]   | Per-column pixel widths (length = `cols`).                                                |
| `table_cells[]`             | array   | One entry per merged cell.                                                                |
| `start_row` / `end_row`     | int     | Inclusive row span of the cell.                                                           |
| `start_col` / `end_col`     | int     | Inclusive column span of the cell.                                                        |
| `cell_background_color_*`   | int     | Cell background color components (0 – 255).                                               |
| `position`                  | int[8]  | Cell polygon in image pixels.                                                             |

### **Tip: Validate Your JSON**

If you need a reference output to compare against, run a conversion once with the built-in DocumentAI model — the SDK uses the same JSON shape internally, so your custom output should follow the same structure.

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `enableAiLayout` | `false` | Uses AI layout analysis to recognize paragraphs, tables, images, headers and footers, and formulas; when off, rule-based layout analysis is used. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the structure of tables with the table model; when off, the table structure is rebuilt from the ruling lines. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `containImage` | `true` | Keeps the images and vector graphics (output as pictures) of the source; when off, they are not output. |
| `containPageBackgroundImage` | `false` | On pages recognized by OCR, places the page image with the recognized text erased as a background behind the text, instead of separate image crops. Only takes effect when `enableOcr` and `containImage` are on. |
| `containAnnotation` | `false` | Outputs the appearance of annotations as images. Only for PDF pages that are not recognized by OCR. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; the first language is also the language of the Word document. When no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `formulaToImage` | `false` | Outputs formulas as pictures; when off, as editable text. Only applies to formulas found by AI layout analysis (`enableAiLayout` on). |
| `fontName` | `''` | Uses the given font for all text, e.g. "Arial"; empty selects fonts automatically. Silently ignored if the font is neither embedded in the PDF nor installed on the system. |
| `pageLayoutMode` | `PageLayoutMode::BOX` | `PageLayoutMode::FLOW`: content is laid out as flowing paragraphs; `PageLayoutMode::BOX`: each region is placed in its own positioned frame. |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `enableAutoPageSize` | `false` | Image input only: sizes the page from the image resolution, matched to the nearest standard paper size; when off, one image pixel becomes one point. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: exact page width and height in points (1 pt = 1/72 inch); both must be greater than 0. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->pageLayoutMode = \Conversion\PageLayoutMode::FLOW;
$option->containImage = true;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToWord("input.pdf", "", "output.docx", $option);
```

### **Layout differences**

- **Word's Streaming Layout:** Ideal for editing, with your editing, the content dynamically adapts to different positions. However, a Word file would display differently due to the incompatibility of various software or app versions. It makes it unsuitable for precise documentation like electronic files or certificates.
- **PDF's Fixed Page Layout:** Ensures a stable, uniform appearance and print quality across all devices. The content and formatting are locked upon creation, making alterations difficult without affecting the overall layout. It's preferred for formal documentation such as business reports and official electronic records.

### **Sample**

This sample demonstrates how to convert from a PDF to DOCX file.

```php
use PdfSolidConversion\PageLayoutMode;

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `excelCsvFormat` | `false` | Must be off to output an .xlsx workbook; when on, CSV is output instead (see "PDF to CSV"). |
| `excelWorksheetOption` | `ExcelWorksheetOption::FOR_DOCUMENT` | `ExcelWorksheetOption::FOR_TABLE`: one worksheet per table, tables only; `ExcelWorksheetOption::FOR_PAGE`: one worksheet per page; `ExcelWorksheetOption::FOR_DOCUMENT`: all content on one worksheet. Image input without OCR always uses `ExcelWorksheetOption::FOR_PAGE`. |
| `excelAllContent` | `false` | Also writes the content outside tables (text, images, headers and footers); when off, only tables are kept. Ignored with `ExcelWorksheetOption::FOR_TABLE`. |
| `enableAiLayout` | `false` | Uses AI layout analysis to recognize paragraphs, tables, images, headers and footers, and formulas; when off, rule-based layout analysis is used. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the structure of tables with the table model; when off, the table structure is rebuilt from the ruling lines. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `containImage` | `true` | Keeps the images and vector graphics of the source. Only visible when content outside tables is written (`excelAllContent` on with `ExcelWorksheetOption::FOR_PAGE` or `ExcelWorksheetOption::FOR_DOCUMENT`); tables-only output never contains images. |
| `containAnnotation` | `false` | Outputs the appearance of annotations as images. Only for PDF pages that are not recognized by OCR, and only visible when content outside tables is written. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `formulaToImage` | `false` | Outputs formulas as pictures; when off, as text. Only applies to formulas found by AI layout analysis, and only visible when content outside tables is written. |
| `fontName` | `''` | Uses the given font for all text, e.g. "Arial"; empty selects fonts automatically. Silently ignored if the font is neither embedded in the PDF nor installed on the system. |
| `outputDocumentPerPage` | `false` | Writes one workbook per page instead of one workbook. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `enableAutoPageSize` | `false` | Image input only: sizes the page from the image resolution, matched to the nearest standard paper size; when off, one image pixel becomes one point. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: exact page width and height in points (1 pt = 1/72 inch); both must be greater than 0. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->excelWorksheetOption = \Conversion\ExcelWorksheetOption::FOR_DOCUMENT;
$option->excelAllContent = true;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToExcel("input.pdf", "", "output.xlsx", $option);
```

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
use PdfSolidConversion\ExcelWorksheetOption;

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `enableAiLayout` | `false` | Uses AI layout analysis to recognize paragraphs, tables, images, headers and footers, and formulas; when off, rule-based layout analysis is used. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the structure of tables with the table model; when off, the table structure is rebuilt from the ruling lines. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `containImage` | `true` | Keeps the images and vector graphics (output as pictures) of the source; when off, they are not output. |
| `containPageBackgroundImage` | `false` | On pages recognized by OCR, outputs the page image with the recognized text erased as a page-sized background, instead of separate image crops; headers and footers found by AI layout analysis are not output separately. Only takes effect when `enableOcr` and `containImage` are on. |
| `containAnnotation` | `false` | Outputs the appearance of annotations as images. Only for PDF pages that are not recognized by OCR. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `formulaToImage` | `false` | Outputs formulas as pictures; when off, as editable text. Only applies to formulas found by AI layout analysis (`enableAiLayout` on). |
| `fontName` | `''` | Uses the given font for all text, e.g. "Arial"; empty selects fonts automatically. Silently ignored if the font is neither embedded in the PDF nor installed on the system. |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `enableAutoPageSize` | `false` | Image input only: sizes the slide from the image resolution, matched to the nearest standard paper size; when off, one image pixel becomes one point. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: exact page width and height in points (1 pt = 1/72 inch); both must be greater than 0. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->containImage = true;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToPpt("input.pdf", "", "output.pptx", $option);
```

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `htmlOption` | `HtmlOption::SINGLE_PAGE` | `HtmlOption::SINGLE_PAGE`: one HTML file; `HtmlOption::SINGLE_PAGE_WITH_BOOKMARK`: one HTML file with an outline navigation; `HtmlOption::MULTI_PAGE`: one HTML file per page; `HtmlOption::MULTI_PAGE_WITH_BOOKMARK`: one HTML file per page with an outline navigation and previous/next links. The navigation is only generated when the PDF has an outline. |
| `pageLayoutMode` | `PageLayoutMode::BOX` | `PageLayoutMode::FLOW`: flowing HTML; `PageLayoutMode::BOX`: absolutely positioned blocks. |
| `enableAiLayout` | `false` | Uses AI layout analysis to recognize paragraphs, tables, images, headers and footers, and formulas; when off, rule-based layout analysis is used. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the structure of tables with the table model; when off, the table structure is rebuilt from the ruling lines. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `containImage` | `true` | Keeps the images and vector graphics of the source (written to the resource folder next to the HTML file); when off, they are not output. |
| `containPageBackgroundImage` | `false` | On pages recognized by OCR, outputs the page image with the recognized text erased as a page-sized background, instead of separate image crops; headers and footers found by AI layout analysis are not output separately. Only takes effect when `enableOcr` and `containImage` are on. |
| `containAnnotation` | `false` | Outputs the appearance of annotations as images. Only for PDF pages that are not recognized by OCR. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `formulaToImage` | `false` | Outputs formulas as pictures; when off, as editable text. Only applies to formulas found by AI layout analysis (`enableAiLayout` on). |
| `outputDocumentPerPage` | `false` | Runs a separate HTML conversion for each page. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `enableAutoPageSize` | `false` | Image input only: sizes the page from the image resolution, matched to the nearest standard paper size; when off, one image pixel becomes one point. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: exact page width and height in points (1 pt = 1/72 inch); both must be greater than 0. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->htmlOption = \Conversion\HtmlOption::SINGLE_PAGE;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToHtml("input.pdf", "", "output.html", $option);
```

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
use PdfSolidConversion\HtmlOption;
use PdfSolidConversion\PageLayoutMode;

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `excelCsvFormat` | `false` | Must be on to output CSV. Only tables are exported. |
| `excelWorksheetOption` | `ExcelWorksheetOption::FOR_DOCUMENT` | `ExcelWorksheetOption::FOR_TABLE`: one CSV file per table; `ExcelWorksheetOption::FOR_PAGE`: one CSV file per page; `ExcelWorksheetOption::FOR_DOCUMENT`: one CSV file with all tables, written to the output path. |
| `autoCreateFolder` | `true` | With `ExcelWorksheetOption::FOR_TABLE` or `ExcelWorksheetOption::FOR_PAGE`, when the output path is an existing folder, the CSV files are put in a new subfolder named after the input file; when off, they are written directly into that folder. If the output path is not an existing folder, a folder is created at that path. |
| `enableAiLayout` | `false` | Finds tables (including tables without borders) with AI layout analysis; when off, only tables with ruling lines are found. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the structure of tables with the table model; when off, the table structure is rebuilt from the ruling lines. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Required for image input; without it the conversion returns `ErrorCode::UNSUPPORTED_FEATURE`. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `outputDocumentPerPage` | `false` | Runs a separate CSV export for each page; each export still follows `excelWorksheetOption`. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->excelCsvFormat = true;
$option->excelWorksheetOption = \Conversion\ExcelWorksheetOption::FOR_DOCUMENT;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToExcel("input.pdf", "", "output.csv", $option);
```

### **Set Whether to Automatically Create Folders**

When multiple CSV files may be output, you can control whether to automatically create folders to store the CSV files by setting the `autoCreateFolder` option. When this option is enabled, a folder with the same name as the output file will be automatically created in the output path to store the CSV files.

### **Sample**

This sample demonstrates how to convert from a PDF to CSV file.

```php
use PdfSolidConversion\ExcelWorksheetOption;

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `imageType` | `ImageType::PNG` | Output image format and file extension. For image input, transparency is kept only for PNG, TIFF, WEBP (and JPEG 2000 where supported) and 16-bit depth only for PNG, TIFF and JPEG 2000; other formats are flattened onto white and converted to 8-bit. |
| `imageColorMode` | `ImageColorMode::COLOR` | `ImageColorMode::COLOR` keeps the color; `ImageColorMode::GRAY` converts to grayscale; `ImageColorMode::BINARY` converts to black and white. |
| `imageScaling` | `1.0` | Pixel size = page size in points × scaling for PDF input, and source pixel size × scaling for image input (a value above 1 enlarges input images). Must be greater than 0. The long side is limited to an internal maximum. |
| `imagePathEnhance` | `false` | Darkens and strengthens vector lines and strokes. PDF input only. |
| `pageRanges` | `''` | Pages (or image frames) to export; empty exports every page. When one page is selected, the output path is used as the file name if it ends with the extension of the image format; when several pages are selected, the output path is used as a folder and numbered files are written into it. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->imageType = \Conversion\ImageType::PNG;
$option->imageScaling = 2.0;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToImage("input.pdf", "", "output.png", $option);
```

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

### **Notice**

- A higher `imageScaling` value results in images with higher resolution, but it also increases memory usage and slows down the conversion.
- A higher `imageScaling` value does not necessarily equate to higher clarity; the clarity also depends on the original image resolution in the document.

### **Sample**

The following complete example code demonstrates how to convert a PDF document into PNG format.

```php
use PdfSolidConversion\ImageType;

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `enableAiLayout` | `false` | Uses AI layout analysis to recognize paragraphs, tables, images, headers and footers, and formulas; when off, rule-based layout analysis is used. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the structure of tables with the table model; when off, the table structure is rebuilt from the ruling lines. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `containImage` | `true` | Keeps the images and vector graphics (output as pictures) of the source; when off, they are not output. |
| `containPageBackgroundImage` | `false` | On pages recognized by OCR, outputs the page image with the recognized text erased as a page-sized background, instead of separate image crops; headers and footers found by AI layout analysis are not output separately. Only takes effect when `enableOcr` and `containImage` are on. |
| `containAnnotation` | `false` | Outputs the appearance of annotations as images. Only for PDF pages that are not recognized by OCR. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `formulaToImage` | `false` | Outputs formulas as pictures; when off, as editable text. Only applies to formulas found by AI layout analysis (`enableAiLayout` on). |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `enableAutoPageSize` | `false` | Image input only: sizes the page from the image resolution, matched to the nearest standard paper size; when off, one image pixel becomes one point. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: exact page width and height in points (1 pt = 1/72 inch); both must be greater than 0. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->containImage = true;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToRtf("input.pdf", "", "output.rtf", $option);
```

### **Sample**

This sample demonstrates how to convert from a PDF to RTF file.

```php
$option = new ConvertOption();
// PDF to RTF.
Conversion::convert('Rtf', 'rtf.pdf', 'password', 'output.rtf', $option);
```

## 3.20 Convert PDF to TXT

### **Overview**

When you need to extract the text content in the PDF file, in order for data analysis, text mining, information retrieval, etc. Using PDFSolid Conversion SDK, you can easily extract the text in the PDF into the TXT file.

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `txtTableFormat` | `false` | On: the cells of a table row are written on one line, separated by two spaces; off: each cell is written on its own line. Only matters when the document has tables. |
| `enableAiLayout` | `false` | Uses AI layout analysis for reading order, paragraphs, lists, headers and footers, and table detection; when off, rule-based paragraphs and ruling-line tables are used. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the cell structure of tables with the table model, which decides how table text is split and ordered. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Required for image input; without it the conversion returns `ErrorCode::UNSUPPORTED_FEATURE`. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `containImage` | `true` | TXT never contains images. With `enableOcr` and `enableAiLayout` on, OCR text inside image regions found by AI layout analysis is dropped while this is on; turn it off to keep that text. |
| `formulaToImage` | `false` | When on, formulas found by AI layout analysis are left out of the TXT; turn it off to keep the formula text. Only applies with `enableAiLayout` on. |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. The files are named after the input file plus the page number and are written to the folder of the output path; the file name in the output path is not used. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->txtTableFormat = true;
$option->formulaToImage = false;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToTxt("input.pdf", "", "output.txt", $option);
```

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

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `transparentText` | `false` | PDF input: on keeps the original pages and adds an invisible OCR text layer; off rebuilds the pages with visible text, and vector graphics are not kept in the rebuilt pages. Image input: the recognized text is invisible (on) or visible (off). |
| `enableOcr` | `false` | Adds the OCR text layer on the pages chosen by `ocrOption`. With `transparentText` on and OCR off, the output is just the selected source pages. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages (visible only when `transparentText` is off); `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; the first language also selects the fallback font of the text layer. When no language is given, English is used. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR; the page size follows the rotation. Only takes effect when `enableOcr` is on and the page is rebuilt (`transparentText` off, or image input). |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on and the page is rebuilt (`transparentText` off, or image input). |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `containImage` | `true` | Only when the page is rebuilt (`transparentText` off, or image input): keeps the source images on pages not recognized by OCR, and is required for `containPageBackgroundImage`. For image input without OCR, the image itself is drawn only when this is on. |
| `containPageBackgroundImage` | `false` | Only when the page is rebuilt and `containImage` is on. On OCR pages with `transparentText` off, draws the page image with the recognized text erased beneath the visible text (off: text only). For image input with `transparentText` on, keeps the source image beneath the invisible text (off: invisible text only). |
| `containAnnotation` | `false` | Draws the appearance of annotations as images on pages that are rebuilt (`transparentText` off) and not recognized by OCR. With `transparentText` on, the original pages keep their annotations unchanged. |
| `fontName` | `''` | Font of the OCR text layer; with `transparentText` off it is also the visible font of the rebuilt pages. If the font cannot be found, the OCR or system font is used. |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. The files are named after the input file plus the page number and are written to the folder of the output path; the file name in the output path is not used. |
| `enableAutoPageSize` | `false` | Image input only: sizes the page from the image resolution, matched to the nearest standard paper size; when off, one image pixel becomes one point. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: exact page width and height in points (1 pt = 1/72 inch); both must be greater than 0. The image is fitted inside with white padding. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->enableOcr = true;
$option->transparentText = true;
$option->containImage = true;
$option->containPageBackgroundImage = true;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToSearchablePdf("input.pdf", "", "output.pdf", $option);
```

### **Set Transparent Text Layer**

When outputting a searchable PDF, you can use the following option to control the hidden text layer:

- `transparentText`: Whether to output a transparent text layer.

### **Sample**

The following example demonstrates how to convert a PDF document to a searchable PDF file.

```php
use PdfSolidConversion\OcrLanguage;

$option = new ConvertOption();
$option->enableOcr       = true;
$option->languages       = [OcrLanguage::ENGLISH];
$option->transparentText = true;

Conversion::convert('SearchablePdf', 'scan.pdf', 'password', 'output.pdf', $option);
```

## 3.22 Convert PDF to OFD

### **Overview**

PDFSolid Conversion SDK supports converting PDF documents to OFD documents. Similar to searchable PDF, OFD conversion also supports OCR, page background preservation, and transparent text layers.

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `enableOcr` | `false` | The text layer comes from OCR on the pages chosen by `ocrOption`; when off, it comes from the text of the PDF. Image input without OCR has no text layer. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters of the text layer on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Turns the page image upright before OCR; the page size follows the rotation. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `enableAiLayout` | `false` | Only changes how the invisible text of pages not recognized by OCR is grouped, and the header and footer detection; the visible page image is not affected. |
| `formulaToImage` | `false` | When on, the text of formulas found by AI layout analysis is removed from the invisible text layer (it can no longer be copied or searched); turn it off to keep it. The page image is unchanged. Only for pages not recognized by OCR, with `enableAiLayout` on. |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. The files are named after the input file plus the page number and are written to the folder of the output path; the file name in the output path is not used. |
| `enableAutoPageSize` | `false` | Image input only: sizes the page from the image resolution, matched to the nearest standard paper size; when off, one image pixel becomes one point. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: exact page width and height in points (1 pt = 1/72 inch); both must be greater than 0. The image is fitted inside with white padding. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->enableOcr = true;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToOfd("input.pdf", "", "output.ofd", $option);
```

### **Notice**

- If you need to generate searchable OFD output, you can enable `transparentText`.
- When `enableOcr` is enabled, it is recommended to specify the OCR language through `languages`.

### **Sample**

```php
use PdfSolidConversion\OcrLanguage;

$option = new ConvertOption();
$option->enableOcr                  = true;
$option->languages                  = [OcrLanguage::ENGLISH];
$option->containPageBackgroundImage = true;
$option->transparentText            = true;

Conversion::convert('Ofd', 'scan.pdf', 'password', 'output.ofd', $option);
```

## 3.23 Convert Word to PDF

[Word to PDF API reference](html/word_to_pdf.html).

### **Overview**

PDFSolid Conversion SDK supports converting Word documents to PDF files. During conversion you can choose to generate PDF bookmarks, output only specific pages. This function is provided by `Conversion::wordToPdf`. Its options are set through `ConvertOption`, the same structure used for PDF conversion; only `wordPdfBookmarkMode` and `pageRanges` take effect for Word to PDF, and the other members are ignored.

`Conversion::wordToPdf(string $in, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int`

### **Conversion Options**

Word to PDF uses only the following members of `ConvertOption`:

| Field | Type | Default | Description |
|---|---|---|---|
| `wordPdfBookmarkMode` | `WordPdfBookmarkMode` | `WordPdfBookmarkMode::NONE` | How PDF bookmarks (the outline shown in a reader's navigation panel) are generated |
| `pageRanges` | `string` | empty | Pages to output, e.g. `"1-3,5,7-9"`; empty outputs every page |

Values of `WordPdfBookmarkMode`:

| Value | Description |
|---|---|
| `WordPdfBookmarkMode::NONE` | Do not generate bookmarks |
| `WordPdfBookmarkMode::HEADINGS` | One bookmark per heading (a paragraph with an outline level), nested by level |
| `WordPdfBookmarkMode::WORD_BOOKMARKS` | One bookmark per Word bookmark, named after it |

### **Return Values and Diagnostics**

- Documents containing features that may affect fidelity return `UNSUPPORTED_FEATURE` (95). The PDF is usually still produced; check the output file.
- If conversion itself fails, its actual error code takes precedence over 95.
- This binding does not expose the native diagnostics buffer.

### **Sample**

```php
$options = new \PdfSolidConversion\ConvertOption();
$options->wordPdfBookmarkMode = \PdfSolidConversion\WordPdfBookmarkMode::HEADINGS;
$options->pageRanges = "1-3,5,7-9";
$result = \PdfSolidConversion\Conversion::wordToPdf("input.docx", "output.pdf", $options);
```

## 3.24 Releasing Library Resources

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

Extract text, tables and images from PDF documents to Json file.

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `jsonContainTable` | `false` | On: each table is output once as an HTML table with the row, column, span and text of every cell; off: the text of each cell is output as a separate text item of the page content. |
| `containImage` | `true` | On: the output is a .zip that holds the JSON, the page renderings and the image items; off: a plain .json without image items. With `enableOcr` and `enableAiLayout` on, it also drops the OCR text inside image regions found by AI layout analysis. |
| `enableAiLayout` | `false` | Gives the object types (title, list, table, header, footer, ...), the grouping, the reading order and the table detection. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the structure of tables with the table model; when off, the table structure is rebuilt from the ruling lines. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Without OCR, image input gives only an image item (if `containImage` is on) and no text. Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Turns the page image upright before OCR; the page width, height and coordinates follow the rotation. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `containAnnotation` | `false` | Outputs the appearance of annotations as image items. Only for PDF pages not recognized by OCR, and only when `containImage` is on. |
| `formulaToImage` | `false` | When on, formulas found by AI layout analysis become text items with empty text; turn it off to keep the formula text. Only applies with `enableAiLayout` on. |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. The files are named after the input file plus the page number and are written to the folder of the output path; the file name in the output path is not used. |
| `enableAutoPageSize` | `false` | Image input only: the page width, height and all positions use the page size from the image resolution, matched to the nearest standard paper size. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: the page width, height and all positions use this exact page size in points; both must be greater than 0. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->jsonContainTable = true;
$option->containImage = false;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToJson("input.pdf", "", "output.json", $option);
```

### **Standard table and non-standard table**

Commonly, tables can be divided into two categories: standard tables and non-standard tables. The specific definitions are as follows:

- **Standard table:** The table border and the inner lines of the table are complete and clear. There is no need to manually add table lines to divide the table content.
- **Non-Standard Tables:** Tables lacking borders or clear inner lines, requiring manual additions of table lines to separate contents.

### **Table Extraction Option**

PDFSolid Conversion SDK supports the option `jsonContainTable`. When enabled, it will extract table content from PDFs and output the table structure; otherwise, table content will be treated as regular text.

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

Extract text, tables and images from PDF documents to Markdown file.

### **Conversion Options**

This format uses only the following options of `ConvertOption`; other options have no effect.

| Option | Default | Meaning |
| --- | --- | --- |
| `enableAiLayout` | `false` | Gives the titles, lists, captions, tables, images and the reading order. Headers and footers are always output as body text in Markdown. Ignored if the license does not include AI layout analysis. |
| `enableAiTableRecognition` | `false` | Recognizes the cell structure of tables with the table model; the tables are written as HTML tables. Only applies to tables found by AI layout analysis (`enableAiLayout` on). |
| `tableRecognitionAccuracy` | `TableRecognitionAccuracy::BALANCED` | Table model: `TableRecognitionAccuracy::BALANCED` uses the base documentai.model, `TableRecognitionAccuracy::HIGH_ACCURACY` uses the table_legacy.model package. Only takes effect when AI table recognition runs with the built-in table model. If the model of the requested accuracy is not loaded, the conversion still succeeds and tables fall back to rule-based recognition. |
| `enableOcr` | `false` | Recognizes text with OCR on the pages chosen by `ocrOption`. Without OCR, image input gives only the page image (if `containImage` is on). Ignored if the license does not include OCR. |
| `ocrOption` | `OcrOption::ALL` | Which content OCR handles: `OcrOption::ALL` every page; `OcrOption::SCAN_PAGE` only image (scanned) pages; `OcrOption::INVALID_CHARACTER` re-recognizes unreadable characters on the other pages; `OcrOption::INVALID_CHARACTER_AND_SCAN_PAGE` both. Only takes effect when `enableOcr` is on. |
| `languages` | `[]` | OCR recognition languages; when no language is given, English is used. Only takes effect when `enableOcr` is on. |
| `enableDocumentOrientationClassification` | `false` | Detects the page rotation and turns the page image upright before OCR. Only takes effect when `enableOcr` is on. |
| `enableDocumentDewarp` | `false` | Flattens curved or warped page photos before OCR. Only takes effect when `enableOcr` is on. |
| `pageRanges` | `''` | Pages to convert, e.g. "1-3,5,7-9"; empty converts every page. For multi-frame image input it selects the frames. |
| `containImage` | `true` | Writes the source images and vector graphics (as pictures) into the Markdown; when off, they are not output. With `enableOcr` and `enableAiLayout` on, image regions are cropped as pictures and the OCR text inside them is dropped. |
| `containAnnotation` | `false` | Writes the appearance of annotations as images, independently of `containImage`. Only for PDF pages not recognized by OCR. |
| `formulaToImage` | `false` | When on, formulas found by AI layout analysis are output as empty paragraphs, so the formula is lost; turn it off to keep the formula text. Only applies with `enableAiLayout` on. |
| `outputDocumentPerPage` | `false` | Writes one file per page instead of one document. The files are named after the input file plus the page number and are written to the folder of the output path; the file name in the output path is not used. |
| `enableAutoPageSize` | `false` | Image input only: the image width and height attributes (in points) follow the page size from the image resolution, matched to the nearest standard paper size. |
| `customPageWidth` / `customPageHeight` | `0.0` / `0.0` | Image input only: the image width and height attributes follow this exact page size in points; both must be greater than 0. Takes precedence over `enableAutoPageSize`. |

Example:

```php
$option = new \Conversion\ConvertOption();
$option->containImage = true;
$option->formulaToImage = false;
$option->pageRanges = "1";
$code = \Conversion\Conversion::pdfToMarkdown("input.pdf", "", "output.md", $option);
```

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

  Always start PHP scripts that call the SDK through `samples/pdfsolidphp` (or `samples/RunDemo.sh`). The launcher preloads the native dependencies before PHP starts, avoiding native loading-order issues caused by lazy FFI loading.

- **License invalid.**

  - Make sure `resource/license/license.xml` exists in the package.
  - Make sure the license platform matches the current runtime platform.
  - Pass the XML file path directly to `LibraryManager::licenseVerify()`.
  - If your license requires a device ID or application ID, pass them as the second and third parameters of `LibraryManager::licenseVerify()`.

- **Native library directory is not found.**

  Make sure `lib/linux/libpdfsolidconversionsdk.so`, `lib/linux/libDocumentAI.so.4.3.0`, `lib/linux/libonnxruntime.so.1`, `lib/linux/libopencv_world.so.410`, and `lib/linux/libpdfsolid_php_shim.so` are present. If they are stored in another directory, set `CONVERSION_LIB_DIR` before running the sample.

## 5.2 Contact Us

Thanks for your interest in PDFSolid Conversion SDK, the easy-to-use and powerful development solution. If you encounter technical questions or bug issues when using PDFSolid Conversion SDK, please submit the problem report to the [PDFSolid Conversion SDK team](mailto:support@pdfsolid.com). More information as follows would help us to solve your problem:

- PDFSolid Conversion SDK product and version.
- Your operating system and PHP version.
- Detailed descriptions of the problem.
- Any other related information, such as an error screenshot.

### **Contact Information**

- Home link: [https://www.pdfsolid.com/](https://www.pdfsolid.com/)
- Technical Support: https://www.pdfsolid.com/
- Email: [support@pdfsolid.com](mailto:support@pdfsolid.com)

Thanks,
