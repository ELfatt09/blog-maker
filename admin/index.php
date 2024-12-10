<?php
session_start();
require '../blogs/controller.php';
require '../comment/controller.php';
require '../account/controller.php';
if ($_SESSION['is_admin'] != 1 || $_SESSION['login'] != 1) {
    header("Location: ../index.php");
    exit;
}
if (isset($_GET['deleteComment'])) {
    $commentId = $_GET['deleteComment'];
    deleteComment($commentId);
}
if (isset($_GET['setorunsetadmin'])) {
    $setorunsetadmin = $_GET['setorunsetadmin'];
    setOrUnsetAdmin($setorunsetadmin);
}
if (isset($_GET['deleteUser'])) {
    $userId = $_GET['deleteUser'];
    deleteUser($userId);
}
$blogs = all();
$users = allUser();
$comments = allComments();
?>
<!DOCTYPE html>
<html lang="en"
    class="scroll-smooth bg-gray-100 text-gray-800 font-sans leading-normal">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
    <link href="../asset/css/style.css" rel="stylesheet">
</head>

<body class="h-screen">
    <?php include '../layout/header.php'; ?>
    <div class="container mx-auto p-4">
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
                  ">
                        Blogs Control Table
                    </h2>
                    <hr class="border-t-4 border-emerald-500 my-4">
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 mb-10">
                <thead class="text-xs text-gray-800 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            judul
                        </th>
                        <th scope="col" class="px-6 py-3">
                            type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            author
                        </th>
                        <th scope="col" class="px-6 py-3">
                            header_img_path
                        </th>
                        <th scope="col" class="px-6 py-3">
                            isi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            created_at
                        </th>
                        <th scope="col" class="px-6 py-3">
                            aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blogs as $blog) : ?>
                        <tr class="odd:bg-white  even:bg-gray-50 border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?= $blog['id'] ?>
                            </th>
                            <td class="px-6 py-4">
                                <a href="../blogs/show.php?id=<?= $blog['id'] ?>" class="text-emerald-700 hover:text-emerald-900"><?= $blog['judul'] ?></a>
                            </td>
                            <td class="px-6 py-4">
                                <?= $blog['type'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $blog['author_username'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($blog['header_img_path'] !== null) : ?>
                                    <a href="<?= $blog['header_img_path'] ?>" class="text-emerald-700 hover:text-emerald-900"><?= basename($blog['header_img_path']) ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= substr($blog['isi'], 0, 80) . '...' ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $blog['created_at'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if (validateAuthor($blog['id'], $_SESSION['id'])) { ?>
                                    <a href="../blogs/form.php?update=<?= $blog['id'] ?>" class="text-emerald-700 hover:text-emerald-900 hover:underline mr-4">update</a>
                                    <a href="../blogs/delete.php?id=<?= $blog['id'] ?>" class="text-emerald-700 hover:text-emerald-900 hover:underline">delete</a>
                                <?php } else { ?>
                                    <p class="text-gray-600">not authorized</p>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="flex flex-wrap justify-center -mx-4 mt-10">
            <div class="w-full px-4">
                <div class="text-center mx-auto mb-2 mt-8 lg:mt-16 lg:mb-4 max-w-[510px]">
                    <h2
                        class="
                  font-bold
                  text-3xl
                  sm:text-4xl
                  md:text-[40px]
                  text-dark
                  ">
                        User Control Table
                    </h2>
                    <hr class="border-t-4 border-emerald-500 my-4">
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-800 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            username
                        </th>
                        <th scope="col" class="px-6 py-3">
                            is_admin
                        </th>
                        <th scope="col" class="px-6 py-3">
                            aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr class="odd:bg-white  even:bg-gray-50 border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?= $user['id'] ?>
                            </th>
                            <td class="px-6 py-4">
                                <?= $user['username'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= $user['is_admin'] ? 'true' : 'false' ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($_SESSION['is_admin'] == 1 && $user['id'] != $_SESSION['id']) { ?>
                                    <a href="?setorunsetadmin=<?= $user['id'] ?>" class="text-emerald-700 hover:text-emerald-900 hover:underline">
                                        <?= $user['is_admin'] ? 'unset' : 'set' ?> admin
                                    </a>
                                    <a href="?deleteUser=<?= $user['id'] ?>" class="text-emerald-700 hover:text-emerald-900 hover:underline ml-4">delete</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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
                  ">
                        Comments Control Table
                    </h2>
                    <hr class="border-t-4 border-emerald-500 my-4">
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-800 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            blog
                        </th>
                        <th scope="col" class="px-6 py-3">
                            author
                        </th>
                        <th scope="col" class="px-6 py-3">
                            comment
                        </th>
                        <th scope="col" class="px-6 py-3">
                            aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment) : ?>
                        <tr class="odd:bg-white even:bg-gray-50 border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <?= $comment['id'] ?>
                            </th>
                            <td class="px-6 py-4">
                                <a href="../blogs/show.php?id=<?= $comment['blog_id'] ?>" class="text-emerald-700 hover:text-emerald-900"><?= htmlspecialchars($comment['blog_title'], ENT_QUOTES) ?></a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="../blogs/author.php?id=<?= $comment['author_id'] ?>" class="text-emerald-700 hover:text-emerald-900">
                                    <?= htmlspecialchars($comment['author_username'], ENT_QUOTES) ?>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($comment['comment'], ENT_QUOTES) ?>
                            </td>
                            <td class="px-6 py-4 flex items-center">
                                <?php if ($_SESSION['is_admin'] == 1 || $comment['author_id'] == $_SESSION['id']) { ?>
                                    <a href="?deleteComment=<?= $comment['id'] ?>" class="text-emerald-700 hover:text-emerald-900 hover:underline">
                                        delete
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</html>