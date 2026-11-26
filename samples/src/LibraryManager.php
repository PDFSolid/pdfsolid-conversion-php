<?php
declare(strict_types=1);

namespace PdfSolidConversion;

use FFI;
use FFI\CData;
use PdfSolidConversion\Exception\ConversionException;
use PdfSolidConversion\Internal\FFIFactory;

/**
 * Common SDK lifecycle: license verification, initialization, logging,
 * version info, page-count queries, and shutdown.
 *
 * Equivalent to the common LibraryManager in C++ and the Go binding helpers.
 */
final class LibraryManager
{
    private static bool $initialized = false;

    private function __construct() {}

    public static function licenseVerify(string $license, string $deviceId = '', string $appId = ''): int
    {
        $ffi = FFIFactory::ffi();
        // CPDF_LicenseVerify always takes char* on every platform.
        return (int) $ffi->CPDF_LicenseVerify($license, $deviceId, $appId);
    }

    /**
     * Initialize after successful license verification. Use an empty path on Linux.
     * The core uses system fonts; load DocumentAI packages separately.
     */
    public static function initialize(string $resourcePath): void
    {
        $ffi = FFIFactory::ffi();

        if (self::isWindows()) {
            $wpath = self::toWString($resourcePath);
            $ffi->CPDF_Initialize($wpath);
        } else {
            $ffi->CPDF_Initialize($resourcePath);
        }

        self::$initialized = true;
    }

    public static function release(): void
    {
        $ffi = FFIFactory::ffi();
        $ffi->CPDF_Release();
        self::$initialized = false;
    }

    public static function setLogger(bool $enableInfo, bool $enableWarning): void
    {
        FFIFactory::ffi()->CPDF_SetLogger($enableInfo, $enableWarning);
    }

    public static function getPageCount(string $filePath, string $password = ''): int
    {
        $ffi = FFIFactory::ffi();
        if (self::isWindows()) {
            return (int) $ffi->CPDF_GetPageCount(self::toWString($filePath), self::toWString($password));
        }
        return (int) $ffi->CPDF_GetPageCount($filePath, $password);
    }

    public static function getRemainingPageQuota(): int
    {
        return (int) FFIFactory::ffi()->CPDF_GetRemainingPageQuota();
    }

    /**
     * Returns the type of the currently verified license (one of {@see LicenseType})
     * without verifying again or consuming page quota.
     */
    public static function getLicenseType(): int
    {
        return (int) FFIFactory::ffi()->CPDF_GetLicenseType();
    }

    /**
     * Load one SDK-matching model package after initialize() and while idle.
     * Successful calls merge capabilities in any order. Failed calls preserve
     * already loaded capabilities. Check every returned ErrorCode: 0 is success,
     * and 60 means conversion or release is in progress.
     *
     * @param string $modelPath Absolute path to a base or extension .model package.
     * @param int    $gpuId     GPU device index; pass -1 to disable GPU.
     */
    public static function setDocumentAIModel(string $modelPath, int $gpuId = -1): int
    {
        $ffi = FFIFactory::ffi();
        if (self::isWindows()) {
            return (int) $ffi->CPDF_SetDocumentAIModel(self::toWString($modelPath), $gpuId);
        }
        return (int) $ffi->CPDF_SetDocumentAIModel($modelPath, $gpuId);
    }

    /**
     * Configure Layout / Table model instance counts while the SDK is idle.
     * Increase the counts to improve throughput when conversions run in parallel.
     */
    public static function setDocumentAIModelCount(int $layoutModelCount, int $tableModelCount): void
    {
        FFIFactory::ffi()->CPDF_SetDocumentAIModelCount($layoutModelCount, $tableModelCount);
    }

    /**
     * Release all loaded DocumentAI packages after all conversions finish,
     * without shutting down the SDK. Load the required packages again through
     * setDocumentAIModel() before using AI features.
     */
    public static function releaseDocumentAIModel(): void
    {
        FFIFactory::ffi()->CPDF_ReleaseDocumentAIModel();
    }

    public static function getVersion(): string
    {
        $ffi = FFIFactory::ffi();
        $buf = $ffi->new('char[64]');
        $ffi->CPDF_GetVersion($buf);
        return FFI::string($buf);
    }

    public static function isInitialized(): bool
    {
        return self::$initialized;
    }

    /**
     * Encode a UTF-8 PHP string as a NUL-terminated UTF-16LE buffer for the
     * Windows wchar_t* APIs and return it as a CData uint16_t array.
     */
    public static function toWString(string $utf8): CData
    {
        $utf16 = mb_convert_encoding($utf8, 'UTF-16LE', 'UTF-8');
        if ($utf16 === false) {
            throw new ConversionException('Failed to convert string to UTF-16LE');
        }
        $bytes   = strlen($utf16);
        $count   = ($bytes / 2) + 1; // +1 for NUL terminator
        $buffer  = FFI::new("uint16_t[$count]", false);
        if ($bytes > 0) {
            FFI::memcpy($buffer, $utf16, $bytes);
        }
        return $buffer;
    }

    public static function isWindows(): bool
    {
        return strtolower(PHP_OS_FAMILY) === 'windows';
    }
}
