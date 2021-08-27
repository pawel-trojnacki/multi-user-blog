<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item me-3 dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="account-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Your account</a>

        <?php if ($isAuthenticated) : ?>
            <ul class="dropdown-menu" aria-labelledby="account-dropdown">
                <li>
                    <a class="dropdown-item" href="/profile">Your profile</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Your posts</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="/logout" , method="POST">
                        <button type="submit" class="dropdown-item d-flex justify-content-between">
                            <span>Log out</span>
                            <i class="bi-box-arrow-in-right"></i>
                        </button>
                    </form>
                </li>
            </ul>

        <?php else : ?>

            <ul class="dropdown-menu" aria-labelledby="account-dropdown">
                <li>
                    <a class="dropdown-item" href="/login">Log in</a>
                </li>
                <li>
                    <a class="dropdown-item" href="/register">Register</a>
                </li>
            </ul>

        <?php endif ?>

    </li>

    <li class="nav-item dropdown me-3">
        <a class="nav-link dropdown-toggle" href="#" id="discover-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Discover</a>
        <ul class="dropdown-menu" aria-labelledby="discover-dropdown">
            <?php foreach ($categories as $cat) : ?>
                <li>
                    <a class="dropdown-item" href="<?php echo $cat['category_name'] ?>">
                        <?php echo $cat['category_name'] ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </li>

    <li class="nav-item me-3">
        <a class="nav-link" href="/publish">Publish</a>
    </li>

</ul>