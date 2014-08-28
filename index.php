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

if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // retourne la requête telle quelle.
} else {
    $images = getImages("images");

      // display on page
       foreach($images as $img) {
           echo sprintf("<img class='photo' src='%s' %s  alt=''><br>", $img['file'], $img['size'][3]);
       }
}

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

?>
