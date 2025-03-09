<?php
session_start();
if (!isset($_SESSION['payment_failed']) || !isset($_SESSION['error_details'])) {
    header("Location: index.php");
    exit();
}

$error_details = $_SESSION['error_details'];
// Clear the session data after retrieving it
unset($_SESSION['payment_failed']);
unset($_SESSION['error_details']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - Aria Boutique</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="indexstyle.css">
    <link rel="icon" type="image/png" href="./images/boutique logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/scrollreveal"></script>

    <style>
        .failed-container {
            max-width: 800px;
            margin: 8rem auto 4rem;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .failed-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .failed-icon {
            width: 80px;
            height: 80px;
            background: #FFEBEE;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .failed-icon i {
            font-size: 2.5rem;
            color: #D32F2F;
        }

        .failed-title {
            color: #D32F2F;
            margin-bottom: 0.5rem;
        }

        .failed-subtitle {
            color: #666;
            margin-bottom: 2rem;
        }

        .error-details {
            border: 1px solid #ffcdd2;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            background: #FFEBEE;
        }

        .error-message {
            color: #D32F2F;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .error-code {
            color: #666;
            font-size: 0.85rem;
            font-family: monospace;
            background: rgba(0, 0, 0, 0.05);
            padding: 0.5rem;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .try-again {
            background: #000;
            color: white;
        }

        .contact-support {
            background: #f8f9fa;
            color: #333;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .support-info {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }

        .support-info p {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .support-info a {
            color: #000;
            text-decoration: none;
            font-weight: 500;
        }

        .support-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="failed-container">
        <div class="failed-header">
            <div class="failed-icon">
                <i class="fas fa-times"></i>
            </div>
            <h1 class="failed-title">Payment Failed</h1>
            <p class="failed-subtitle">We couldn't process your payment</p>
        </div>

        <div class="error-details">
            <div class="error-message">
                <?php echo htmlspecialchars($error_details['message']); ?>
            </div>
            <?php if (isset($error_details['code'])): ?>
                <div class="error-code">
                    Error Code: <?php echo htmlspecialchars($error_details['code']); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="action-buttons">
            <a href="javascript:history.back()" class="action-button try-again">
                <i class="fas fa-redo"></i>
                Try Again
            </a>
            <a href="contact.php" class="action-button contact-support">
                <i class="fas fa-headset"></i>
                Contact Support
            </a>
        </div>

        <div class="support-info">
            <p>Need help? Our support team is available 24/7</p>
            <p>Email us at <a href="mailto:support@ariaboutique.com">support@ariaboutique.com</a></p>
        </div>
    </div>

    <?php include 'footer.html'; ?>
    <script src="indexscript.js"></script>
</body>
</html> 