<?php

/**
 * @param     $file
 * @param     $targetDir
 * @param int $newWidth
 * @param int $newHeight
 * @param int $maxFileSize
 *
 * @return bool|string
 */
function upload_image($file, $targetDir, $newWidth = 540, $newHeight = 480, $maxFileSize = 5000000)
{
    // Check for any upload errors
    if($file['error'] !== 0) {
        alert('error', "Er is een fout opgetreden tijdens het uploaden van: {$file['name']}");
        return false;
    }
    
    // Check file size
    if ($file["size"] > $maxFileSize) {
        $maxFileSizeMB = $maxFileSize / 1000000;
        alert('error', "{$file['name']} is te groot (max {$maxFileSizeMB} MB)");
        return false;
    }
    
    // Determine mime type
    $acceptedMimeTypes = ['jpg' => 'image/jpeg', 'png' => 'image/png'];
    $imageMimeType     = mime_content_type($file["tmp_name"]);
    
    // Create file name
    $fileHash          = md5_file($file['tmp_name']) . uniqid('', true);
    $targetFile        = $targetDir . '/' . $fileHash . '.jpg';
    
    // Only allow accepted file types
    if( !in_array($imageMimeType, $acceptedMimeTypes) ) {
        alert('error', "Error: {$file['name']}, Alleen afbeeldingen met het formaat: JPG, JPEG of PNG zijn toegestaan");
        return false;
    }
    
    // Check if file already exists
    if (file_exists($targetFile)) {
        alert('error', "Er is een fout opgetreden tijdens het uploaden van: {$file['name']}");
        return false;
    }
    
    // Determine image dimensions
    $dimensions = getimagesize($file['tmp_name']);
    
    // Check if image is not to small
    if($dimensions[0] < $newWidth || $dimensions[1] < $newHeight) {
        alert('error', "{$file['name']} is te klein, alleen afbeelding met afmetingen hoger dan of gelijk aan {$newWidth}x{$newHeight} zijn toegestaan");
        return false;
    }
    
    // Use the php GB library to crop the image
    $image = crop_image($file['tmp_name'], $imageMimeType, $newWidth, $newHeight);
    
    // Check if the image was successfully cropped
    if($image === false) {
        alert('error', "Er is een fout opgetreden tijdens het uploaden van: {$file['name']}");
        return false;
    }
    
    // Try save the image as jpeg
    if(!imagejpeg($image, $targetFile, 90)) {
        alert('error', "Er is een fout opgetreden tijdens het uploaden van: {$file['name']}");
        return false;
    }
    
    return $fileHash;
}

/**
 * @param $file
 * @param $mimeType
 * @param $newWidth
 * @param $newHeight
 *
 * @return bool|resource
 */
function crop_image($file, $mimeType, $newWidth, $newHeight)
{
    // Create a new image resource from the given file
    $srcCanvas = ($mimeType === 'image/png') ? imagecreatefrompng($file) : imagecreatefromjpeg($file);
    
    // Check if the image was successfully created
    if ($srcCanvas === false)
        return false;
    
    // Determine width and height
    $width  = imagesx($srcCanvas);
    $height = imagesy($srcCanvas);
    
    // Calculate center coordinates
    $centreX = round($width / 2);
    $centreY = round($height / 2);
    $x1 = max(0, $centreX - round($newWidth / 2));
    $y1 = max(0, $centreY - round($newHeight / 2));
    
    // Create a empty canvas
    $outputCanvas = imagecreatetruecolor($newWidth, $newHeight);
    
    // Check if empty canvas was created without errors
    if ($outputCanvas === false)
        return false;
    
    // Fill the empty canvas with white pixels
    imagefill($outputCanvas, 0, 0, imagecolorallocate($outputCanvas, 255, 255, 255));
    
    // Check if empty canvas was painted white without errors
    if ($outputCanvas === false)
        return false;
    
    // Paint part of the source canvas into the white canvas.
    // This will replace in all the "transparent pixels" with white pixels and crop at the same time
    if (!imagecopy($outputCanvas, $srcCanvas, 0, 0, $x1, $y1, $width, $height))
        return false;
    
    return $outputCanvas;
}