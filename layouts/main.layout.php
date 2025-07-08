<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Meeting Calendar';
}
if (!isset($content)) {
    $content = '<p>No content provided.</p>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <header class="header">
        <h1>Meeting Calendar</h1>
        <nav class="nav">
            <a href="*">Dashboard</a>
            <a href="*">Meetings</a>
            <a href="*">Calendar</a>
            <form action="/handlers/auth.handler.php?action=logout" method="POST" class="inline-form">
            </form>
        </nav>
    </header>

    <main class="container">
        <?= $content ?>
    </main>

    <footer class="footer">
        &copy; <?= date('Y') ?> Meeting Calendar | All rights reserved.
    </footer>
</body>

</html>