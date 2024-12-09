<?php
require 'controller.php';
include '../comment/controller.php';

if (!isset($_GET['id'])) {
    header("Location: ./index.php");
    exit;
}

session_start();
$id = $_GET['id'];
$blog = show($id);
$comments = showComments($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment'])) {
        addComment($id, $_SESSION['id'], $_POST['comment']);
        $comments = showComments($id); // Refresh comments after adding
    }

    if (isset($_POST['delete'])) {
        deleteComment($_POST['id'], $id);
        $comments = showComments($id); // Refresh comments after deleting
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $blog['judul'] ?></title>
    <link href="../asset/css/style.css" rel="stylesheet">
    <script>
        function handleFormSubmit(event, form) {
            event.preventDefault();
            const formData = new FormData(form);
            fetch(form.action, {
                method: form.method,
                body: formData
            }).then(response => response.text()).then(html => {
                document.querySelector('.comments-section').innerHTML = new DOMParser().parseFromString(html, 'text/html').querySelector('.comments-section').innerHTML;
            });
        }
    </script>
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
            <p class="border-b py-3"> <?= nl2br($blog['isi']) ?></p>
        </div>

        <div class="mx-5 comments-section">
            <h3 class="font-bold text-2xl text-gray-800 mt-10">Comments(<?= count($comments) ?>)</h3>
            <?php if (isset($_SESSION['login'])) { ?>
                <form action="" method="post" class="max-w-2xl bg-white rounded-lg border p-2 mx-auto mt-10" onsubmit="handleFormSubmit(event, this)">
                    <div class="px-3 mb-2 mt-2">
                        <textarea placeholder="comment" class="w-full bg-gray-100 rounded border border-gray-400 leading-normal resize-none h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" name="comment"></textarea>
                    </div>
                    <div class="flex justify-end px-4">
                        <input type="submit" class="px-2.5 py-1.5 rounded-md text-white text-sm bg-blue-500 hover:bg-blue-600 focus:outline-none" value="Comment">
                    </div>
                </form>
            <?php } else { ?>
                <p class="text-center text-gray-700 mt-10">You must <a href="../auth/login.php" class="text-blue-500 hover:text-blue-700">login</a> first to write a comment</p>
            <?php }
            foreach ($comments as $comment): ?>
                <div class="border rounded-md p-5 ml-3 my-3">
                    <div class="flex gap-3 items-center">
                        <a href="./author.php?id=<?= $comment['author_id'] ?>" class="text-md text-gray-900 hover:text-blue-600">
                            <h3 class="font-bold text-lg">
                                - <?= $comment['author_username'] ?>
                            </h3>
                        </a>
                        <p class="text-sm text-gray-500">
                            Posted on <?= date('d F Y, H:i', strtotime($comment['created_at'])) ?>
                        </p>
                    </div>

                    <p class="text-gray-900 mt-2">
                        <?= nl2br($comment['comment']) ?>
                    </p>
                    <?php if (isset($_SESSION['login']) && validateCommenter($comment['id'], $_SESSION['id'])): ?>
                        <form action="" method="post" class="flex justify-end mt-3">
                            <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                            <button type="submit" class="px-2.5 py-1.5 rounded-md text-gray-700 text-sm hover:text-red-500 focus:outline-none" name="delete">Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>