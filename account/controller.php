<?php
require '../database/connection.php';
function allUser(){
    global $conn;
    $query = "select * from accounts";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}
function deleteUser($id){
    global $conn;
    $query = "delete from accounts where id = $id";
    return $conn->query($query);
}
function setOrUnsetAdmin($id){
    global $conn;
    $query = "update accounts set is_admin = NOT is_admin where id = $id";
    return $conn->query($query);
}
