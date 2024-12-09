<?php
require '../database/connection.php';

if(!isset($_SESSION['login'])){
    session_start();
}

function allUser(){
    global $conn;
    $query = "select * from accounts";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function deleteUser($id){
    global $conn;
    if (!validateUser($id, $_SESSION['is_admin'])) {
        return false;
    }
    $query = "DELETE FROM accounts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function setOrUnsetAdmin($id){
    global $conn;
    $query = "update accounts set is_admin = NOT is_admin where id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function validateUser($id, $is_admin){
    global $conn;
    $query = "select is_admin, id from accounts where id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['id'] == $id || $is_admin == True;
}