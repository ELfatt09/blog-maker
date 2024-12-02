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
            <div class="flex flex-wrap justify-center -mx-4">
                <?php if (empty($blogs)) : ?>
                    <p class="text-center">No blogs found.</p>
                <?php else : ?>
                    <?php foreach ($blogs as $blog) : ?>
                        <div class="w-full sm:w-1/2 lg:w-1/3 px-4 mb-6">
                            <div class="bg-white rounded-lg shadow-lg p-6">
                                <a href="./index.php?type=<?= $blog['type'] ?>">
                                    <h5 class="text-sm uppercase font-bold tracking-widest text-blue-500 mb-2"><?= $blog['type'] ?></h5>
                                    <div class="flex flex-col">
                                        <?php if (!is_null($blog['header_img_path']) && !empty($blog['header_img_path'])) { ?>
                                            <img src="<?= $blog['header_img_path'] ?>" alt="image" class="h-[250px] w-full sm:w-[250px] md:w-full rounded-lg object-cover mb-4">
                                        <?php } ?>
                                        <div>
                                            <h3 class="text-2xl font-semibold tracking-tight mb-4">
                                                <a href="./show.php?id=<?= $blog['id'] ?>" class="hover:text-blue-500">
                                                    <?= $blog['judul'] ?>
                                                </a>
                                            </h3>
                                            <div class="flex items-center">
                                                <p class="text-sm text-gray-600 mr-2">
                                                    At
                                                </p>
                                                <p class="text-sm">
                                                    <?= date('d F Y', strtotime($blog['created_at'])) ?>
                                                </p>
                                            </div>
                                            <div class="flex items-center mb-2">
                                                <p class="text-sm text-gray-600 mr-2">
                                                    By
                                                </p>
                                                <p class="text-sm">
                                                    <a href="./author.php?id=<?= $blog['author_id'] ?>" class="hover:text-blue-500">
                                                        <?= $blog['author_username'] ?>
                                                    </a>
                                                </p>
                                            </div>
                                            <p class="text-gray-600 mb-4">
                                                <?= substr($blog['isi'], 0, 80) . '...' ?>
                                            </p>
                                            <?php if (validateAuthor($blog['id'], $_SESSION['id'])) : ?>
                                                <div class="mt-4 flex space-x-2">
                                                    <a href="./form.php?update=<?= $blog['id'] ?>" class="px-4 py-2 text-sm font-semibold bg-yellow-500 rounded-lg hover:bg-yellow-600 focus:bg-yellow-600 focus:outline-none focus:shadow-outline">
                                                        Update
                                                    </a>
                                                    <a href="./delete.php?id=<?= $blog['id'] ?>" class="px-4 py-2 text-sm font-semibold bg-red-500 rounded-lg hover:bg-red-600 focus:bg-red-600 focus:outline-none focus:shadow-outline">
                                                        Delete
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>