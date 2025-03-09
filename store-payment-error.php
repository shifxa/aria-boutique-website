<?php
session_start();

// Get the JSON data from the request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data && isset($data['error'])) {
    // Store error details in session
    $_SESSION['payment_failed'] = true;
    $_SESSION['error_details'] = [
        'code' => $data['error']['code'],
        'message' => $data['error']['description'],
        'source' => $data['error']['source'],
        'step' => $data['error']['step'],
        'reason' => $data['error']['reason']
    ];

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid error data received']);
}
?> 