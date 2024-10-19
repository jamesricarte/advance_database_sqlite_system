<?php
require_once('database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $client_id = $_GET['id'];

    $delete_clients = "DELETE FROM clients WHERE id = $client_id";
    if ($db->query($delete_clients)) {
        $_SESSION['delete_client'] = true;

        header('Location: dashboard.php');
    } else {
        $_SESSION['delete_client'] = false;
    }

    $db->close();
    exit();
}
