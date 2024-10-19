<?php
require_once('database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_name = $_POST['client_name'];

    $insert_clients = "INSERT INTO clients (client_name) VALUES ('$client_name')";
    if ($db->query($insert_clients)) {
        $_SESSION['add_client_name'] = true;

        header('Location: dashboard.php');
    } else {
        $_SESSION['add_client_name'] = false;
    }

    $db->close();
    exit();
}
