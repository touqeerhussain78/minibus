<?php


use Intervention\Image\Image;
use Carbon\Carbon;
//use DB;

if(! function_exists('operator_rating'))
{
    function operator_rating($id)
    {
        $rating = DB::select("SELECT IFNULL(AVG(rating), 0) as rating FROM `operator_ratings` WHERE `operator_id` =".$id."");
        return $rating[0]->rating;
    }
}

if(! function_exists('get_rating_by_id'))
{
    function get_rating_by_id($id)
    {
        $rating = DB::select("SELECT IFNULL(rating, 0) as rating FROM `operator_ratings` WHERE `id` =".$id."");
        return $rating[0]->rating;
    }
}

if(! function_exists('diff_in_hours'))
{
    function diff_in_hours($from)
    {
        $from = Carbon::parse($from);
        $to = Carbon::now();
        $diff_in_hours = $to->diffInHours($from);
        return $diff_in_hours;
    }
}

if(! function_exists('check_old_date'))
{
    function check_old_date($from)
    {
        $from = new DateTime($from);
        $to = new DateTime();
        if($from < $to) {
            return true;
        }
        return false;
    }
}

if(! function_exists('upload_base_64_image'))
{
    function upload_base_64_image($image, $path = '', $name = null)
    {
        if(! $image || empty($image))
            return;

        $name = $name?? time();

        list($type, $image) = explode(';', $image);
        list(, $extension) = explode('/', $type);
        list(, $image)      = explode(',', $image);

        $filename = sprintf('images/%s/%s.%s', trim($path, '/'), $name, $extension);

//        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, base64_decode($image));

        $img = \Intervention\Image\Facades\Image::make($image);

        $img->encode('jpg', 50);

        try{
            chmod(storage_path(sprintf('app/public/images/%s', trim($path, '/'))), 0777);
        }catch(\Exception $e){}


        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })
            ->save(storage_path(sprintf('app/public/images/%s/', trim($path, '/'))) . $name . '.' . $extension, 75);

        return $filename;
    }
}

if(! function_exists('validate_input'))
{
    function validate_input($roles, $messages = [])
    {
        $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), $roles, $messages);

        // dd($validator->errors()->toArray());

        return ! $validator->fails();
    }
}

if(! function_exists('HTMLToRGB'))
{
    function HTMLToRGB($htmlCode)
    {
        if($htmlCode[0] == '#')
            $htmlCode = substr($htmlCode, 1);

        if (strlen($htmlCode) == 3)
        {
            $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
        }

        $r = hexdec($htmlCode[0] . $htmlCode[1]);
        $g = hexdec($htmlCode[2] . $htmlCode[3]);
        $b = hexdec($htmlCode[4] . $htmlCode[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }
}


if(! function_exists('RGBToHSL'))
{
    function RGBToHSL($RGB) {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC)
        {
            $s = 0;
            $h = 0;
        }
        else
        {
            if($l < .5)
            {
                $s = ($maxC - $minC) / ($maxC + $minC);
            }
            else
            {
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            }
            if($r == $maxC)
                $h = ($g - $b) / ($maxC - $minC);
            if($g == $maxC)
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if($b == $maxC)
                $h = 4.0 + ($r - $g) / ($maxC - $minC);

            $h = $h / 6.0;
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }
}
