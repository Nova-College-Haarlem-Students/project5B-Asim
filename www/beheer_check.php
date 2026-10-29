<?php
require 'klant_check.php';

if (!in_array($_SESSION['role'], ['medewerker', 'admin'])) {
    header('Location: 403.php');
    exit;
}
