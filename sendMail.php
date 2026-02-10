<?php

/**
 * Configuration for the contact form.
 */
$config = [
    'recipient' => 'info@sebastianfranke.com',
    'from_email' => 'portfolio@sebastianfranke.com',
    'allowed_origins' => [
        'https://cozmostar.de',
        'http://localhost:4200',
    ],
];

// Determine CORS origin
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$allowedOrigin = in_array($origin, $config['allowed_origins']) ? $origin : $config['allowed_origins'][0];

/**
 * Handle different request methods.
 */
switch ($_SERVER['REQUEST_METHOD']) {
    case "OPTIONS":
        // Handle CORS preflight requests
        header("Access-Control-Allow-Origin: " . $allowedOrigin);
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: content-type");
        exit;

    case "POST":
        header("Access-Control-Allow-Origin: " . $allowedOrigin);
        
        // Retrieve and parse the JSON payload
        $json = file_get_contents('php://input');
        $params = json_decode($json);

        if (!$params || !isset($params->email, $params->name, $params->message)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['error' => 'Invalid data provided.']);
            exit;
        }

        $senderEmail = $params->email;
        $senderName = $params->name;
        $senderMessage = $params->message;

        $subject = "Contact From <$senderEmail>";
        $emailContent = "From: " . htmlspecialchars($senderName) . "<br><br>" . nl2br(htmlspecialchars($senderMessage));

        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            'From: ' . $config['from_email'],
            'Reply-To: ' . $senderEmail
        ];

        // Send the email
        $success = mail($config['recipient'], $subject, $emailContent, implode("\r\n", $headers));

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(['error' => 'Failed to send email.']);
        }
        break;

    default:
        // Reject non-POST or non-OPTIONS requests
        header("Allow: POST, OPTIONS", true, 405);
        echo json_encode(['error' => 'Method not allowed.']);
        exit;
}
