<?php
// Add to wp-config.php or create a mu-plugin
require_once __DIR__ . '/../../../vendor/autoload.php';

// Use dotenv to get the password
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

add_action('phpmailer_init', function($phpmailer) {
	$phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587; // or 465 for SSL
    $phpmailer->SMTPSecure = 'tls'; // or 'ssl'
    $phpmailer->Host = $_ENV['SMTP_HOST'];
    $phpmailer->Username = $_ENV['SMTP_USER'];
    $phpmailer->Password = $_ENV['SMTP_PASSWORD'];
    $phpmailer->isSMTP();
});