WebP Express 0.19.0. Conversion triggered using bulk conversion, 2021-02-19 19:04:22

*WebP Convert 2.3.2*  ignited.
- PHP version: 7.4.9
- Server software: Apache/2.4.46 (Unix) OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13 mod_fastcgi/mod_fastcgi-SNAP-0910052141 mod_perl/2.0.11 Perl/v5.30.1

Stack converter ignited
Destination folder does not exist. Creating folder: [doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/uploads/2021/02/logo.png
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp
- log-call-arguments: true
- converters: (array of 10 items)

The following options have not been explicitly set, so using the following defaults:
- converter-options: (empty array)
- shuffle: false
- preferred-converters: (empty array)
- extra-converters: (empty array)

The following options were supplied and are passed on to the converters in the stack:
- alpha-quality: 80
- encoding: "auto"
- metadata: "none"
- near-lossless: 60
- quality: 85
------------


*Trying: cwebp* 

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/uploads/2021/02/logo.png
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp
- alpha-quality: 80
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
nice cwebp -metadata none -q 85 -alpha_q '80' -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/02/logo.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp.lossy.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 85 -alpha_q '80' -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/02/logo.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp.lossy.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp.lossy.webp'
File:      [doc-root]/adacheng/wp-content/uploads/2021/02/logo.png
Dimension: 173 x 76 (with alpha)
Output:    2222 bytes Y-U-V-All-PSNR 60.21 52.74 52.22   55.98 dB
block count:  intra4: 3
              intra16: 52  (-> 94.55%)
              skipped block: 46 (83.64%)
bytes used:  header:             24  (1.1%)
             mode-partition:     52  (2.3%)
             transparency:     1989 (99.0 dB)
 Residuals bytes  |segment 1|segment 2|segment 3|segment 4|  total
  intra4-coeffs:  |      17 |       0 |       0 |       0 |      17  (0.8%)
 intra16-coeffs:  |      11 |       0 |       1 |       1 |      13  (0.6%)
  chroma coeffs:  |      49 |       0 |      15 |       5 |      69  (3.1%)
    macroblocks:  |      40%|       3%|       1%|      54%|      55
      quantizer:  |      20 |      15 |      13 |       8 |
   filter level:  |       7 |       3 |       2 |       0 |
------------------+---------+---------+---------+---------+-----------------
 segments total:  |      77 |       0 |      16 |       6 |      99  (4.5%)
Lossless-alpha compressed size: 1988 bytes
  * Header size: 57 bytes, image data size: 1931
  * Lossless features used: PALETTE
  * Precision Bits: histogram=3 transform=3 cache=0
  * Palette size:   86

Success
Reduction: 56% (went from 5056 bytes to 2222 bytes)

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
nice cwebp -metadata none -q 85 -alpha_q '80' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/02/logo.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp.lossless.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 85 -alpha_q '80' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/02/logo.png' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp.lossless.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/02/logo.png.webp.lossless.webp'
File:      [doc-root]/adacheng/wp-content/uploads/2021/02/logo.png
Dimension: 173 x 76
Output:    2230 bytes
Lossless-ARGB compressed size: 2230 bytes
  * Header size: 88 bytes, image data size: 2117
  * Lossless features used: PALETTE
  * Precision Bits: histogram=3 transform=3 cache=0
  * Palette size:   171

Success
Reduction: 56% (went from 5056 bytes to 2230 bytes)

Picking lossy
cwebp succeeded :)

Converted image in 412 ms, reducing file size with 56% (went from 5056 bytes to 2222 bytes)
