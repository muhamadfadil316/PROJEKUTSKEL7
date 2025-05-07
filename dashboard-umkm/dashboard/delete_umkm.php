<?php
require_once '../config/database.php';
require_once '../models/UMKMModel.php';

$umkmModel = new UMKMModel($conn);

// Get UMKM ID to delete
$id = $_GET['id'] ?? null;

if ($id) {
    $umkmModel->deleteUmkm($id);
}

header("Location: umkm.php");
exit;
?>
