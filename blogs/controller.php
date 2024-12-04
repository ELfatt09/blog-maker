<?php
require_once '../database/connection.php';

/**
 * Gets all blog posts of a type.
 *
 * @param string $type The type of blog posts to get.
 * @return array An associative array of blog posts.
 */
function all($type = null)
{
    $query = buildSelectQuery($type);
    return fetchAllResults($query);
}

/**
 * Gets a blog post.
 *
 * @param int $id The id of the blog post to get.
 * @return array An associative array of a blog post.
 */
function show($id)
{
    $query = "SELECT b.id, b.judul, b.type, b.header_img_path, b.isi, b.created_at, a.username AS author_username
              FROM blog b
              JOIN accounts a ON b.author_id = a.id
              WHERE b.id = $id order by b.created_at desc";
    return fetchSingleResult($query);
}

/**
 * Creates a new blog post.
 *
 * @param array $data The data to create a blog post with.
 */
function create(array $data)
{
    $query = buildInsertQuery($data);
    executeQuery($query);
    redirectToIndex();
}

/**
 * Updates an existing blog post.
 *
 * @param array $data The data to update the blog post with.
 * @param int $id The id of the blog post to update.
 */
function update($data, $id)
{
    if (!validateAuthor($id, $_SESSION['id'])) {
        sendForbiddenResponse();
    }
    $query = buildUpdateQuery($data, $id);
    if (!empty($_FILES['image']['tmp_name'])) {
        deleteOldHeaderImage($id);
    }
    executeQuery($query);
    redirectToIndex();
}

/**
 * Deletes a blog post.
 *
 * @param int $id The id of the blog post to delete.
 */
function delete($id)
{
    if (!validateAuthor($id, $_SESSION['id'])) {
        sendForbiddenResponse();
    }
    $query = "DELETE FROM blog WHERE id = $id";
    if (executeQuery($query)) {
        deleteOldHeaderImage($id);
    }
    redirectToIndex();
}
function getBlogsByAuthor($authorId)
{
    $query = "SELECT b.id, b.judul, b.type, b.header_img_path, b.isi, b.created_at, a.username AS author_username
              FROM blog b
              JOIN accounts a ON b.author_id = a.id
              WHERE b.author_id = '$authorId'
              ORDER BY b.created_at DESC";
    return fetchAllResults($query);
}

/**
 * Builds a select query for retrieving blog posts.
 *
 * @param string $type The type of blog posts to retrieve.
 * @return string The select query.
 */
function buildSelectQuery($type)
{
    $query = "SELECT b.id, b.judul, b.type, b.header_img_path, b.isi, b.author_id, b.created_at, a.username AS author_username
              FROM blog b
              JOIN accounts a ON b.author_id = a.id";
    if (!is_null($type)) {
        $query .= " WHERE b.type='$type'";
    }
    $query .= " ORDER BY b.created_at DESC";
    return $query;
}

/**
 * Builds an insert query for creating a new blog post.
 *
 * @param array $data The data to create a blog post with.
 * @return string The insert query.
 */
function buildInsertQuery($data)
{
    $judul = escape($data['judul']);
    $header_img_path = $_FILES['image']['tmp_name'] ? getHeaderImgPath($_FILES) : null;
    $isi = escape($data['isi']);
    $author_id = $_SESSION['id'];
    $type = escape($data['type']);
    return "INSERT INTO blog (judul, header_img_path, type, isi, author_id) VALUES ('$judul', '$header_img_path', '$type', '$isi', $author_id)";
}

/**
 * Builds an update query for updating an existing blog post.
 *
 * @param array $data The data to update the blog post with.
 * @param int $id The id of the blog post to update.
 * @return string The update query.
 */
function buildUpdateQuery($data, $id)
{
    $judul = escape($data['judul']);
    $header_img_path = empty($_FILES['image']['tmp_name']) ? getHeaderImgPathById($id) : getHeaderImgPath($_FILES);
    $isi = escape($data['isi']);
    $type = escape($data['type']);
    return "UPDATE blog SET judul = '$judul', header_img_path = '$header_img_path', type = '$type', isi = '$isi' WHERE id = $id";
}

/**
 * Fetches all results of a query.
 *
 * @param string $query The query to execute.
 * @return array An associative array of results.
 */
function fetchAllResults($query)
{
    global $conn;
    $result = $conn->query($query);
    if ($result === false) {
        die("Database error: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Fetches a single result of a query.
 *
 * @param string $query The query to execute.
 * @return array An associative array of a result.
 */
function fetchSingleResult($query)
{
    global $conn;
    $result = $conn->query($query);
    if ($result === false) {
        die("Database error: " . $conn->error);
    }
    return $result->fetch_assoc();
}

/**
 * Executes a query.
 *
 * @param string $query The query to execute.
 * @return bool True if the query was executed successfully, false otherwise.
 */
function executeQuery($query)
{
    global $conn;
    return $conn->query($query);
}

/**
 * Redirects to the index page.
 */
function redirectToIndex()
{
    header('location: index.php');
}

/**
 * Sends a 403 Forbidden response.
 */
function sendForbiddenResponse()
{
    http_response_code(403);
    die('Forbidden');
}

/**
 * Deletes an old header image of a blog post.
 *
 * @param int $id The id of the blog post whose old header image to delete.
 */
function deleteOldHeaderImage($id)
{
    $header_img_path = getHeaderImgPathById($id);
    if (!empty($header_img_path) && file_exists($header_img_path)) {
        unlink($header_img_path);
    }
}

/**
 * Gets the header image path of a blog post.
 *
 * @param array $image The uploaded image.
 * @return string The header image path.
 */
function getHeaderImgPath(array $image)
{
    $header_img_path = $image['image']['tmp_name'];
    $destination_path = '../storage/' . time() . basename($image['image']['name']);
    move_uploaded_file($header_img_path, $destination_path);
    return $destination_path;
}

/**
 * Gets the header image path of a blog post by id.
 *
 * @param int $id The id of the blog post whose header image path to get.
 * @return string The header image path.
 */
function getHeaderImgPathById($id)
{
    $query = "SELECT header_img_path FROM blog WHERE id = $id";
    return fetchSingleResult($query)['header_img_path'];
}

/**
 * Checks if the user is the author of a blog post.
 *
 * @param int $postId The id of the blog post.
 * @param int $authorId The id of the user.
 * @return bool True if the user is the author, false otherwise.
 */
function validateAuthor($postId, $authorId)
{
    $query = "SELECT author_id FROM blog WHERE id = $postId";
    $author = fetchSingleResult($query);
    return $author['author_id'] == $authorId || $_SESSION['is_admin'];
}

/**
 * Escapes a string for use in a query.
 *
 * @param string $string The string to escape.
 * @return string The escaped string.
 */
function escape(string $string)
{
    global $conn;
    return $conn->real_escape_string($string);
}

