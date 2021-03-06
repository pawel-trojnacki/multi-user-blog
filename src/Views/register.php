<?php

use App\Components\NavTabs;
use App\Components\Form;

$errors = $args['errors'] ?? [];
$values = $args['values'] ?? [];
$success = $args['success'] ?? false;

$existingUserError = $errors['is_existing'] ?? false;

$navTabs = new NavTabs;
$form = new Form($values, $errors);

?>

<h1 class="text-center">Create account</h1>

<div class="container-slim">
    <?php
    $navTabs->start();
    $navTabs->tab('#', 'Register', true);
    $navTabs->tab('/login', 'Log in');
    $navTabs->end()
    ?>

    <?php $form->start();
    $form->field('Username', 'username');
    $form->field('Email address', 'email', 'email');
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $form->field('Password', 'password', 'password') ?>

        </div>
        <div class="col-sm-6">
            <?php $form->field('Repeat password', 'password_repeat', 'password') ?>
        </div>
    </div>
    <div class="d-grid">
        <?php $form->submit('Create account') ?>
    </div>
    <?php $form->end() ?>

    <?php if ($existingUserError) : ?>
        <p class="text-danger mt-3">
            User with this username or email already exists.
        </p>
    <?php endif ?>

    <?php if ($success) : ?>
        <p class="text-success mt-3">Registration completed. You can now <a href="/login" style="text-decoration: underline;">log in</a></p>
    <?php endif ?>

</div>