<?php
require '../components/functions.php';

//  CREATE DATABASE CONNECTION
$conn = getDatabaseConnection();

if (!$conn) {
    http_response_code(500);
    die('Database connection failed');
}

// Validate document ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die('Invalid document ID');
}

$documentId = (int) $_GET['id'];

$sql = "SELECT document_path, document_original_name, document_type 
        FROM scholarship_documents 
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    die('Database error');
}

$stmt->bind_param("i", $documentId);
$stmt->execute();
$result = $stmt->get_result();
$document = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$document) {
    http_response_code(404);
    die('Document not found');
}

// FIX: Build correct file path
// document_path is stored as 'uploads/scholarships/filename.ext'
// We need to go up one level from admin/ to reach uploads/
$filePath = __DIR__ . '/../' . $document['document_path'];

// Debug logging
error_log("Looking for file at: " . $filePath);
error_log("Document path from DB: " . $document['document_path']);

// Check if file exists
if (!file_exists($filePath)) {
    http_response_code(404);
    error_log("File not found at: " . $filePath);
    die('File not found on server. Path: ' . htmlspecialchars($document['document_path']));
}

// Set appropriate content type
$mimeTypes = [
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png'
];

$contentType = $mimeTypes[$document['document_type']] ?? 'application/octet-stream';

// Set headers for download
header('Content-Type: ' . $contentType);
header('Content-Disposition: attachment; filename="' . basename($document['document_original_name']) . '"');
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: public');

// Clear output buffer
if (ob_get_level()) {
    ob_end_clean();
}
flush();

// Read and output file
readfile($filePath);

exit;
?>