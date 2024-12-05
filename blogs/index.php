<?php
require 'controller.php';
session_start();
if (!$_SESSION['login']) {
    header("Location: ../auth/login.php");
    exit;
}
if (isset($_GET['type'])) {
    $blogs = all($_GET['type']);
    $judul = "blog " . $_GET['type'];
} else {
    $blogs = all();
    $judul = "Semua blog";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul ?></title>
    <link href="../asset/css/style.css" rel="stylesheet">
</head>

<body> <?php include '../layout/header.php' ?>

    <section class="pt-3
 pb-10 lg:pb-20 w-full items-center flex justify-center">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center -mx-4">
                <div class="w-full px-4">
                    <div class="text-center mx-auto mb-2 mt-8 lg:mt-16 lg:mb-4 max-w-[510px]">
                        <h2
                            class="
                  font-bold
                  text-3xl
                  sm:text-4xl
                  md:text-[40px]
                  text-dark
                  uppercase">
                            <?= $judul ?>
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