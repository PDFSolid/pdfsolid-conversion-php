<?php
declare(strict_types=1);

namespace PdfSolidConversion;

/** How Word to PDF generates PDF bookmarks. */
final class WordPdfBookmarkMode
{
    public const NONE = 0;
    public const HEADINGS = 1;
    public const WORD_BOOKMARKS = 2;
}
