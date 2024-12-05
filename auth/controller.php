<?php

require "../database/connection.php";

function register($data)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = password_hash(mysqli_real_escape_string($conn, $data['password']), PASSWORD_DEFAULT);

    $checkQuery = "SELECT * FROM accounts WHERE username = ?";

    if ($stmt = $conn->prepare($checkQuery)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $username, $password, $is_admin);

        if ($stmt->num_rows) {
            echo "<script>alert('Username already exists');</script>";
        } else {

            $query = "INSERT INTO accounts (username, password) VALUES (?, ?)";

            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                header("Location: ../auth/login.php");
            } else {
                echo "<script>alert('Error registering user');</script>";
            }
        }
        $stmt->close();
    }
}

function login($data)
{
    global $conn;

    $inputUsername = mysqli_real_escape_string($conn, $data['username']);
    $inputPassword = mysqli_real_escape_string($conn, $data['password']);

    $query = "SELECT * FROM accounts WHERE username = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $inputUsername);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $username, $password, $is_admin);

        if ($stmt->num_rows) {
            $stmt->fetch();
            if (password_verify($inputPassword, $password)) {
                session_start();

                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['is_admin'] = $is_admin;
                $_SESSION['login'] = TRUE;
                if ($_SESSION['is_admin']) {
                    header("Location: ../admin/index.php");
                } else {
                    header("Location: ../index.php");
                }
            } else {
                echo "<script>alert('Invalid username or password');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
        $stmt->close();
    }
}
function logout()
{
    session_start();
    session_destroy();
    header("Location: ../index.php");
}

