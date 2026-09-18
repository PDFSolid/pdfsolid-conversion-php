#include "pdfsolid_conversion_c.h"

/* PHP 7.4 FFI passes options by pointer; the SDK receives them by value.
 * Keep distinct symbols so native SDK calls cannot resolve to this shim.
 * The SDK headers are the authority for the structure and calling convention.
 */
#define PDFSOLID_PHP_CONVERT(format, sdk_function) \
    PDFSOLID_DECL CSDKErrorCode pdfsolid_php_convert_##format( \
        const char* file_path, const char* password, const char* output_path, \
        const CConvertOption* options, CConvertCallback* callback) { \
        if (!options) { \
            return e_CErrInvalidArg; \
        } \
        return sdk_function(file_path, password, output_path, *options, callback); \
    }

PDFSOLID_PHP_CONVERT(word, CPDF_StartPDFToWord)
PDFSOLID_PHP_CONVERT(rtf, CPDF_StartPDFToRtf)
PDFSOLID_PHP_CONVERT(excel, CPDF_StartPDFToExcel)
PDFSOLID_PHP_CONVERT(ppt, CPDF_StartPDFToPpt)
PDFSOLID_PHP_CONVERT(html, CPDF_StartPDFToHtml)
PDFSOLID_PHP_CONVERT(image, CPDF_StartPDFToImage)
PDFSOLID_PHP_CONVERT(searchablepdf, CPDF_StartPDFToSearchablePDF)
PDFSOLID_PHP_CONVERT(txt, CPDF_StartPDFToTxt)
PDFSOLID_PHP_CONVERT(json, CPDF_StartPDFToJson)
PDFSOLID_PHP_CONVERT(markdown, CPDF_StartPDFToMarkdown)
PDFSOLID_PHP_CONVERT(ofd, CPDF_StartPDFToOfd)
