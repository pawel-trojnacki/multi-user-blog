<?php

use App\Components\Form;

$user = $args['user'];
$values = $args['values'];
$values['user_description'] ??= $user['user_description'];

$errors = $args['errors'] ?? [];

?>
<div class="container-sm">
    <header class="mb-5">
        <h1>Hello, <?php echo $user['user_name'] ?></h1>
    </header>

    <div class="row g-5">
        <div class="col-md-4 col-xl-3">
            <div class="pe-md-2 pe-xl-3">
                <div class="mb-4">
                    <img class="image-cover" src="<?php echo $user['user_avatar'] ?>" alt="user avatar">
                </div>
                <h2 class="fs-5 mb-4">Set avatar</h2>
                <?php
                $form = new Form($values, $errors);
                $form->start('POST', '/update-user-avatar', true);
                $form->fileField('Avatar', 'avatar', 'accept="image/*"');
                $form->submit('Save');
                $form->end();
                ?>
            </div>

        </div>

        <div class="col-md-8 col-xl-6">

            <section class="mb-5">
                <h2 class="fs-5 mb-4">Edit description</h2>

                <?php
                $form = new Form($values, $errors);
                $form->start('POST', '/update-user-description');
                $form->field('Description', 'user_description', 'textarea', 'style="height: 100px"');
                $form->submit('Save');
                $form->end();
                ?>

                <?php if (isset($errors['upload_file_error'])) : ?>
                    <p class="text-danger mt-3">
                        <?php echo $errors['upload_file_error'] ?>
                    </p>
                <?php endif ?>

            </section>

            <section>
                <h2 class="fs-5 mb-4">Change password</h2>

                <?php
                $form = new Form($values, $errors);
                $form->start('POST', 'update-user-password');
                $form->field('Password', 'password', 'password');
                $form->field('Repeat password', 'password_repeat', 'password');
                $form->submit('Save');
                $form->end();
                ?>

            </section>

        </div>

    </div>

</div>