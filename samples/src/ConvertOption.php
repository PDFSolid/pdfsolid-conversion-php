<?php
declare(strict_types=1);

namespace PdfSolidConversion;

/**
 * High-level mirror of CConvertOption. Use the public properties to configure
 * a conversion call; the Conversion class fills the matching native struct.
 */
class ConvertOption
{
    public bool $enableAiLayout = false;
    public bool $enableAiTableRecognition = false;
    /** @var int One of {@see TableRecognitionAccuracy}. */
    public int $tableRecognitionAccuracy = TableRecognitionAccuracy::BALANCED;
    public bool $containImage = true;
    public bool $containPageBackgroundImage = false;
    public bool $jsonContainTable = false;
    public bool $containAnnotation = false;
    public bool $excelAllContent = false;
    public bool $excelCsvFormat = false;
    public bool $enableOcr = false;
    public bool $enableDocumentOrientationClassification = false;
    public bool $enableDocumentDewarp = false;
    /** Size the output page from an image input's own resolution, matched to the nearest standard paper. */
    public bool $enableAutoPageSize = false;
    /** Output page width in points for image input; set with customPageHeight to choose the page outright. */
    public float $customPageWidth = 0.0;
    /** Output page height in points for image input. */
    public float $customPageHeight = 0.0;
    public bool $transparentText = false;
    public bool $txtTableFormat = false;
    public bool $imagePathEnhance = false;
    public bool $formulaToImage = false;
    public bool $autoCreateFolder = true;
    public bool $outputDocumentPerPage = false;

    public float $imageScaling = 1.0;

    /** @var int One of {@see PageLayoutMode}. */
    public int $pageLayoutMode = PageLayoutMode::BOX;
    /** @var int One of {@see ExcelWorksheetOption}. */
    public int $excelWorksheetOption = ExcelWorksheetOption::FOR_DOCUMENT;
    /** @var int One of {@see HtmlOption}. */
    public int $htmlOption = HtmlOption::SINGLE_PAGE;
    /** @var int One of {@see OcrOption}. */
    public int $ocrOption = OcrOption::ALL;
    /** @var int One of {@see ImageColorMode}. */
    public int $imageColorMode = ImageColorMode::COLOR;
    /** @var int One of {@see ImageType}. */
    public int $imageType = ImageType::PNG;

    public string $fontName = '';
    public string $pageRanges = '';
    /** @var int One of {@see WordPdfBookmarkMode}; only applies to Word to PDF. */
    public int $wordPdfBookmarkMode = WordPdfBookmarkMode::NONE;

    /** @var int[] List of OCR languages (values from {@see OcrLanguage}). */
    public array $languages = [];
}
