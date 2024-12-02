<?php

require "../database/connection.php";

function register($data)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = password_hash(mysqli_real_escape_string($conn, $data['password']), PASSWORD_DEFAULT);

    $checkQuery = "SELECT * FROM accounts WHERE username = '$username'";

    if ($conn->query($checkQuery)->num_rows) {
        return "Username already exists";
    } else {
        $query = "INSERT INTO accounts (username, password) VALUES ('$username', '$password')";

        if ($conn->query($query)) {
            header("Location: ../auth/login.php");
        } else {
            return "Error registering user";
        }
    }
}

function login($data)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = mysqli_real_escape_string($conn, $data['password']);

    $query = "SELECT * FROM accounts WHERE username = '$username'";
    $account = $conn->query($query)->fetch_assoc();

    if ($account && password_verify($password, $account['password'])) {
        session_start();

        $_SESSION['id'] = $account['id'];
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = $account['is_admin'];
        $_SESSION['login'] = TRUE;
        if ($_SESSION['is_admin']) {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../index.php");
        }
    } else {
        return "Invalid username or password";
    }
}
function logout()
{
    session_start();
    session_destroy();
    header("Location: ../index.php");
}
