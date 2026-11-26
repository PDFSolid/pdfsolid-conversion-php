<?php
declare(strict_types=1);

// One-command conversion smoke demo for package verification.
//
// Usage:
//   samples/pdfsolidphp samples/direct_convert_demo.php
//
// Environment overrides:
//   CONVERSION_DEMO_LICENSE   override the packaged license XML path.
//   CONVERSION_DEMO_DEVICE_ID optional device ID.
//   CONVERSION_DEMO_APP_ID    optional app ID.
//   CONVERSION_RESOURCE       compatibility resource path passed to initialize(); models load separately.

require __DIR__ . '/autoload.php';

use PdfSolidConversion\Conversion;
use PdfSolidConversion\ConvertOption;
use PdfSolidConversion\ErrorCode;
use PdfSolidConversion\LibraryManager;
use PdfSolidConversion\OcrLanguage;
use PdfSolidConversion\PageLayoutMode;

const LICENSE_FILE_NAME = 'license.xml';

$arguments = getopt('', ['suite:']);
$suite = $arguments['suite'] ?? 'all';
if (!in_array($suite, ['all', 'office'], true)) {
    fwrite(STDERR, "--suite must be all or office (Word, Excel, PPT)" . PHP_EOL);
    exit(1);
}

$inputDir = __DIR__ . '/input_files';
$outputDir = __DIR__ . '/output_files';
$resourcePath = getenv('CONVERSION_RESOURCE') ?: '';
$modelPath = dirname(__DIR__) . '/resource/models/documentai.model';

$license = getenv('CONVERSION_DEMO_LICENSE') ?: dirname(__DIR__) . '/resource/license/' . LICENSE_FILE_NAME;
$deviceId = getenv('CONVERSION_DEMO_DEVICE_ID') ?: '';
$appId = getenv('CONVERSION_DEMO_APP_ID') ?: '';

foreach (['word.pdf', 'excel.pdf', 'powerpoint.pdf'] as $inputName) {
    $inputPath = $inputDir . '/' . $inputName;
    if (!is_file($inputPath)) {
        fwrite(STDERR, "Input PDF not found: {$inputPath}" . PHP_EOL);
        exit(1);
    }
}

if (!is_dir($outputDir) && !mkdir($outputDir, 0777, true) && !is_dir($outputDir)) {
    fwrite(STDERR, "Failed to create output directory: {$outputDir}" . PHP_EOL);
    exit(1);
}

foreach (glob($outputDir . '/*') ?: [] as $oldPath) {
    if (!removePath($oldPath)) {
        fwrite(STDERR, "Failed to remove old output path: {$oldPath}" . PHP_EOL);
        exit(1);
    }
}

$licenseCode = LibraryManager::licenseVerify($license, $deviceId, $appId);
reportResult('license', $licenseCode);
echo 'licenseVerify => ' . $licenseCode . PHP_EOL;
if (!ErrorCode::isSuccess($licenseCode)) {
    fwrite(STDERR, 'License verify failed: ' . ErrorCode::describe($licenseCode) . " ({$licenseCode})" . PHP_EOL);
    exit(2);
}

LibraryManager::initialize($resourcePath);
LibraryManager::setLogger(false, true);

