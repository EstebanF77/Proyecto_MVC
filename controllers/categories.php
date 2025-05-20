<?php
namespace App\controllers;

use App\models\entities\Categories;

class CategoriesController {
    private $categories;

    public function __construct() {
        $this->categories = new Categories();
    }

    public function index() {
        $categories = $this->categories->all();
        require_once 'views/categories/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categories->set('name', $_POST['name']);
            $this->categories->save();
            header('Location: index.php?controller=categories&action=index');
            exit();
        }
        require_once 'views/categories/create.php';
    }

    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categories->set('id', $_POST['id']);
            $this->categories->set('name', $_POST['name']);
            $this->categories->update();
            header('Location: index.php?controller=categories&action=index');
            exit();
        }
        
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->categories->set('id', $id);
            $category = $this->categories->find();
            require_once 'views/categories/edit.php';
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->categories->set('id', $id);
            $this->categories->delete();
        }
        header('Location: index.php?controller=categories&action=index');
        exit();
    }
} 