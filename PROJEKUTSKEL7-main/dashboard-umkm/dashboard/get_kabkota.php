<?php
require_once '../config/database.php';
require_once '../models/LocationModel.php';

header('Content-Type: application/json');

$locationModel = new LocationModel($conn);

$provinsiId = $_GET['provinsi_id'] ?? null;

if ($provinsiId) {
    $kabkota = $locationModel->getKabkotaByProvince($provinsiId);
    echo json_encode($kabkota);
} else {
    echo json_encode([]);
}