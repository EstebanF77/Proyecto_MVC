<?php
namespace app\controller;

use App\models\entities\Categories;
use App\models\entities\Dish;
use App\models\entities\Table;

class CategoriesController
{
    
    public function getAllCategories() 
    {
        $model = new Categories();       
        $categories = $model->all();    
        return $categories;
    }

    public function getCategoryById($id)
    {
        $model = new Categories();
        $model->set('id', $id);
        return $model->find();
    }

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
        
        // Verificar si la categoría existe
        if(empty($model->find())){
            return "empty";
        }

        // Verificar si hay platos asociados a esta categoría
        $dishModel = new Dish();
        $dishes = $dishModel->all();
        foreach($dishes as $dish) {
            if($dish->get('idCategory') == $id) {
                return "has_dishes"; // No se puede eliminar porque tiene platos asociados
            }
        }

        // Si no hay platos asociados, proceder con la eliminación
        $res = $model->delete();
        return $res ? 'yes' : 'not';
    }
}