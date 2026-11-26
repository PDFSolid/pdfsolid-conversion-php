<?php
declare(strict_types=1);

namespace PdfSolidConversion;

use FFI;
use FFI\CData;
use PdfSolidConversion\Internal\FFIFactory;

/**
 * High-level wrapper around the native PDF and Word conversion functions. Each method
 * returns the raw CSDKErrorCode integer. Use {@see ErrorCode} to interpret
 * the value, or call {@see Conversion::convert()} which throws on error.
 *
 * Pass an optional {@see ConvertCallback} to receive progress / cancel
 * signals or to inject custom OCR / Layout / Table results from outside the
 * bundled DocumentAI model.
 */
final class Conversion
{
    private function __construct() {}

    /** Converts Word to PDF. Only pageRanges and wordPdfBookmarkMode apply. */
    public static function wordToPdf(string $in, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartWordToPDF', $in, '', $out, $opt, $cb); }

    public static function pdfToWord(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToWord', $in, $password, $out, $opt, $cb); }

    public static function pdfToRtf(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToRtf', $in, $password, $out, $opt, $cb); }

    public static function pdfToExcel(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToExcel', $in, $password, $out, $opt, $cb); }

    public static function pdfToPpt(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToPpt', $in, $password, $out, $opt, $cb); }

    public static function pdfToHtml(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToHtml', $in, $password, $out, $opt, $cb); }

    public static function pdfToImage(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToImage', $in, $password, $out, $opt, $cb); }

    public static function pdfToSearchablePdf(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToSearchablePDF', $in, $password, $out, $opt, $cb); }

    public static function pdfToTxt(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToTxt', $in, $password, $out, $opt, $cb); }

    public static function pdfToJson(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToJson', $in, $password, $out, $opt, $cb); }

    public static function pdfToMarkdown(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToMarkdown', $in, $password, $out, $opt, $cb); }

    public static function pdfToOfd(string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): int
    { return self::dispatch('CPDF_StartPDFToOfd', $in, $password, $out, $opt, $cb); }

    /**
     * Convenience wrapper: same as the specific method but throws on failure.
     *
     * @throws Exception\ConversionException when the SDK returns a non-zero code.
     */
    public static function convert(string $format, string $in, string $password, string $out, ?ConvertOption $opt = null, ?ConvertCallback $cb = null): void
    {
        $method = 'pdfTo' . ucfirst(strtolower($format));
        if (!method_exists(self::class, $method)) {
            throw new Exception\ConversionException("Unknown conversion target: $format");
        }
        $code = self::{$method}($in, $password, $out, $opt, $cb);
        if (!ErrorCode::isSuccess($code)) {
            throw new Exception\ConversionException(
                "$method failed: " . ErrorCode::describe($code),
                $code
            );
        }
    }

    private static function dispatch(string $sym, string $in, string $password, string $out, ?ConvertOption $opt, ?ConvertCallback $cb = null): int
    {
        $ffi = FFIFactory::ffi();
        $opt = $opt ?? new ConvertOption();

        // Build the native CConvertOption by value. languages[] must remain
        // alive for the duration of the call.
        $cOpt = $ffi->new('CConvertOption');
        $languagesHolder = null;
        self::fillOption($ffi, $cOpt, $opt, $languagesHolder /* out */);

        // Build the native callback struct (or NULL) and keep both the cdata
        // and the ConvertCallback alive until the SDK call returns so the
        // PHP trampolines are not garbage-collected mid-conversion.
        $cbCData = null;
        $cbArg = null;
        try {
            if ($cb !== null) {
                // Isolate closures and buffers when the same callback is used recursively.
                $cb = clone $cb;
                $cbCData = $cb->buildCData($ffi);
                $cbArg = FFI::addr($cbCData);
            }

            $wordToPdf = $sym === 'CPDF_StartWordToPDF';
            $input = LibraryManager::isWindows() ? LibraryManager::toWString($in) : $in;
            $output = LibraryManager::isWindows() ? LibraryManager::toWString($out) : $out;
            if (PHP_OS_FAMILY === 'Linux') {
                $sym = $wordToPdf ? 'pdfsolid_php_start_word_to_pdf'
                    : 'pdfsolid_php_start_pdf_to_' . strtolower(substr($sym, strlen('CPDF_StartPDFTo')));
            }
            $optionArg = PHP_OS_FAMILY === 'Linux' ? FFI::addr($cOpt) : $cOpt;
            if ($wordToPdf) {
                $rc = $ffi->{$sym}($input, $output, $optionArg, $cbArg, null);
            } else {
                $nativePassword = LibraryManager::isWindows() ? LibraryManager::toWString($password) : $password;
                $rc = $ffi->{$sym}($input, $nativePassword, $output, $optionArg, $cbArg);
            }
            if ($cb !== null) {
                $cb->throwPendingException();
            }
            return (int) $rc;
        } finally {
            if ($languagesHolder !== null) {
                FFI::free($languagesHolder);
            }
            unset($cbCData, $cbArg);
            if ($cb !== null) {
                $cb->releaseNativeResources();
            }
        }
    }

    /**
     * Populate a CConvertOption struct from a high-level ConvertOption.
     *
     * @param CData|null $languagesHolder out: kept alive by caller until the
     *                                    native call completes.
     */
    private static function fillOption(FFI $ffi, CData $cOpt, ConvertOption $opt, ?CData &$languagesHolder): void
    {
        $cOpt->enable_ai_layout              = $opt->enableAiLayout;
        $cOpt->enable_ai_table_recognition   = $opt->enableAiTableRecognition;
        $cOpt->table_recognition_accuracy    = $opt->tableRecognitionAccuracy;
        $cOpt->contain_image                 = $opt->containImage;
        $cOpt->contain_page_background_image = $opt->containPageBackgroundImage;
        $cOpt->json_contain_table            = $opt->jsonContainTable;
        $cOpt->contain_annotation            = $opt->containAnnotation;
        $cOpt->excel_all_content             = $opt->excelAllContent;
        $cOpt->excel_csv_format              = $opt->excelCsvFormat;
        $cOpt->enable_ocr                    = $opt->enableOcr;
        $cOpt->enable_document_orientation_classification = $opt->enableDocumentOrientationClassification;
        $cOpt->enable_auto_page_size         = $opt->enableAutoPageSize;
        $cOpt->custom_page_width             = $opt->customPageWidth;
        $cOpt->custom_page_height            = $opt->customPageHeight;
        $cOpt->enable_document_dewarp      = $opt->enableDocumentDewarp;
        $cOpt->transparent_text              = $opt->transparentText;
        $cOpt->txt_table_format              = $opt->txtTableFormat;
        $cOpt->image_path_enhance            = $opt->imagePathEnhance;
        $cOpt->formula_to_image              = $opt->formulaToImage;
        $cOpt->auto_create_folder            = $opt->autoCreateFolder;
        $cOpt->output_document_per_page      = $opt->outputDocumentPerPage;

        $cOpt->image_scaling                 = $opt->imageScaling;
        $cOpt->page_layout_mode              = $opt->pageLayoutMode;
        $cOpt->excel_worksheet_option        = $opt->excelWorksheetOption;
        $cOpt->html_option                   = $opt->htmlOption;
        $cOpt->ocr_option                    = $opt->ocrOption;
        $cOpt->image_color_mode              = $opt->imageColorMode;
        $cOpt->image_type                    = $opt->imageType;
        $cOpt->word_pdf_bookmark_mode         = $opt->wordPdfBookmarkMode;

        self::writeFixedString($cOpt->font_name,   256, $opt->fontName);
        self::writeFixedString($cOpt->page_ranges, 256, $opt->pageRanges);

        $languagesHolder = null;
        $count = count($opt->languages);
        $cOpt->language_count = $count;
        if ($count > 0) {
            $arr = $ffi->new("int[$count]", false);
            for ($i = 0; $i < $count; $i++) {
                $arr[$i] = (int) $opt->languages[$i];
            }
            $cOpt->languages = FFI::cast('int*', FFI::addr($arr[0]));
            $languagesHolder = $arr;
        } else {
            $cOpt->languages = null;
        }
    }

    private static function writeFixedString(CData $buf, int $capacity, string $value): void
    {
        $bytes = substr($value, 0, $capacity - 1);
        for ($i = 0; $i < $capacity; $i++) {
            $buf[$i] = "\0";
        }
        $len = strlen($bytes);
        for ($i = 0; $i < $len; $i++) {
            $buf[$i] = $bytes[$i];
        }
    }
}
