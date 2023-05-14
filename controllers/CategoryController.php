<?php

class CategoryController extends BaseController
{
    private $categoryModel;
    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }
    
    public function index()
    {
        $categories = $this->categoryModel->getAllCategory();
         
        return $this->view('categories.index',['categories' => $categories]);
    }
    public function show()
    {
        $id = $_GET['id'];
        $category = $this->categoryModel->getOneCategory($id);
        echo '<pre>';
        print_r($category);
    }
}