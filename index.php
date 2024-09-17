<?php session_start();

if (!isset($_SESSION['username'])) {

    ?>
    <script> window.location.href = "login.php";</script>
    <?php
} else {

    ?>
    <script> window.location.href = "dashboard/index.php";</script>
    <?php
}

?>