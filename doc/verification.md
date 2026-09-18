# Package verification

## Native library refresh (2026-09-18, 10:57 build)

The packaged SDK was replaced with the newly built `out/release/libpdfsolidconversionsdk.so`.
Its SHA-256 is `83627113dd22dca94b50249af63eed8628b343b6639fdcc4d15703ee2b881269`.
The packaged PHP launcher loads this library and reports SDK version 1.2.0.
The earlier conversion results below remain historical results; the full
conversion suite was not rerun for this library-only refresh.

## Native library refresh (2026-09-17, 18:14 build)

The packaged SDK was replaced with the newly built `out/release/libpdfsolidconversionsdk.so`.
Its SHA-256 is `98796959298a33223f80f2bd3ea6fa774168114d3a59b4432ccc93274879e953`.
Loading through the packaged PHP launcher succeeds and reports SDK version 1.2.0.
The conversion results and native-library hashes below describe the initial
package verification before this replacement; they are retained as history.

## Initial package verification

Tested on 2026-09-17 with PHP 7.4.3 CLI, FFI, Linux x86_64, glibc 2.31.
The SDK reports version 1.2.0.

## Input provenance

The packaged SDK and DocumentAI libraries are byte-for-byte copies of the
files supplied under `out/release`. ONNX Runtime and OpenCV are also copied
from that directory. OpenCV is a real file under its required SONAME,
`libopencv_world.so.410`, with no dependency on the source-tree symlink.

| Input | SHA-256 |
| --- | --- |
| `out/release/libpdfsolidconversionsdk.so` | `2c81ed1e76e160d753e287989a0bf74bf59004f84a5ab7aedee2a0ae53026267` |
| `out/release/libDocumentAI.so.4.0.0` | `160e8e76e9f890c6425abc4c42defeec7f511bac3b849b001c861280916d963d` |
| `PDFSolid_Conversion_linux_c_1_2_0/resource/models/documentai.model` | `0b94fb85bc5c63eb332910d94031295ea550287ca090e96df8b4b1a700af527d` |

Process memory maps confirmed that all five native libraries were loaded from
this package's `lib/linux`, with external SDK library paths removed from the
test environment.

## Results

- C and PHP agree on the 576-byte option structure, 72-byte callback structure,
  selected field offsets, and DocumentAI result structure sizes.
- All 12 sample conversion cases returned success: Word, Excel, PPT, CSV,
  HTML, RTF, image, TXT, JSON, Markdown, searchable PDF with OCR, and OFD.
- The supplied DocumentAI model loaded successfully on CPU.
- Word conversion with AI layout and table recognition enabled succeeded.
- Progress callbacks were received and cancellation returned code 1.
- Every packaged PHP file passed `php -l`.

`unzip -t` reports mismatched UTF-8 flags between local and central ZIP headers
in the generated DOCX/PPTX files. Every compressed entry passed its CRC check;
the report is about ZIP metadata consistency. The supplied native SDK is
packaged unchanged. This packaging pass does not repair the native ZIP writer.

Detailed logs are in `verification_logs/`.

These are package and interface smoke tests. They do not measure visual layout
fidelity or validate every OCR language or model capability. Orientation
classification and dewarp fields were checked for ABI compatibility; their
inference behavior was not exercised.
