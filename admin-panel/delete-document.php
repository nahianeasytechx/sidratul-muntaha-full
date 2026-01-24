<?php
session_start();
require_once '../config/database.php';
require_once '../functions/scholarship_functions.php';

header('Content-Type: application/json');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['document_id']) || !is_numeric($input['document_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid document ID']);
    exit;
}

$documentId = (int)$input['document_id'];

// Delete the document
$result = deleteScholarshipDocument($documentId);

echo json_encode($result);
?>