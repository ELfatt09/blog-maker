<?php

require 'controller.php';
session_start();

if (!$_SESSION['login']) {
    header("Location: ../auth/login.php");
    exit;
}

$authorId = $_GET['id'] ?? 0;
$blogs = getBlogsByAuthor($authorId);
$author = fetchSingleResult("SELECT id, username FROM accounts WHERE id =$authorId");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $author['username'] ?>'s Blogs</title>
    <link href="../asset/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include '../layout/header.php' ?>
    <section class="pt-3
 pb-10 lg:pb-20 w-full items-center flex justify-center">

        <div class="container mx-auto pt-6">
            <div class="flex flex-wrap justify-center">
                <div class="w-full max-w-screen-lg px-4">
                    <div class="text-center mx-auto mb-10 max-w-md">
                        <h2 class="font-bold text-3xl sm:text-4xl md:text-5xl text-dark mb-4">
                            <?= $author['username'] ?>'s Blogs
                        </h2>
                        <hr class="border-t-4 border-blue-500 my-4">
                    </div>
                </div>
            </div>
            <?php include '../layout/blogList.php' ?>
        </div>
    </section>
</body>

</html>