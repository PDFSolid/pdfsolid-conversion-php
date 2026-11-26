<?php
declare(strict_types=1);

namespace PdfSolidConversion;

/** Type of the currently verified license. */
final class LicenseType
{
    /** No license has been verified, verification failed, or the SDK is releasing. */
    public const UNKNOWN = 0;
    /** Trial license. */
    public const TRIAL = 1;
    /** Formal license. */
    public const FORMAL = 2;
}
