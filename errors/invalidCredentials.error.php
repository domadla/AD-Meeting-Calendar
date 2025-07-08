<?php
$pageTitle = 'Login Error';
$error = trim((string) ($_GET['error'] ?? 'Unknown error'));
$error = str_replace('%', ' ', $error);

ob_start();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<h2>Login Failed</h2>
<p class="error">Inavlid Credentials</p>

<a href="/login.php" class="button">Back to Login</a>


<?php
include COMPONENTS_PATH . '/componentGroup/footer.component.php';
