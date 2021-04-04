WebP Express 0.19.0. Conversion triggered with the conversion script (wod/webp-on-demand.php), 2021-03-18 14:40:52

*WebP Convert 2.3.2*  ignited.
- PHP version: 7.4.9
- Server software: Apache/2.4.46 (Unix) OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13 mod_fastcgi/mod_fastcgi-SNAP-0910052141 mod_perl/2.0.11 Perl/v5.30.1

Stack converter ignited
Destination folder does not exist. Creating folder: [doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp
- log-call-arguments: true
- converters: (array of 10 items)

The following options have not been explicitly set, so using the following defaults:
- converter-options: (empty array)
- shuffle: false
- preferred-converters: (empty array)
- extra-converters: (empty array)

The following options were supplied and are passed on to the converters in the stack:
- default-quality: 70
- encoding: "auto"
- max-quality: 80
- metadata: "none"
- near-lossless: 60
- quality: "auto"
------------


*Trying: cwebp* 

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp
- default-quality: 70
- encoding: "auto"
- low-memory: true
- log-call-arguments: true
- max-quality: 80
- metadata: "none"
- method: 6
- near-lossless: 60
- quality: "auto"
- use-nice: true
- command-line-options: ""
- try-common-system-paths: true
- try-supplied-binary-for-os: true

The following options have not been explicitly set, so using the following defaults:
- alpha-quality: 85
- auto-filter: false
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
Quality of source is 85. This is higher than max-quality, so using max-quality instead (80)
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice cwebp -metadata none -q 80 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp.lossy.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 80 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp.lossy.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp.lossy.webp'
File:      [doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg
Dimension: 1200 x 800
Output:    42090 bytes Y-U-V-All-PSNR 44.73 51.78 50.59   46.02 dB
block count:  intra4: 1780
              intra16: 1970  (-> 52.53%)
              skipped block: 183 (4.88%)
bytes used:  header:            254  (0.6%)
             mode-partition:   4988  (11.9%)
 Residuals bytes  |segment 1|segment 2|segment 3|segment 4|  total
  intra4-coeffs:  |   16974 |    2585 |     199 |     101 |   19859  (47.2%)
 intra16-coeffs:  |    9836 |    3203 |    1671 |     557 |   15267  (36.3%)
  chroma coeffs:  |    1174 |     281 |     177 |      63 |    1695  (4.0%)
    macroblocks:  |      61%|      17%|       8%|      12%|    3750
      quantizer:  |      23 |      17 |      12 |      11 |
   filter level:  |      10 |       8 |       9 |       5 |
------------------+---------+---------+---------+---------+-----------------
 segments total:  |   27984 |    6069 |    2047 |     721 |   36821  (87.5%)

Success
Reduction: 3% (went from 43 kb to 41 kb)

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
nice cwebp -metadata none -q 80 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp.lossless.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 80 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp.lossless.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/themes/rac-theme/img/paper-bg.jpg.webp.lossless.webp'
File:      [doc-root]/adacheng/wp-content/themes/rac-theme/img/paper-bg.jpg
Dimension: 1200 x 800
Output:    300392 bytes
Lossless-ARGB compressed size: 300392 bytes
  * Header size: 3114 bytes, image data size: 297252
  * Lossless features used: PREDICTION CROSS-COLOR-TRANSFORM SUBTRACT-GREEN
  * Precision Bits: histogram=5 transform=4 cache=10

Success
Reduction: -589% (went from 43 kb to 293 kb)

Picking lossy
cwebp succeeded :)

Converted image in 2829 ms, reducing file size with 3% (went from 43 kb to 41 kb)
