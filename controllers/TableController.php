<?php
require_once 'models/Table.php';

class TableController {
    private $tableModel;

    public function __construct($db) {
        $this->tableModel = new Table($db);
    }

    public function index() {
        $tables = $this->tableModel->getAll();
        require_once 'views/actions/formTables.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $this->tableModel->create($_POST['name']);
            header('Location: index.php?controller=table&action=index');
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['name'])) {
            $this->tableModel->update($_POST['id'], $_POST['name']);
            header('Location: index.php?controller=table&action=index');
            exit();
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $this->tableModel->delete($_POST['id']);
            header('Location: index.php?controller=table&action=index');
            exit();
        }
    }
} 