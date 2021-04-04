WebP Express 0.19.0. Conversion triggered using bulk conversion, 2021-03-18 19:50:11

*WebP Convert 2.3.2*  ignited.
- PHP version: 7.4.9
- Server software: Apache/2.4.46 (Unix) OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13 mod_fastcgi/mod_fastcgi-SNAP-0910052141 mod_perl/2.0.11 Perl/v5.30.1

Stack converter ignited

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp
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
- source: [doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp
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
nice cwebp -metadata none -q 80 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp.lossy.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 80 -alpha_q '85' -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp.lossy.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp.lossy.webp'
File:      [doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg
Dimension: 700 x 200
Output:    12612 bytes Y-U-V-All-PSNR 41.59 44.12 44.89   42.36 dB
block count:  intra4: 319
              intra16: 253  (-> 44.23%)
              skipped block: 99 (17.31%)
bytes used:  header:            207  (1.6%)
             mode-partition:   1515  (12.0%)
 Residuals bytes  |segment 1|segment 2|segment 3|segment 4|  total
  intra4-coeffs:  |    7980 |      59 |      66 |      28 |    8133  (64.5%)
 intra16-coeffs:  |     119 |      46 |      36 |     138 |     339  (2.7%)
  chroma coeffs:  |    2130 |      46 |     109 |     106 |    2391  (19.0%)
    macroblocks:  |      55%|       4%|       6%|      33%|     572
      quantizer:  |      26 |      20 |      13 |      11 |
   filter level:  |       8 |       5 |       3 |       8 |
------------------+---------+---------+---------+---------+-----------------
 segments total:  |   10229 |     151 |     211 |     272 |   10863  (86.1%)

Success
Reduction: 42% (went from 21 kb to 12 kb)

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
nice cwebp -metadata none -q 80 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp.lossless.webp' 2>&1 2>&1

*Output:* 
nice: cwebp: No such file or directory

Exec failed (return code: 127)
Creating command line options for version: 0.5.1
Trying to convert by executing the following command:
nice /usr/local/bin/cwebp -metadata none -q 80 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg' -o '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp.lossless.webp' 2>&1 2>&1

*Output:* 
Saving file '[doc-root]/adacheng/wp-content/webp-express/webp-images/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg.webp.lossless.webp'
File:      [doc-root]/adacheng/wp-content/uploads/2021/03/170830-the-moth-joker-ada-cheng-700x200.jpg
Dimension: 700 x 200
Output:    69810 bytes
Lossless-ARGB compressed size: 69810 bytes
  * Header size: 3092 bytes, image data size: 66692
  * Lossless features used: PREDICTION CROSS-COLOR-TRANSFORM SUBTRACT-GREEN
  * Precision Bits: histogram=3 transform=3 cache=10

Success
Reduction: -220% (went from 21 kb to 68 kb)

Picking lossy
cwebp succeeded :)

Converted image in 850 ms, reducing file size with 42% (went from 21 kb to 12 kb)
