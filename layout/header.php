<nav class="sticky top-0 flex w-full justify-center py-3 px-3 items-center shadow-md bg-white z-10">
    <?php if (!isset($_SESSION['login'])) : ?>
        <a href="<?= $_SERVER['PHP_SELF'] === '/index.php' ? './auth/login.php' : '../auth/login.php' ?>" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
            Login
        </a>
        <a href="<?= $_SERVER['PHP_SELF'] === '/index.php' ? './auth/register.php' : '../auth/register.php' ?>" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
            Register
        </a>
    <?php else: ?>
        <a href="<?= $_SERVER['PHP_SELF'] === '/index.php' ? './auth/logout.php' : '../auth/logout.php' ?>" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
            Logout
        </a>
        <a href="<?= $_SERVER['PHP_SELF'] === '/index.php' ? './blogs/index.php' : '../blogs/index.php' ?>" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
            Blogs
        </a>
        <a href="<?= $_SERVER['PHP_SELF'] === '/index.php' ? './blogs/form.php' : '../blogs/form.php' ?>" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
            Create Blog
        </a>
        <?php if ($_SESSION['is_admin']): ?>
            <a href="<?= $_SERVER['PHP_SELF'] === '/index.php' ? './admin/index.php' : '../admin/index.php' ?>" class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                Admin Panel
            </a>
        <?php endif; ?>
    <?php endif; ?>
</nav>
