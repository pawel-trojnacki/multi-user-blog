<header class="container-sm mb-5">
    <div class="row">
        <div class="col-lg-4">
            <img class="img-fluid mb-3" src="<?php echo $user['user_avatar'] ?>" alt="user avatar">
        </div>
        <div class="col-lg-8 ps-lg-4">
            <h1 class="fs-2 my-3"><?php echo $user['user_name'] ?></h1>
            <a class="d-inline-block mb-2" href="<?php echo 'mailto:' . $user['user_email'] ?>"><?php echo $user['user_email'] ?></a>
            <p class="text-muted">Medium member since <?php echo $user['user_date'] ?></p>
        </div>
    </div>
    <p class="lead my-3"><?php echo $user['user_description'] ?></p>
</header>