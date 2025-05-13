<?php
namespace app\controller;

use App\models\entities\Categories;
use App\models\entities\Dish;
use App\models\entities\Table;

class CategoriesController
{

    function saveNewCategorie($request){
        $model = new Categories();
        $model->set('nombre', $request['name']);
        $res = $model->save();
        return $res ? 'yes' : 'not';
    }
    function updateCategorie ($request){
        $model = new Categories();
        $model->set('id', $request['idCategorie']);
        $model->set('nombre', $request['name']);
        $res = $model->update();
        return $res ? 'yes' : 'not';
    }

     public function removeCategorie($id){
        $model = new Categories();
         $model->set('id', $id);
        if(empty($model->find())){
            return "empty";
        }
        $res =  $model->delete();
        return $res ? 'yes' : 'not';
    }
}