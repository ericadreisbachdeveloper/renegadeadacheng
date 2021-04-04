WebP Express 0.19.0. Conversion triggered using bulk conversion, 2021-03-07 10:05:41

*WebP Convert 2.3.2*  ignited.
- PHP version: 7.4.9
- Server software: Apache/2.4.46 (Unix) OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13 mod_fastcgi/mod_fastcgi-SNAP-0910052141 mod_perl/2.0.11 Perl/v5.30.1

Stack converter ignited

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp
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
- source: [doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp
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
Quality of source is 82. This is higher than max-quality, so using max-quality instead (80)
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice cwebp -metadata none -q 80 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp.lossy.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 80 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp.lossy.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp.lossy.webp'
File:      [doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg
Dimension: 545 x 200
Output:    20528 bytes Y-U-V-All-PSNR 40.15 40.66 40.40   40.27 dB
block count:  intra4: 335
              intra16: 120  (-> 26.37%)
              skipped block: 97 (21.32%)
bytes used:  header:            274  (1.3%)
             mode-partition:   1843  (9.0%)
 Residuals bytes  |segment 1|segment 2|segment 3|segment 4|  total
  intra4-coeffs:  |   12519 |     236 |     140 |      11 |   12906  (62.9%)
 intra16-coeffs:  |     131 |      19 |      24 |       3 |     177  (0.9%)
  chroma coeffs:  |    5063 |     125 |     100 |      15 |    5303  (25.8%)
    macroblocks:  |      72%|       5%|       4%|      17%|     455
      quantizer:  |      23 |      17 |      12 |      11 |
   filter level:  |       7 |       4 |       2 |       0 |
------------------+---------+---------+---------+---------+-----------------
 segments total:  |   17713 |     380 |     264 |      29 |   18386  (89.6%)

Success
Reduction: 25% (went from 27 kb to 20 kb)

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
nice cwebp -metadata none -q 80 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp.lossless.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 80 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp.lossless.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg.webp.lossless.webp'
File:      [doc-root]/adacheng/wp-content/uploads/2021/03/ada-cheng-storyteller-headshot-545x200.jpg
Dimension: 545 x 200
Output:    93600 bytes
Lossless-ARGB compressed size: 93600 bytes
  * Header size: 2553 bytes, image data size: 91022
  * Lossless features used: PREDICTION CROSS-COLOR-TRANSFORM SUBTRACT-GREEN
  * Precision Bits: histogram=3 transform=3 cache=0

Success
Reduction: -241% (went from 27 kb to 91 kb)

Picking lossy
cwebp succeeded :)

Converted image in 716 ms, reducing file size with 25% (went from 27 kb to 20 kb)
