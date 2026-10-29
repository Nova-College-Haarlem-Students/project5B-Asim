<?php
require 'klant_check.php';

if ($_SESSION['role'] != 'admin') {
    header('Location: 403.php');
    exit;
}
