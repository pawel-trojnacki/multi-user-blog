<?php

use App\Components\Form;

$options = $args['options'];
$values = $args['values'] ?? [];
$errors = $args['errors'] ?? [];

$postId = $values['post_id'] ?? false;

$form = new Form($values, $errors);
?>

<h1 class="text-center">Publish your post</h1>

<div class="container-sm my-5">

    <?php $form->start('POST', '', true) ?>

    <div class="row">
        <?php
        if ($postId) {
            $form->hiddenField('post_id', $postId);
        }
        ?>
        <div class="col-xl-8">
            <?php $form->field('Title', 'post_title') ?>
            <?php $form->field('Short description', 'post_description', 'textarea', 'style="height: 80px"') ?>
        </div>
        <div class="col-xl-4">
            <?php $form->select('Category', 'post_category', $options) ?>
            <?php $form->fileField('Featured image', 'post_image', 'accept="image/*"') ?>
        </div>
    </div>

    <?php $form->field('Content', 'post_content', 'textarea') ?>

    <div class="d-flex flex-row-reverse">
        <?php $form->submit('Publish') ?>
    </div>

    <?php $form->end() ?>

    <?php if (isset($errors['upload_file_error'])) : ?>
        <div class="alert alert-danger mt-3">
            <?php echo $errors['upload_file_error'] ?>
        </div>
    <?php endif ?>

</div>