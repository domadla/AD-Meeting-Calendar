<?php

require_once __DIR__ . '/../../bootstrap.php';
require_once UTILS_PATH . 'auth.util.php';

$pageTitle = 'Login Successful';

ob_start();
?>

<h2>Login Successful</h2>
<p>Welcome to the Meeting Calendar system.</p>

<form action="/handlers/auth.handler.php?action=logout" method="POST">
    <button type="submit" class="logout-button">Logout</button>
</form>

<?php
$content = ob_get_clean();
include LAYOUTS_PATH . 'main.layout.php';
