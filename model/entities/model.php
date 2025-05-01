<?php
namespace App\model;

abstract class Model{

    abstract function all();
    abstract function save();
    abstract function update();
    abstract function delete();

    public function get($nameProp){
        $this->{$nameProp};
    }

    public function set($nameProp, $value)
    {
        $this->{$nameProp} = $value;
    }

}