<?php

    error_reporting(0);
    header('Content-Type: application/json');

    require_once __DIR__ . '/vendor/autoload.php';

    switch($_GET['kategori']) {
        case 'jadkul':
        case 'mhsbaru':
        case 'kelasbaru':
        case 'kalenderakademik':
            echo (new GunadarmaAPI\Gunadarma())->checkCache();
        break;
        default:
            http_response_code(404);
            echo json_encode(['status' => false, 'pesan' => 'parameter tidak ditemukan']);
        break;
    }