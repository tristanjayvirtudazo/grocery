<?php

require "../vendor/autoload.php";

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$data = $_POST['name'];

$qr_code = QrCode::create($data);

$writer = new PngWriter;

$result =  $writer->write($qr_code);

$image = uniqid(rand())."QR.png";

$result->saveToFile("../assests/images/QrCodes/".$image);

echo $image;
// header("Content-Type: " . $result->getMimeType());


// echo $result->getString();