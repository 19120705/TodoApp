<?php

class HomeController extends BaseController
{
    
    public function index()
    {
       
    }
    public function show()
    {
        return $this->view('pages.home');
    }
}