<?php
/**
 * Short description for index.php
 *
 * @package index
 * @author ronan <ronan@raspberrypi>
 * @version 0.1
 * @copyright (C) 2014 ronan <ronan@raspberrypi>
 * @license MIT
 */

// Router:
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // image file is returned.
} else {
    $images = getImages("images");

      // display on page
       foreach($images as $img) {
           echo sprintf("<img class='photo' src='%s' %s  alt=''><br>", $img['file'], $img['size'][3]);
       }
}

// Media provider
function getImages($dir)
{
    $imagetypes = array("image/jpeg", "image/gif");

    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // full server path to directory
    $fulldir = "{$_SERVER['DOCUMENT_ROOT']}/$dir";

    $d = @dir($fulldir) or die("getImages: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
        // skip hidden files
        if($entry[0] == ".") continue;

        // check for image files
        $f = escapeshellarg("$fulldir$entry");
        $mimetype = trim(`file -bi $f`);
        foreach($imagetypes as $valid_type) {
            if(preg_match("@^{$valid_type}@", $mimetype)) {
                $retval[] = array(
                    'file' => "/$dir$entry",
                    'size' => getimagesize("$fulldir$entry")
                );
                break;
            }
        }
    }
    $d->close();

    return $retval;
}

function getSunTimes()
{

    // See http://php.net/manual/fr/function.date-sunrise.php
    // See http://php.net/manual/fr/function.date-sunset.php
    // See http://php.net/manual/fr/function.date-sun-info.php
    
    $lat = 47.2168424;  // Nantes, France
    $long = -1.5567445; // Nantes, France
    $today = date("D M d Y");
    $zenith = 90+(50/60); // Hypothetical
    $gmtOffset = 2;     // Central European Summer Timezone
    
    $sunrise = date_sunrise(time(), SUNFUNCS_RET_STRING, $lat, $long, $zenith, $gmtOffset);
    $sunset = date_sunset(time(), SUNFUNCS_RET_STRING, $lat, $long, $zenith, $gmtOffset);
    echo sprintf("Today %s, sunrise at %s and sunset at %s", $today, $sunrise, $sunset);
    
    $sun_info = date_sun_info(time(), $lat, $long);
    foreach ($sun_info as $key => $val) {
          echo "\n$key: " . date("H:i:s", $val) . "\n";
    }
}
}

?>
