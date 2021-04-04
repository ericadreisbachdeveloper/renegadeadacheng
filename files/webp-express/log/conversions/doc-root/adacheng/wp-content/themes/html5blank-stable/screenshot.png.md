WebP Express 0.19.0. Conversion triggered with the conversion script (wod/webp-on-demand.php), 2021-03-19 09:05:13

*WebP Convert 2.3.2*  ignited.
- PHP version: 7.4.9
- Server software: Apache/2.4.46 (Unix) OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13 mod_fastcgi/mod_fastcgi-SNAP-0910052141 mod_perl/2.0.11 Perl/v5.30.1

Stack converter ignited
Destination folder does not exist. Creating folder: [doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp
- log-call-arguments: true
- converters: (array of 10 items)

The following options have not been explicitly set, so using the following defaults:
- converter-options: (empty array)
- shuffle: false
- preferred-converters: (empty array)
- extra-converters: (empty array)

The following options were supplied and are passed on to the converters in the stack:
- alpha-quality: 85
- encoding: "auto"
- metadata: "none"
- near-lossless: 60
- quality: 85
------------


*Trying: cwebp* 

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp
- alpha-quality: 85
- encoding: "auto"
- low-memory: true
- log-call-arguments: true
- metadata: "none"
- method: 6
- near-lossless: 60
- quality: 85
- use-nice: true
- command-line-options: ""
- try-common-system-paths: true
- try-supplied-binary-for-os: true

The following options have not been explicitly set, so using the following defaults:
- auto-filter: false
- default-quality: 85
- max-quality: 85
- preset: "none"
- size-in-percentage: null (not set)
- skip: false
- rel-path-to-precompiled-binaries: *****
- try-cwebp: true
- try-discovering-cwebp: true
------------

Encoding is set to auto - converting to both lossless and lossy and selecting the smallest file

Converting to lossy
Looking for cwebp binaries.
Discovering if a plain cwebp call works (to skip this step, disable the "try-cwebp" option)
- Executing: cwebp -version 2>&1. Result: version: *0.5.1*
We could get the version, so yes, a plain cwebp call works
Discovering binaries using "which -a cwebp" command. (to skip this step, disable the "try-discovering-cwebp" option)
Found 0 binaries
Discovering binaries by peeking in common system paths (to skip this step, disable the "try-common-system-paths" option)
Found 1 binaries: 
- /usr/local/bin/cwebp
Discovering binaries which are distributed with the webp-convert library (to skip this step, disable the "try-supplied-binary-for-os" option)
Checking if we have a supplied precompiled binary for your OS (Darwin)... We do.
Found 1 binaries: 
- [doc-root]/adacheng/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-110-mac-10_15
Detecting versions of the cwebp binaries found
- Executing: cwebp -version 2>&1. Result: version: *0.5.1*
- Executing: /usr/local/bin/cwebp -version 2>&1. Result: version: *0.5.1*
- Executing: [doc-root]/adacheng/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-110-mac-10_15 -version 2>&1. Result: *Exec failed*. Permission denied (user: "erica" does not have permission to execute that binary)
Binaries ordered by version number.
- cwebp: (version: 0.5.1)
- /usr/local/bin/cwebp: (version: 0.5.1)
Trying the first of these. If that should fail (it should not), the next will be tried and so on.
Creating command line options for version: 0.5.1
Quality: 85. 
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice cwebp -metadata none -q 85 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp.lossy.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 85 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp.lossy.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp.lossy.webp'
File:      [doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png
Dimension: 300 x 225
Output:    4476 bytes Y-U-V-All-PSNR 45.88 49.98 45.99   46.37 dB
block count:  intra4: 159
              intra16: 126  (-> 44.21%)
              skipped block: 6 (2.11%)
bytes used:  header:            145  (3.2%)
             mode-partition:    739  (16.5%)
 Residuals bytes  |segment 1|segment 2|segment 3|segment 4|  total
  intra4-coeffs:  |    2376 |       0 |      19 |      59 |    2454  (54.8%)
 intra16-coeffs:  |      24 |       9 |      28 |     165 |     226  (5.0%)
  chroma coeffs:  |     540 |       5 |      47 |     291 |     883  (19.7%)
    macroblocks:  |      29%|       1%|       7%|      62%|     285
      quantizer:  |      20 |      16 |      14 |      10 |
   filter level:  |       7 |       4 |       3 |       5 |
------------------+---------+---------+---------+---------+-----------------
 segments total:  |    2940 |      14 |      94 |     515 |    3563  (79.6%)

Success
Reduction: 92% (went from 54 kb to 4 kb)

Converting to lossless
Looking for cwebp binaries.
Discovering if a plain cwebp call works (to skip this step, disable the "try-cwebp" option)
- Executing: cwebp -version 2>&1. Result: version: *0.5.1*
We could get the version, so yes, a plain cwebp call works
Discovering binaries using "which -a cwebp" command. (to skip this step, disable the "try-discovering-cwebp" option)
Found 0 binaries
Discovering binaries by peeking in common system paths (to skip this step, disable the "try-common-system-paths" option)
Found 1 binaries: 
- /usr/local/bin/cwebp
Discovering binaries which are distributed with the webp-convert library (to skip this step, disable the "try-supplied-binary-for-os" option)
Checking if we have a supplied precompiled binary for your OS (Darwin)... We do.
Found 1 binaries: 
- [doc-root]/adacheng/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-110-mac-10_15
Detecting versions of the cwebp binaries found
- Executing: cwebp -version 2>&1. Result: version: *0.5.1*
- Executing: /usr/local/bin/cwebp -version 2>&1. Result: version: *0.5.1*
- Executing: [doc-root]/adacheng/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-110-mac-10_15 -version 2>&1. Result: *Exec failed*. Permission denied (user: "erica" does not have permission to execute that binary)
Binaries ordered by version number.
- cwebp: (version: 0.5.1)
- /usr/local/bin/cwebp: (version: 0.5.1)
Trying the first of these. If that should fail (it should not), the next will be tried and so on.
Creating command line options for version: 0.5.1
Trying to convert by executing the following command:
nice cwebp -metadata none -q 85 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp.lossless.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 85 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp.lossless.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/html5blank-stable/screenshot.png.webp.lossless.webp'
File:      [doc-root]/adacheng/wp-content/themes/html5blank-stable/screenshot.png
Dimension: 300 x 225
Output:    40484 bytes
Lossless-ARGB compressed size: 40484 bytes
  * Header size: 2151 bytes, image data size: 38307
  * Lossless features used: PREDICTION CROSS-COLOR-TRANSFORM SUBTRACT-GREEN
  * Precision Bits: histogram=3 transform=3 cache=8

Success
Reduction: 26% (went from 54 kb to 40 kb)

Picking lossy
cwebp succeeded :)

Converted image in 702 ms, reducing file size with 92% (went from 54 kb to 4 kb)
