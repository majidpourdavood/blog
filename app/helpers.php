<?php

use App\Model\File;
use Illuminate\Database\Eloquent\Collection;
use Intervention\Image\Facades\Image;

/**
 * Created by PhpStorm.
 * User: majid
 * Date: 01/05/2017
 * Time: 21:08
 */


function uploadFilesModel($method, $model, $array_images)
{

    $allimages = explode(',', $array_images);
    $images = new Collection();
    foreach ($allimages as $key => $value) {
        if ($value != "" && $value !== ',' && $value !== ' ' && $value !== ', ' && $value !== ' , ' && $value !== ' ,' && $value != null) {
            if ($method == "store") {
                $images->push($value);
            }
        }
    }

    $fileMain = $model->files()->where('type', 0)->first();

    if ($method == "store") {
        if (count($images) > 0) {
            foreach ($images as $key => $image) {
                $file = new File();
                if ($key == 0 && !isset($fileMain)) {
                    $file->type = 0;
                } else {
                    $file->type = 2;
                }
                $file->title = "$model->title";
                $file->fileable_id = $model->id;
                $file->fileable_type = get_class($model);
                $file->active = 1;
                $file->user_id = auth()->user()->id;
                $file->file = $image;
                $file->save();
            }
        }
    }

    $BASE_PATH = env('BASE_PATH');

    if ($fileMain) {
        $file_name = time();
        $extension = explode('/', $fileMain->file);
        $image = end($extension);
        $imageExtension = explode('.', $image);
        $extension = end($imageExtension);
        $filename = "{$file_name}.{$extension}";

        $fileMainSrc = url('/') . $fileMain->file;

        if (!config('app.debug')) {
            $thumbnailImage = Image::make($fileMainSrc);
            $thumbnail_smallPath = $BASE_PATH . 'file/thumbnail_small/';
            $thumbnail_mediumPath = $BASE_PATH . 'file/thumbnail_medium/';
            $thumbnailImage->resize(350, 300);
            $thumbnailImage->save($thumbnail_smallPath . $filename);

            $thumbnailImage->resize(800, 500);
            $thumbnailImage->save($thumbnail_mediumPath . $filename);

            $file_small = File::where('type', 4)
                ->where('fileable_id', $fileMain->fileable_id)
                ->where('fileable_type', $fileMain->fileable_type)
                ->first();

            if (isset($file_small)) {
                $file_small->file = '/file/thumbnail_small/' . $filename;
                $file_small->update();
            } else {
                $file = new File();
                $file->type = 4;
                $file->title = "$fileMain->title";
                $file->fileable_id = $fileMain->fileable_id;
                $file->fileable_type = $fileMain->fileable_type;
                $file->active = 1;
                $file->user_id = auth()->user()->id;
                $file->file = '/file/thumbnail_small/' . $filename;
                $file->save();
            }


            $file_medium = File::where('type', 5)
                ->where('fileable_id', $fileMain->fileable_id)
                ->where('fileable_type', $fileMain->fileable_type)
                ->first();

            if (isset($file_medium)) {
                $file_medium->file = '/file/thumbnail_medium/' . $filename;
                $file_medium->update();
            } else {
                $file = new File();
                $file->type = 5;
                $file->title = "$fileMain->title";
                $file->fileable_id = $fileMain->fileable_id;
                $file->fileable_type = $fileMain->fileable_type;
                $file->active = 1;
                $file->user_id = auth()->user()->id;
                $file->file = '/file/thumbnail_medium/' . $filename;
                $file->save();
            }
        }


    }
}

function translate_google($from_lan, $to_lan, $text)
{
    $json = json_decode(file_get_contents('https://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=' . urlencode($text) . '&langpair=' . $from_lan . '|' . $to_lan));
    $translated_text = $json->responseData->translatedText;

    return $translated_text;
}

function translate($key)
{
   $locale = app()->getLocale();
    $translate = \App\Model\Translation::where('key', $key)
        ->where("lang", $locale)
        ->first();
    if (isset($translate)) {
        return $translate->value;
    } else {
        return "";
    }
}

function convert($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    $string = str_replace($english, $persian, $string);

    return $string;
}


function pathUrl($string)
{
    $pathUrl = parse_url($string);
    if (isset($pathUrl['query'])) {
        return $pathUrl['path'] . "?" . $pathUrl['query'];
    } else {
        return $pathUrl['path'];

    }
}

