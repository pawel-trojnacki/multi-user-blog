<?php

namespace App\Controllers;

class NotFoundController extends MainControllerAbstract
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): void
    {
        $this->render('404');
    }
}
