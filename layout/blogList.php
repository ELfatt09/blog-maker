<div class="flex flex-wrap justify-center -mx-4">
    <?php if (empty($blogs)) : ?>
        <p class="text-center">No blogs found.</p>
    <?php else : ?>
        <?php foreach ($blogs as $blog) : ?>
            <div class="w-full sm:w-1/2 lg:w-1/3 px-4 mb-6">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <a href="./index.php?type=<?= $blog['type'] ?>">
                        <h5 class="text-sm uppercase font-bold tracking-widest text-blue-500 mb-2"><?= $blog['type'] ?></h5>
                    </a>
                    <div class="flex flex-col">
                        <?php if (!is_null($blog['header_img_path']) && !empty($blog['header_img_path'])) { ?>
                            <a href="./show.php?id=<?= $blog['id'] ?>" class="hover:text-blue-500">
                                <img src="<?= $blog['header_img_path'] ?>" alt="image" class="h-[250px] w-full sm:w-[250px] md:w-full rounded-lg object-cover mb-4">
                            </a>
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
                            <div class="mt-4 flex space-x-2 text-sm font-semibold">
                                <a href="./show.php?id=<?= $blog['id'] ?>" class="focus:shadow-outline hover:text-blue-500 transition duration-150 ease-in-out">
                                    Read
                                </a>
                                <?php if (validateAuthor($blog['id'], $_SESSION['id'])) : ?>
                                    <a href="./form.php?update=<?= $blog['id'] ?>" class="focus:shadow-outline hover:text-blue-500 transition duration-150 ease-in-out">
                                        Update
                                    </a>
                                    <a href="./delete.php?id=<?= $blog['id'] ?>" class="focus:shadow-outline hover:text-red-700 transition duration-150 ease-in-out">
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>