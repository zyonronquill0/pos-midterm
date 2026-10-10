<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home - POS System'
        ];
        return view('pages/home', $data);
    }

    public function about(): string
    {
        $data = [
            'title' => 'About - POS System'
        ];
        return view('pages/about', $data);
    }
}