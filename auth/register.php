<?php
require 'controller.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    register($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="../asset/css/style.css" rel="stylesheet">

</head>

<body> <?php include '../layout/header.php' ?>
    <!-- component -->
    <div class="min-h-screen py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xxl sm:mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-300 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>
            <div class="relative px-5 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-12 md:w-full">
                <div class="w-xl mx-auto">
                    <div>
                        <h1 class="text-2xl font-semibold text-center">Register Form</h1>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <form action="register.php" method="post" class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <div class="relative mt-4">
                                <input autocomplete="off" id="username" name="username" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Username" />
                                <label for="username" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Username</label>
                            </div>
                            <div class="relative mt-4">
                                <input autocomplete="off" id="password" name="password" type="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Password" />
                                <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                            </div>
                            <div class="relative mt-4">
                                <button type="submit" class="w-full text-center bg-blue-500 text-white rounded-md px-auto py-2 hover:bg-white hover:text-blue-500 hover:borderborder-blue-500">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>