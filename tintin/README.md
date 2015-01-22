TinTin Image Resizer
=========

**TinTin Image Resizer**
Version: 1.1
Author: Ciprian Popescu

This PHP script resizes images, intelligently sharpens, crops based on width:height ratios, and caches variations for optimal performance.

TinTin uses the GD library to create thumbnails from images (JPEG, PNG, GIF) on the fly. The output size is configurable (can be larger or smaller than the source), and the source may be the entire image or only a portion of the original image. True color and resampling is used. Cropping and quality controls are available.

Required parameters
-

- **i** (absolute path of local image starting with "/" (e.g. /images/toast.jpg))
- **w** (maximum width of final image in pixels (e.g. 700))
- **h** (maximum height of final image in pixels (e.g. 700))
- **q** (optional, 0-100, default: 90) quality of output image
- **nocache** (optional) does not read image from the cache

Example
-

Resizing a JPEG:
`<img src="tintin.php?i=/images/image.jpg&amp;w=100&amp;h=100&amp;q=100" alt="">`

License
-

MIT
