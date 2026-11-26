#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")"
mkdir -p ../output_files
cd ../..
exec bash samples/pdfsolidphp -d ffi.enable=true samples/direct_convert_demo.php --suite office "$@"
