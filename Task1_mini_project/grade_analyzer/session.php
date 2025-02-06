<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function resetSession() {
    session_unset();
    session_destroy();
    session_start();
}
?>
