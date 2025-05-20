<?php
require_once __DIR__ . '/../models/entities/table.php';

use App\models\entities\Table;

class TableController {

    public function getAll() {
        $table = new Table();
        return $table->all();
    }

    public function find($id) {
        $table = new Table();
        $table->set('id', $id);
        return $table->find();
    }

    public function create($name) {
        $table = new Table();
        $table->set('name', $name);
        return $table->save();
    }

    public function update($id, $name) {
        $table = new Table();
        $table->set('id', $id);
        $table->set('name', $name);
        return $table->update();
    }

    public function delete($id) {
        $table = new Table();
        $table->set('id', $id);
        return $table->delete();
    }

} 