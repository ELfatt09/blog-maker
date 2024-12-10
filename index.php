<?php
session_start();
include 'database/connection.php';
$query = "SELECT b.id, b.judul, b.type, b.header_img_path, b.isi, b.author_id, b.created_at, a.username AS author_username
          FROM blog b
          JOIN accounts a ON b.author_id = a.id
          ORDER BY b.created_at DESC LIMIT 3";
$blogs = $conn->query($query)->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepage</title>
    <link rel="stylesheet" href="./asset/css/style.css">
</head>

<body> <?php include './layout/header.php' ?>
    <!-- component -->
    <section class="py-24 flex items-center min-h-screen justify-center bg-white">
        <div class="mx-auto max-w-[43rem] md:max-w-[600px] lg:max-w-[800px]">
            <div class="text-center">
                <p class="text-lg font-medium leading-8 text-blue-600/95">Introducing Modern blog maker</p>
                <h1 class="mt-3 text-[3.5rem] md:text-[4.5rem] font-bold leading-[4rem] tracking-tight text-black">Change your mind into blog</h1>
                <p class=" text-lg leading-relaxed text-slate-400 mt-5">Think, Type, <b class="text-blue-600/95">Publish!!</b></p>
            </div>

            <div class="mt-6 flex items-center justify-center gap-4">
                <?php if (!isset($_SESSION['login'])) : ?>
                    <a href="./auth/register.php" class="px-5 py-3 text-center bg-blue-600 text-white rounded-md hover:bg-transparent hover:text-blue-600 hover:border-2 hover:border-blue-600">Register Now</a>
                    <a href="./auth/login.php" class="transform rounded-md border border-slate-200 px-5 py-3 font-medium text-slate-900 transition-colors hover:bg-slate-50"> Login </a>
                <?php else : ?>
                    <a href="./blogs/form.php" class="px-5 py-3 text-center bg-blue-600 text-white rounded-md hover:bg-transparent hover:text-blue-600 hover:border-2 hover:border-blue-600">Create your blog now</a>
                    <a href="./blogs/index.php" class="transform rounded-md border border-slate-200 px-5 py-3 font-medium text-slate-900 transition-colors hover:bg-slate-50"> Read now </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- ====== Blog Section Start -->
    <section class="pt-3
 pb-10 lg:pb-20 w-full items-center flex justify-center">
        <div class="container">
            <div class="flex flex-wrap justify-center -mx-4">
                <div class="w-full px-4">
                    <div class="text-center mx-auto mb-[60px] lg:mb-20 max-w-[510px]">
                        <span class="font-semibold text-lg text-blue-500 mb-2 block">
                            Our Blogs
                        </span>
                        <h2
                            class="
                  font-bold
                  text-3xl
                  sm:text-4xl
                  md:text-[40px]
                  text-dark
                  mb-4
                  ">
                            Our Recent Blogs
                        </h2>
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
                                <div class="flex flex-col">
                                    <?php if (!is_null($blog['header_img_path']) && !empty($blog['header_img_path'])) { ?>
                                        <img src="<?= $blog['header_img_path'] ?>" alt="image" class="h-[250px] w-full sm:w-[250px] md:w-full rounded-lg object-cover mb-4">
                                    <?php } ?>
                                    <div>
                                        <h3 class="text-2xl font-semibold tracking-tight mb-4">
                                            <a href="./blogs/show.php?id=<?= $blog['id'] ?>" class="hover:text-blue-500">
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
                                                <a href="./blogs/author.php?id=<?= $blog['author_id'] ?>" class="hover:text-blue-500">
                                                    <?= $blog['author_username'] ?>
                                                </a>
                                            </p>
                                        </div>
                                        <p class="text-gray-600 mb-4">
                                            <?= substr($blog['isi'], 0, 80) . '...' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- ====== Blog Section End -->
</body>

</html>