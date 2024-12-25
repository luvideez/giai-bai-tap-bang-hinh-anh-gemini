<?php
require 'vendor/autoload.php'; // Đảm bảo đã cài đặt thư viện Google Cloud Vision

use Google\Cloud\Vision\V1\ImageAnnotatorClient;

// Xác thực bằng file credentials.json (hãy tải file này từ Google Cloud Console)
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/credentials.json');

if (isset($_FILES['image'])) {
    $imageFile = $_FILES['image'];

    if ($imageFile['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Tạo thư mục uploads
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadPath = $uploadDir . basename($imageFile['name']);

        if (move_uploaded_file($imageFile['tmp_name'], $uploadPath)) {
            try {
                // Khởi tạo ImageAnnotatorClient
                $imageAnnotator = new ImageAnnotatorClient();

                // Đọc nội dung ảnh
                $image = file_get_contents($uploadPath);

                // Thực hiện OCR
                $response = $imageAnnotator->textDetection($image);
                $texts = $response->getTextAnnotations();

                if (!empty($texts)) {
                    $extractedText = $texts[0]->getDescription();
                    echo json_encode(['success' => true, 'text' => $extractedText]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'No text found in the image.']);
                }

                $imageAnnotator->close();
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to upload image.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Image upload error. Code: ' . $imageFile['error']]);
    }
}
?>
