<?php

function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randstring = '';
    for ($i = 0; $i < 32; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

$target_dir = "../files/media";

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$fileName = RandomString();
$originalFileName = $_FILES["photo"]["name"];
$target_dir = $target_dir . "/" . $fileName . ".jpg"; //you can use .jpg or whatever mimetype

if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir)) {
    $query = $db->query("
        INSERT INTO table_names (`type`, category, description, `date`, `value`, attachment, attachment_description)
        VALUES ('{$type}', '{$category}', '{$description}', '{$date}',  '{$value}', '{$fileName}', '{$originalFileName}')
    ");
    if ($query) {
        $json["status"] = "ok";
    } else {
        $json["status"] = "uuppps somethings wrong please check the database connections";
    }
} else {
    $json["status"] = "Sorry, there was an error uploading your file";
}
echo json_encode($json);

?>