function hex2RGB($hex)
{
    preg_match("/^#{0,1}([0-9a-f]{1,6})$/i", $hex, $match);
    if (!isset($match[1])) {
        return false;
    }

    if (strlen($match[1]) == 6) {
        list($r, $g, $b) = array($hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5]);
    } elseif (strlen($match[1]) == 3) {
        list($r, $g, $b) = array($hex[0] . $hex[0], $hex[1] . $hex[1], $hex[2] . $hex[2]);
    } else if (strlen($match[1]) == 2) {
        list($r, $g, $b) = array($hex[0] . $hex[1], $hex[0] . $hex[1], $hex[0] . $hex[1]);
    } else if (strlen($match[1]) == 1) {
        list($r, $g, $b) = array($hex . $hex, $hex . $hex, $hex . $hex);
    } else {
        return false;
    }

    $color = array();
    $color['r'] = hexdec($r);
    $color['g'] = hexdec($g);
    $color['b'] = hexdec($b);

    return $color;
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}


function _mime_content_type($filename)
{
    $result = new finfo();

    if (is_resource($result) === true) {
        return $result->file($filename, FILEINFO_MIME_TYPE);
    }

    return false;
}


function dateToTimestampMiliSecend($yourdate)
{
    date_default_timezone_set('UTC'); // set timezone
    $stamp = strtotime($yourdate); // get unix timestamp
    return $time_in_ms = $stamp * 1000;
}

function TimestampMiliSecendTodate($Timestamp)
{
    return date("Y-m-d", $Timestamp / 1000);
}


function getAddresses($domain)
{
    $records = dns_get_record($domain);
    $res = array();
    foreach ($records as $r) {
        if ($r['host'] != $domain) continue; // glue entry
        if (!isset($r['type'])) continue; // DNSSec

        if ($r['type'] == 'A') $res[] = $r['ip'];
        if ($r['type'] == 'AAAA') $res[] = $r['ipv6'];
    }
    return $res;
}

function getAddresses_www($domain)
{
    $res = getAddresses($domain);
    if (count($res) == 0) {
        $res = getAddresses('www.' . $domain);
    }
    return $res;
}

// Function to get the client IP address
function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function url_current_dir()
{

    $directory_array = explode("/", $_SERVER['REQUEST_URI']);
    $directory = $directory_array[1];

    return sprintf(
        "%s://%s/%s/",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        // 'ipg_tester'
        // $_SERVER['REQUEST_URI']
        $directory
    );
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function gen_uuid()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function makeHttpChargeRequest($_Method, $_Data, $_Address)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $_Address);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $_Method);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $_Data);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;

}


function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function round_up($value, $precision)
{
    $pow = pow(10, $precision);
    return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
}

function string_limit($string, $count)
{
    substr(strip_tags($string), 0, $count);
    return $string;
}

function randomNumber($length)
{
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(1, 9);
    }
    return $result;
}

if (!function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param string $value
     * @param int $words
     * @param string $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}

function compress($source, $destination, $quality)
{

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}

function list_categories(array $categories)
{
    $data = [];

    foreach ($categories as $category) {
        $data[] = [
            'children' => list_categories($category->childs),
        ];
    }

    return $data;
}


function compress_image($source_file, $target_file, $nwidth, $nheight, $quality)
{
    //Return an array consisting of image type, height, widh and mime type.
    $image_info = getimagesize($source_file);
    if (!($nwidth > 0)) $nwidth = $image_info[0];
    if (!($nheight > 0)) $nheight = $image_info[1];

    if (!empty($image_info)) {
        switch ($image_info['mime']) {
            case 'image/jpeg' :
                if ($quality == '' || $quality < 0 || $quality > 100) $quality = 75; //Default quality
                // Create a new image from the file or the url.
                $image = imagecreatefromjpeg($source_file);
                $thumb = imagecreatetruecolor($nwidth, $nheight);
                //Resize the $thumb image
                imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
                // Output image to the browser or file.
                return imagejpeg($thumb, $target_file, $quality);

                break;

            case 'image/png' :
                if ($quality == '' || $quality < 0 || $quality > 9) $quality = 6; //Default quality
                // Create a new image from the file or the url.
                $image = imagecreatefrompng($source_file);
                $thumb = imagecreatetruecolor($nwidth, $nheight);
                //Resize the $thumb image
                imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
                // Output image to the browser or file.
                return imagepng($thumb, $target_file, $quality);
                break;

            case 'image/gif' :
                if ($quality == '' || $quality < 0 || $quality > 100) $quality = 75; //Default quality
                // Create a new image from the file or the url.
                $image = imagecreatefromgif($source_file);
                $thumb = imagecreatetruecolor($nwidth, $nheight);
                //Resize the $thumb image
                imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
                // Output image to the browser or file.
                return imagegif($thumb, $target_file, $quality); //$success = true;
                break;

            default:
                echo "<h4>Not supported file type!</h4>";
                break;
        }
    }
}

function kamaNumber($num)
{
    $persian_num_array = [
        '0' => '۰',
        '1' => '۱',
        '2' => '۲',
        '3' => '۳',
        '4' => '۴',
        '5' => '۵',
        '6' => '۶',
        '7' => '۷',
        '8' => '۸',
        '9' => '۹',
    ];

    $num = (float)$num;
    return strtr(number_format($num), $persian_num_array);
}
