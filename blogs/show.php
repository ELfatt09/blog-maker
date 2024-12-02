<?php
require 'controller.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $blog = show($id);
} else {
    header("Location: ./index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $blog['judul'] ?></title>
    <link href="../asset/css/style.css" rel="stylesheet">
</head>

<body> <?php include '../layout/header.php' ?>
    <div class="w-full md:w-2/5 mx-auto">
        <div class="mx-5 my-3 text-sm">
            <a href="./index.php?category=<?= $blog['type'] ?>" class="uppercase text-blue-600 font-bold tracking-widest"><?= $blog['type'] ?></a>
        </div>
        <div class="first-letter:uppercase w-full text-gray-800 text-5xl px-5 font-bold leading-none tracking-tight mb-4">
            <?= $blog['judul'] ?>
        </div>
        <?php if (!is_null($blog['header_img_path']) && !empty($blog['header_img_path'])) { ?>
            <div class="mx-5">
                <img src="<?= $blog['header_img_path'] ?>" alt="<?= $blog['judul'] ?>">
            </div>
        <?php } ?>
        <div class="w-full text-gray-600 text-normal mx-5">
            <p class="border-b py-3"> <?= date('d F Y', strtotime($blog['created_at'])) ?></p>
        </div>
        <div class="w-full text-gray-600 font-thin italic px-5 pt-3">
            By <strong class="text-gray-700"><?= $blog['author_username'] ?></strong>
        </div>
        <div class="px-5 w-full text-lg mx-auto">
            <?php
            foreach (array_filter(explode("\n", $blog['isi']), 'trim') as $paragraph) {
                echo "<p class='my-5'>" . htmlspecialchars($paragraph) . "</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>