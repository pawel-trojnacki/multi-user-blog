<?php

use App\Components\NavTabs;
use App\Components\Form;

$errors = $args['errors'] ?? [];
$values = $args['values'] ?? [];

$crredentialsError = $errors['invalid_credentials'] ?? false;

$navTabs = new NavTabs;
$form = new Form($values, $errors);

?>

<h1 class="text-center">Log in</h1>

<div class="container-slim">
    <?php
    $navTabs->start();
    $navTabs->tab('/register', 'Register');
    $navTabs->tab('#', 'Log in', true);
    $navTabs->end()
    ?>

    <?php $form->start();
    $form->field('Username or email', 'name');
    $form->field('Password', 'password', 'password');
    ?>
    <div class="d-grid">
        <?php $form->submit('Log in') ?>
    </div>
    <?php $form->end() ?>

    <?php if ($crredentialsError) : ?>
        <p class="mt-3 text-danger">Invalid credentials</p>
    <?php endif ?>

</div>