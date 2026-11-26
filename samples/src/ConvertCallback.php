<?php
declare(strict_types=1);

namespace PdfSolidConversion;

use FFI;
use FFI\CData;

/**
 * High-level holder for the optional native callbacks accepted by every
 * native conversion function. Equivalent to the C `CConvertCallback` struct
 * (see `pdfsolid_config_macros.h` in the SDK release headers).
 *
 * Set AI trigger/result callbacks in pairs; unset AI pairs restore the
 * built-in behaviour. Progress and cancellation are independently optional.
 *
 * Signatures (all PHP callables):
 * - $onProgress    : function (int $currentPage, int $totalPage): void
 * - $onCancel      : function (): bool                    // true cancels the job
 * - $onOcr         : function (string $imagePath): bool   // true delegates OCR to caller
 * - $onOcrResult   : function (): ?string                  // JSON for the last image
 * - $onLayout      : function (string $imagePath): bool
 * - $onLayoutResult: function (): ?string
 * - $onTable       : function (string $imagePath): bool
 * - $onTableResult : function (): ?string
 *
 * All callbacks are invoked synchronously from the same OS thread that called
 * the conversion function — PHP FFI does not support cross-thread callbacks.
 */
final class ConvertCallback
{
    /** @var callable|null */ public $onProgress = null;
    /** @var callable|null */ public $onCancel = null;
    /** @var callable|null */ public $onOcr = null;
    /** @var callable|null */ public $onOcrResult = null;
    /** @var callable|null */ public $onLayout = null;
    /** @var callable|null */ public $onLayoutResult = null;
    /** @var callable|null */ public $onTable = null;
    /** @var callable|null */ public $onTableResult = null;

    /** @var array<int,mixed> Trampolines kept alive for the SDK call. */
    private array $_keepAlive = [];

    /** @var array<string,CData> char[] buffers returned by get_*_result hooks. */
    private array $_resultBuffers = [];

    private ?\Throwable $_error = null;

    /** Rethrow only after the synchronous native conversion returns. */
    public function throwPendingException(): void
    {
        if ($this->_error !== null) {
            throw $this->_error;
        }
    }

    /** Release per-call buffers and break trampoline reference cycles. */
    public function releaseNativeResources(): void
    {
        $this->_keepAlive = [];
        $this->_resultBuffers = [];
    }

    private function invoke($callable, array $args, $fallback)
    {
        if ($this->_error !== null) {
            return $fallback;
        }
        try {
            return $callable(...$args);
        } catch (\Throwable $error) {
            $this->_error = $error;
            return $fallback;
        }
    }

    /**
     * Build a native `CConvertCallback` cdata. The PHP caller MUST keep both
     * the returned cdata and this ConvertCallback instance reachable until
     * the conversion call returns; otherwise the trampolines may be GC'd
     * mid-call and the SDK will crash.
     */
    public function buildCData(FFI $ffi): CData
    {
        foreach ([['onOcr', 'onOcrResult'], ['onLayout', 'onLayoutResult'], ['onTable', 'onTableResult']] as $pair) {
            if (($this->{$pair[0]} === null) !== ($this->{$pair[1]} === null)) {
                throw new \InvalidArgumentException('Custom AI callbacks require both trigger and result');
            }
        }
        // Reset state for a fresh native call.
        $this->_error = null;
        $this->_keepAlive = [];
        $this->_resultBuffers = [];

        $cb = $ffi->new('CConvertCallback');
        $cb->handle = null;
        $cb->cancel = null;
        $cb->progress = null;
        $cb->ocr = null;
        $cb->layout = null;
        $cb->table = null;
        $cb->get_ocr_result = null;
        $cb->get_layout_result = null;
        $cb->get_table_result = null;

        if ($this->onProgress !== null) {
            $fn = $this->onProgress;
            $t = function (int $current, int $total) use ($fn): void {
                $this->invoke($fn, [$current, $total], null);
            };
            $cb->progress = $t;
            $this->_keepAlive[] = $t;
        }

        // Always allow an exception in another hook to request cancellation.
        $fn = $this->onCancel;
        $t = function () use ($fn): bool {
            $cancel = $fn !== null ? (bool) $this->invoke($fn, [], true) : false;
            return $cancel || $this->_error !== null;
        };
        $cb->cancel = $t;
        $this->_keepAlive[] = $t;

        $this->bindTrigger($cb, 'ocr', $this->onOcr);
        $this->bindTrigger($cb, 'layout', $this->onLayout);
        $this->bindTrigger($cb, 'table', $this->onTable);

        $this->bindResult($cb, 'get_ocr_result', $this->onOcrResult);
        $this->bindResult($cb, 'get_layout_result', $this->onLayoutResult);
        $this->bindResult($cb, 'get_table_result', $this->onTableResult);

        return $cb;
    }

    private function bindTrigger(CData $cb, string $field, $callable): void
    {
        if ($callable === null) {
            return;
        }
        $t = function ($imagePath) use ($callable): bool {
            $path = is_string($imagePath) ? $imagePath : ($imagePath === null ? '' : FFI::string($imagePath));
            return $this->invoke(function () use ($callable, $path): bool {
                $value = $callable($path);
                if (!is_bool($value)) {
                    throw new \UnexpectedValueException('AI trigger callback must return a boolean');
                }
                return $value;
            }, [], false);
        };
        $cb->{$field} = $t;
        $this->_keepAlive[] = $t;
    }

    private function bindResult(CData $cb, string $field, $callable): void
    {
        if ($callable === null) {
            return;
        }
        $t = function () use ($callable, $field): ?CData {
            return $this->invoke(function () use ($callable, $field): ?CData {
                $json = $callable();
                unset($this->_resultBuffers[$field]);
                if ($json === null) {
                    return null;
                }
                if (!is_string($json) || strpos($json, "\0") !== false) {
                    throw new \UnexpectedValueException('AI result callback must return a JSON string without NUL bytes or null');
                }
                $len = strlen($json);
                $buf = FFI::new('char[' . ($len + 1) . ']');
                if ($len > 0) {
                    FFI::memcpy($buf, $json, $len);
                }
                $buf[$len] = "\0";
                $this->_resultBuffers[$field] = $buf;
                return FFI::cast('const char*', FFI::addr($buf[0]));
            }, [], null);
        };
        $cb->{$field} = $t;
        $this->_keepAlive[] = $t;
    }
}
