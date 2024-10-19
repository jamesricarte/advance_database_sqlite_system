<?php
require_once('database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];

    $update_query = $db->prepare("UPDATE clients SET client_name = :client_name WHERE id = :id");
    $update_query->bindParam(':client_name', $client_name);
    $update_query->bindParam(':id', $client_id);
    $update_query->execute();

    header('Location: dashboard.php');
    exit;
}