try {
    $modelCode = LibraryManager::setDocumentAIModel($modelPath, -1);
    reportResult('model', $modelCode);
    echo 'setDocumentAIModel => ' . $modelCode . PHP_EOL;
    if (!ErrorCode::isSuccess($modelCode)) {
        throw new RuntimeException('DocumentAI model failed: ' . $modelCode);
    }
    $option = new ConvertOption();
    $option->enableAiLayout = true;
    $option->enableAiTableRecognition = true;
    $option->containImage = true;
    $option->containAnnotation = true;
    $option->autoCreateFolder = true;

    echo 'Resource: ' . $resourcePath . PHP_EOL;
    echo 'DocumentAI model: ' . (is_file($modelPath) ? $modelPath : 'not found') . PHP_EOL;
    echo 'SDK version: ' . LibraryManager::getVersion() . PHP_EOL;

    runConversion('pdf to word', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToWord($inputDir . '/word.pdf', '', $outputDir . '/word.docx', $option);
    }, $outputDir . '/word.docx');

    runConversion('pdf to excel', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToExcel($inputDir . '/excel.pdf', '', $outputDir . '/excel.xlsx', $option);
    }, $outputDir . '/excel.xlsx');

    runConversion('pdf to ppt', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToPpt($inputDir . '/powerpoint.pdf', '', $outputDir . '/powerpoint.pptx', $option);
    }, $outputDir . '/powerpoint.pptx');

    $docx = $inputDir . '/word.docx';
    $ranged = new ConvertOption();
    $ranged->pageRanges = '1-2';
    $ranged->wordPdfBookmarkMode = \Conversion\WordPdfBookmarkMode::HEADINGS;
    foreach ([
        ['word to pdf', 'word_to_pdf.pdf', null],
        ['word to pdf with options', 'word_to_pdf_bookmarks.pdf', $ranged],
    ] as [$label, $filename, $wordOptions]) {
        $pdf = $outputDir . '/' . $filename;
        $code = Conversion::wordToPdf($docx, $pdf, $wordOptions);
        reportResult($label, $code);
        echo $label . ': ' . $code . PHP_EOL;
        if (!in_array($code, [0, 95], true) || !is_file($pdf) || filesize($pdf) === 0) {
            throw new RuntimeException($label . ' did not produce a PDF; SDK code ' . $code);
        }
        if ($code === 95) fwrite(STDERR, "PDF produced with unsupported Word features.\n");
    }

    if ($suite === 'office') {
        echo 'OK: all office conversion tests succeeded' . PHP_EOL;
        return;
    }

    $option->excelCsvFormat = true;
    runConversion('pdf to csv', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToExcel($inputDir . '/excel.pdf', '', $outputDir, $option);
    }, $outputDir, true);
    $option->excelCsvFormat = false;

    $option->pageLayoutMode = PageLayoutMode::BOX;
    runConversion('pdf to html', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToHtml($inputDir . '/word.pdf', '', $outputDir . '/html.html', $option);
    }, $outputDir . '/html.html');

    runConversion('pdf to rtf', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToRtf($inputDir . '/word.pdf', '', $outputDir . '/rtf.rtf', $option);
    }, $outputDir . '/rtf.rtf');

    runConversion('pdf to image', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToImage($inputDir . '/word.pdf', '', $outputDir, $option);
    }, $outputDir, true);

    runConversion('pdf to txt', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToTxt($inputDir . '/word.pdf', '', $outputDir . '/txt.txt', $option);
    }, $outputDir . '/txt.txt');

    runConversion('pdf to json', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToJson($inputDir . '/word.pdf', '', $outputDir . '/json.json', $option);
    }, $outputDir, true);

    runConversion('pdf to markdown', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToMarkdown($inputDir . '/word.pdf', '', $outputDir . '/markdown.md', $option);
    }, $outputDir, true);

    $option->enableOcr = true;
    $option->transparentText = true;
    $option->languages = [OcrLanguage::ENGLISH];
    runConversion('pdf to searchable pdf', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToSearchablePdf($inputDir . '/word.pdf', '', $outputDir . '/pdf.pdf', $option);
    }, $outputDir . '/pdf.pdf');

    runConversion('pdf to ofd', function () use ($inputDir, $outputDir, $option): int {
        return Conversion::pdfToOfd($inputDir . '/word.pdf', '', $outputDir . '/pdf.ofd', $option);
    }, $outputDir . '/pdf.ofd');

    echo 'OK: all conversion smoke tests succeeded' . PHP_EOL;
} catch (\Throwable $e) {
    fwrite(STDERR, 'Conversion failed: ' . $e->getMessage() . PHP_EOL);
    exit(3);
} finally {
    LibraryManager::releaseDocumentAIModel();
    LibraryManager::release();
}

function reportResult(string $step, int $code): void
{
    $path = getenv('CONVERSION_DEMO_REPORT');
    if ($path !== false && $path !== '') {
        if (file_put_contents($path, json_encode(['step' => $step, 'code' => $code], JSON_THROW_ON_ERROR) . PHP_EOL, FILE_APPEND) === false) {
            throw new RuntimeException('Cannot write demo result report');
        }
    }
}

/**
 * @param callable():int $convert
 */
function runConversion(string $name, callable $convert, string $expectedPath, bool $expectDirectoryOutput = false): void
{
    $before = snapshot($expectedPath);
    $code = $convert();
    reportResult($name, $code);
    echo $name . ': ' . $code . PHP_EOL;
    if (!ErrorCode::isSuccess($code)) {
        throw new RuntimeException($name . ' failed: ' . ErrorCode::describe($code) . " ({$code})");
    }

    if ($expectDirectoryOutput) {
        $created = array_diff(snapshot($expectedPath), $before);
        if (!$created) {
            throw new RuntimeException($name . ' finished but no output file was created in ' . $expectedPath);
        }
        return;
    }

    clearstatcache(true, $expectedPath);
    $size = is_file($expectedPath) ? filesize($expectedPath) : 0;
    if ($size === false || $size <= 0) {
        throw new RuntimeException($name . ' finished but output is missing or empty: ' . $expectedPath);
    }
}

/**
 * @return string[]
 */
function snapshot(string $path): array
{
    if (!is_dir($path)) {
        return [];
    }
    $files = [];
    foreach (glob($path . '/*') ?: [] as $file) {
        if (is_file($file)) {
            $files[] = $file;
        }
    }
    sort($files);
    return $files;
}

function removePath(string $path): bool
{
    if (is_file($path) || is_link($path)) {
        return unlink($path);
    }
    if (!is_dir($path)) {
        return true;
    }
    foreach (glob($path . '/*') ?: [] as $child) {
        if (!removePath($child)) {
            return false;
        }
    }
    return rmdir($path);
}
