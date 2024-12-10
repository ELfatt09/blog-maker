<?php
require 'controller.php';
session_start();
if (!$_SESSION['login']) {
    header("Location: ../auth/login.php");
    exit;
}
$id = '';

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    if (!validateAuthor($id, $_SESSION['id'])) {
        http_response_code(403);
        die('Forbidden');
    }
    $blog = show($id);
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        update($_POST, $id);
        header("Location: index.php");
        exit;
    }
} else {
    $blog = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    create($_POST);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="efan">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'update' : 'buat' ?> blog</title>
    <link href="../asset/css/style.css" rel="stylesheet">
</head>

<body> <?php include '../layout/header.php' ?>
    <div class="w-full md:w-2/5 mx-auto">
        <form action="form.php<?= $id ? '?update=' . $id : '' ?>" method="post" enctype="multipart/form-data">
            <div class="mx-5 my-3 text-sm">
                <select class="uppercase text-blue-600 font-bold tracking-widest" name="type" id="type">
                    <?php $selected = $blog['type'] ?? ''; ?>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="artikel" <?= $selected == 'artikel' ? 'selected' : '' ?>>artikel</option>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="cerita" <?= $selected == 'cerita' ? 'selected' : '' ?>>cerita</option>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="tutorial" <?= $selected == 'tutorial' ? 'selected' : '' ?>>tutorial</option>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="berita" <?= $selected == 'berita' ? 'selected' : '' ?>>berita</option>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="promosi" <?= $selected == 'promosi' ? 'selected' : '' ?>>promosi</option>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="review" <?= $selected == 'review' ? 'selected' : '' ?>>review</option>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="opini" <?= $selected == 'opini' ? 'selected' : '' ?>>opini</option>
                    <option class="uppercase text-blue-600 font-bold tracking-widest" value="wawancara" <?= $selected == 'wawancara' ? 'selected' : '' ?>>wawancara</option>
                </select>
            </div>
            <input class="first-letter:uppercase mx-5 w-full text-gray-800 text-5xl font-bold leading-none tracking-tight mb-4 order-b-2 border-gray-300 focus:outline-none focus:border-blue-600 " type="text" name="judul" id="judul" placeholder="Blog Title..." value="<?= $blog['judul'] ?? '' ?>" required />
            <input type="file" name="image" id="image" style="display: none;" accept="image/*">
            <label for="image">
                <?php if (isset($blog['header_img_path'])): ?>
                    <img id="preview" src="<?= $blog['header_img_path'] ?>" alt="Preview Image" class="mx-5 cursor-pointer">
                <?php else: ?>
                    <img id="preview" src="../asset/images.png" alt="Image Placeholder" class="mx-5 w-full cursor-pointer border border-sm">
                <?php endif; ?>
            </label>
            <div class="w-full text-gray-600 text-normal mx-5">
                <p class="border-b py-3">NOW</p>
            </div>
            <div class="w-full text-gray-600 font-thin italic px-5 pt-3">
                By <strong class="text-gray-700"><?= $_SESSION['username'] ?></strong>
            </div>
            <textarea required class="px-5 w-full text-lg mx-auto resize-none mt-5 h-auto min-h-[500px]" name="isi" placeholder="Blog Content..."><?= $blog['isi'] ?? '' ?></textarea>
            <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">PUBLISH</button>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
                document.getElementById('preview').style.display = 'block';
            }
        });
    </script>
</body>

</html>