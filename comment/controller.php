<?php
require_once '../database/connection.php';
function validateComment($comment)
{
    return !empty($comment);
}

function validateAuthor($comment_id, $author_id) {
    global $conn;
    $query = "SELECT author_id FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['author_id'] === $author_id;
}

function showComments($blog_id) {
    global $conn;
    $query = "SELECT c.id, c.comment, c.created_at, a.username AS author_username, a.id AS author_id
              FROM comments c
              JOIN accounts a ON c.author_id = a.id
              WHERE c.blog_id = ?
              ORDER BY c.created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addComment($blog_id, $author_id, $comment) {
    global $conn;
    $query = "INSERT INTO comments (blog_id, author_id, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $blog_id, $author_id, $comment);
    $stmt->execute();
}

function deleteComment($comment_id) {
    global $conn;
    $query = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
}
