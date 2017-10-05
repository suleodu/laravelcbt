<?php 
function csvToArray($filename = '', $delimiter = ',') {
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    return $data;
}



/**
    * this function fetch the relative part of a given image 
    * 
    * @param string $image_name
    * @param string $dir
    * @return string relative url 
    */
   function get_pics($image_name, $dir, $url = TRUE) {

       $image_url =  "/user/profile.png";

       $image = [
           "{$dir}/" . strtoupper($image_name) . ".jpg",
           "{$dir}/" . strtolower($image_name) . ".jpg",
           "{$dir}/" . strtoupper($image_name) . ".jpeg",
           "{$dir}/" . strtolower($image_name) . ".jpeg",
           "{$dir}/" . strtoupper($image_name) . ".JPG",
           "{$dir}/" . strtolower($image_name) . ".JPG",
           "{$dir}/" . strtoupper($image_name) . ".JPEG",
           "{$dir}/" . strtolower($image_name) . ".JPEG",
           "{$dir}/" . strtoupper($image_name) . ".png",
           "{$dir}/" . strtolower($image_name) . ".png",
           "{$dir}/" . strtoupper($image_name) . ".PNG",
           "{$dir}/" . strtolower($image_name) . ".PNG",
           "{$dir}/" . strtoupper($image_name) . ".gif",
           "{$dir}/" . strtolower($image_name) . ".gif",
           "{$dir}/" . strtoupper($image_name) . ".GIF",
           "{$dir}/" . strtolower($image_name) . ".GIF"
       ];

       for ($idx = 0; $idx < count($image); $idx++) {
           if (realpath($image[$idx])) {
               $image_url = $image[$idx];
               break;
           }
       }

       if ($url) {
           $folder_path = explode('/', substr($image_url, strpos($image_url, 'img')));
           unset($folder_path[0]);
           $image_url = SITEIMGURL . '/' . implode('/', $folder_path);
       }

       return $image_url;
   }