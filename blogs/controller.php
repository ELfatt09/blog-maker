<?php
require_once '../database/connection.php';

function sanitizeInput($input)
{
    return htmlspecialchars($input, ENT_QUOTES);
}


function all($type = null)
{
    global $conn;
    $query = "SELECT b.id, b.judul, b.type, b.header_img_path, b.isi, b.created_at, b.author_id, a.username AS author_username
              FROM blog b
              JOIN accounts a ON b.author_id = a.id";
    if (!is_null($type)) {
        $escapedType = $type;
        $query .= " WHERE b.type = ?";
    }
    $query .= " ORDER BY b.created_at DESC";
    $stmt = $conn->prepare($query);
    if (!is_null($type)) {
        $stmt->bind_param("s", $escapedType);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function show($id)
{
    global $conn;
    $query = "SELECT b.id, b.judul, b.type, b.header_img_path, b.isi, b.created_at, a.username AS author_username
              FROM blog b
              JOIN accounts a ON b.author_id = a.id
              WHERE b.id = ?";
    $stmt = $conn->prepare($query);
    $id_escaped = $id;
    $stmt->bind_param("i", $id_escaped);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $data['isi'] = sanitizeInput($data['isi']);
    return $data;
}

function create(array $data)
{
    global $conn;
    $query = "INSERT INTO blog (judul, header_img_path, type, isi, author_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $header_img_path = $_FILES['image']['tmp_name'] ? getHeaderImgPath($_FILES) : null;
    $stmt->bind_param("ssssi", sanitizeInput($data['judul']), $header_img_path, sanitizeInput($data['type']), sanitizeInput($data['isi']), $_SESSION['id']);
    $stmt->execute();
    redirectToIndex();
}

function update($data, $id)
{
    global $conn;
    if (!validateAuthor($id, $_SESSION['id'])) {
        sendForbiddenResponse();
    }
    $query = "UPDATE blog SET judul = ?, header_img_path = ?, type = ?, isi = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!empty($_FILES['image']['tmp_name'])) {
        deleteOldHeaderImage($id);
    }
    $header_img_path = empty($_FILES['image']['tmp_name']) ? getHeaderImgPathById($id) : getHeaderImgPath($_FILES);
    $stmt->bind_param("ssssi", sanitizeInput($data['judul']), $header_img_path, sanitizeInput($data['type']), sanitizeInput($data['isi']), $id);
    $stmt->execute();
    redirectToIndex();
}

function delete($id)
{
    global $conn;
    if (!validateAuthor($id, $_SESSION['id'])) {
        sendForbiddenResponse();
    }
    $query = "DELETE FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    deleteOldHeaderImage($id);
    $stmt->execute(); 
    redirectToIndex();
}

function getBlogsByAuthor($authorId)
{
    global $conn;
    $id_escaped = $authorId;
    $query = "SELECT b.id, b.judul, b.type, b.header_img_path, b.isi, b.created_at, b.author_id, a.username AS author_username
              FROM blog b
              JOIN accounts a ON b.author_id = a.id
              WHERE b.author_id = ?
              ORDER BY b.created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_escaped);
    $stmt->execute();
    $result = $stmt->get_result();
    $resultArray = $result->fetch_all(MYSQLI_ASSOC);
    foreach ($resultArray as &$row) {
        $row['isi'] = sanitizeInput($row['isi']);
    }
    return $resultArray;
}

function getHeaderImgPath(array $image)
{
    $header_img_path = $image['image']['tmp_name'];
    $storage_dir = '../storage/';
    if (!file_exists($storage_dir)) {
        mkdir($storage_dir, 0777, true);
    }
    $destination_path = $storage_dir . time() . basename($image['image']['name']);
    move_uploaded_file($header_img_path, $destination_path);
    return $destination_path;
}

function getHeaderImgPathById($id)
{
    global $conn;
    $query = "SELECT header_img_path FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['header_img_path'];
}

function validateAuthor($postId, $authorId)
{
    global $conn;
    $query = "SELECT author_id FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['author_id'] === $authorId || $_SESSION['is_admin'];
}

function redirectToIndex()
{
    header('location: index.php');
}

function sendForbiddenResponse()
{
    http_response_code(403);
    die('Forbidden');
}

function deleteOldHeaderImage($id)
{
    $header_img_path = getHeaderImgPathById($id);
    if (!empty($header_img_path) || file_exists($header_img_path)) {
        unlink($header_img_path);
    }
}

function fetchSingleResult(string $query, array $params = []): ?array
{
    global $conn;
    $stmt = $conn->prepare($query);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...array_map('sanitizeInput', $params));
    }
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ?: null;
}


