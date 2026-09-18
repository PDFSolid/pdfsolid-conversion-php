#!/usr/bin/env bash
set -euo pipefail
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LIB_DIR="${SCRIPT_DIR}/../lib/linux"
"${CC:-gcc}" -std=c11 -O2 -Wall -Wextra -Werror -shared -fPIC -fvisibility=hidden \
  -I "${SCRIPT_DIR}/include" "${SCRIPT_DIR}/php_shim.c" \
  -L "${LIB_DIR}" -lpdfsolidconversionsdk '-Wl,-rpath,$ORIGIN' \
  -Wl,-z,defs -Wl,-soname,libcompdf_php_shim.so \
  -o "${LIB_DIR}/libcompdf_php_shim.so"
