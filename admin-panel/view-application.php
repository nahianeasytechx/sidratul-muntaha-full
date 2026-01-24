<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'View Application';
require './components/header.php';

// Get application ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>window.location='scholarship-application-list.php'</script>";
    exit;
}

$applicationId = (int)$_GET['id'];
$application = getScholarshipApplicationById($applicationId);

if (!$application) {
    $_SESSION['error_message'] = 'Application not found';
    header('Location: scholarship-application-list.php');
    exit;
}

?>

<style>
    /* Page Header */
    .page-header-view {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .page-header-view h2 {
        color: white;
        font-weight: 700;
        margin: 0;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateX(-5px);
    }

    /* Application Details Card */
    .application-details {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .application-details h4 {
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #10b981;
        display: inline-block;
    }
    
    .detail-row {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .detail-row:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .detail-value {
        color: #1f2937;
        font-size: 1rem;
        font-weight: 500;
    }

    .detail-value .badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }
    
    /* Documents Section */
    .documents-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .documents-section h4 {
        color: #1f2937;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #8b5cf6;
        display: inline-block;
    }

    .documents-section h4 .badge {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        font-size: 0.9rem;
        padding: 0.5rem 0.8rem;
        margin-left: 0.5rem;
    }
    
    .document-card {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        background: white;
    }
    
    .document-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #10b981;
        transform: translateY(-3px);
    }
    
    .document-info {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }
    
    .document-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 28px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .document-card:hover .document-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .document-icon.pdf { 
        color: #dc2626; 
        background: linear-gradient(135deg, #fee2e2, #fecaca);
    }
    .document-icon.doc { 
        color: #2563eb; 
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    }
    .document-icon.img { 
        color: #059669; 
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    }
    
    .document-details {
        flex: 1;
        min-width: 0;
    }

    .document-details h6 {
        margin: 0 0 8px 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .document-details small {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .document-details small i {
        color: #9ca3af;
    }
    
    .document-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }

    .document-actions .btn {
        transition: all 0.3s ease;
        font-weight: 600;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .document-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .btn-view {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #94a3b8;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .document-card {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .document-info {
            width: 100%;
        }

        .document-actions {
            width: 100%;
        }

        .document-actions .btn {
            flex: 1;
        }

        .detail-row {
            padding: 15px;
        }
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="page-header-view">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h2>
                                <i class="fa-solid fa-file-lines me-2"></i>
                                Application Details
                            </h2>
                            <p class="mb-0 opacity-75">
                                Application #<?= $applicationId ?> - <?= htmlspecialchars($application['name']) ?>
                            </p>
                        </div>
                        <a href="scholarship-application-list.php" class="btn btn-back">
                            <i class="fa-solid fa-arrow-left me-2"></i> Back to List
                        </a>
                    </div>
                </div>

                <!-- Application Details -->
                <div class="application-details">
                    <h4>
                        <i class="fa-solid fa-user me-2"></i>
                        Personal Information
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-user me-1"></i> Full Name
                                </div>
                                <div class="detail-value"><?= htmlspecialchars($application['name']) ?></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-envelope me-1"></i> Email
                                </div>
                                <div class="detail-value">
                                    <?= !empty($application['email']) ? htmlspecialchars($application['email']) : '<em class="text-muted">Not provided</em>' ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-phone me-1"></i> Phone
                                </div>
                                <div class="detail-value">
                                    <?= !empty($application['phone']) ? htmlspecialchars($application['phone']) : '<em class="text-muted">Not provided</em>' ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-location-dot me-1"></i> Address
                                </div>
                                <div class="detail-value">
                                    <?= !empty($application['address']) ? htmlspecialchars($application['address']) : '<em class="text-muted">Not provided</em>' ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-building me-1"></i> Institution Type
                                </div>
                                <div class="detail-value">
                                    <span class="badge bg-primary">
                                        <?= ucfirst(str_replace('-', ' ', htmlspecialchars($application['institution_type']))) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-school me-1"></i> Institution Name
                                </div>
                                <div class="detail-value">
                                    <?= !empty($application['institute_name']) ? htmlspecialchars($application['institute_name']) : '<em class="text-muted">Not provided</em>' ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-calendar me-1"></i> Application Date
                                </div>
                                <div class="detail-value">
                                    <?= date('F j, Y g:i A', strtotime($application['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fa-solid fa-circle-info me-1"></i> Status
                                </div>
                                <div class="detail-value">
                                    <span class="badge bg-warning text-dark">
                                        <i class="fa-solid fa-clock me-1"></i> Pending
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="documents-section">
                    <h4>
                        <i class="fa-solid fa-file-pdf me-2"></i>
                        Submitted Documents
                        <span class="badge"><?= count($application['documents']) ?></span>
                    </h4>

                    <?php if (empty($application['documents'])): ?>
                        <div class="empty-state">
                            <i class="fa-solid fa-folder-open"></i>
                            <h5>No Documents Uploaded</h5>
                            <p>This application doesn't have any supporting documents yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($application['documents'] as $document): ?>
                            <?php
                            $iconClass = 'fa-file-lines';
                            $iconType = 'doc';
                            
                            if ($document['document_type'] === 'pdf') {
                                $iconClass = 'fa-file-pdf';
                                $iconType = 'pdf';
                            } elseif (in_array($document['document_type'], ['jpg', 'jpeg', 'png'])) {
                                $iconClass = 'fa-file-image';
                                $iconType = 'img';
                            } elseif (in_array($document['document_type'], ['doc', 'docx'])) {
                                $iconClass = 'fa-file-word';
                                $iconType = 'doc';
                            }
                            
                            $fileSize = $document['file_size'];
                            if ($fileSize < 1024) {
                                $sizeText = $fileSize . ' B';
                            } elseif ($fileSize < 1024 * 1024) {
                                $sizeText = round($fileSize / 1024, 2) . ' KB';
                            } else {
                                $sizeText = round($fileSize / (1024 * 1024), 2) . ' MB';
                            }
                            ?>
                            
                            <div class="document-card">
                                <div class="document-info">
                                    <div class="document-icon <?= $iconType ?>">
                                        <i class="fa-solid <?= $iconClass ?>"></i>
                                    </div>
                                    <div class="document-details">
                                        <h6 title="<?= htmlspecialchars($document['document_original_name']) ?>">
                                            <?= htmlspecialchars($document['document_original_name']) ?>
                                        </h6>
                                        <small>
                                            <i class="fa-solid fa-weight-scale me-1"></i><?= $sizeText ?> • 
                                            <i class="fa-solid fa-calendar-days me-1"></i>Uploaded <?= date('M j, Y g:i A', strtotime($document['uploaded_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="document-actions">
                                    <a href="download-document.php?id=<?= $document['id'] ?>" 
                                       class="btn btn-sm btn-view" 
                                       title="View/Download Document">
                                        <i class="fa-solid fa-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './components/footer.php'; ?>