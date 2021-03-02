WebP Express 0.19.0. Conversion triggered using bulk conversion, 2021-03-01 16:11:49

Converter set to: imagemagick

*WebP Convert 2.3.2*  ignited.
- PHP version: 7.4.9
- Server software: Apache/2.4.46 (Unix) OpenSSL/1.0.2u mod_wsgi/3.5 Python/2.7.13 mod_fastcgi/mod_fastcgi-SNAP-0910052141 mod_perl/2.0.11 Perl/v5.30.1

ImageMagick converter ignited
Destination folder does not exist. Creating folder: [doc-root]/adacheng/wp-content/webp-express/webp-images/plugins/webp-express/test

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/adacheng/wp-content/plugins/webp-express/test/alphatest.png
- destination: [doc-root]/adacheng/wp-content/webp-express/webp-images/plugins/webp-express/test/alphatest.png.webp
- alpha-quality: 85
- encoding: "auto"
- log-call-arguments: true
- metadata: "none"
- quality: 85
- use-nice: true

The following options have not been explicitly set, so using the following defaults:
- auto-filter: false
- default-quality: 85
- low-memory: false
- max-quality: 85
- method: 6
- skip: false

The following options were supplied but are ignored because they are not supported by this converter:
- near-lossless
------------

Encoding is set to auto - converting to both lossless and lossy and selecting the smallest file

Converting to lossy
Version: ImageMagick 6.9.5-9 Q16 x86_64 2016-09-11 http://www.imagemagick.org
Quality: 85. 
using nice
Executing command: nice convert -quality '85' -strip -define webp:alpha-quality=85 -define webp:method=6 '[doc-root]/adacheng/wp-content/plugins/webp-express/test/alphatest.png' 'webp:[doc-root]/adacheng/wp-content/webp-express/webp-images/plugins/webp-express/test/alphatest.png.webp.lossy.webp' 2>&1

*Output:* 
nice: convert: No such file or directory

return code: 127

**Error: ** **imagemagick is not installed** 
