<?php
namespace app\controller;

use App\models\entities\Categories;
use App\models\entities\Dish;
use App\models\entities\Table;

class CategoriesController
{
    private $categories;

    public function __construct() {
        $this->categories = new Categories();
    }

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
        $model->set('name', $request['name']);
        $res = $model->save();
        return $res ? 'yes' : 'not';
    }
    function updateCategorie ($request){
        $model = new Categories();
        $model->set('id', $request['idCategorie']);
        $model->set('name', $request['name']);
        $res = $model->update();
        return $res ? 'yes' : 'not';
    }

    public function removeCategorie($id){

        $hasDishes = $this->categories->hasAssociatedDishes($id);
        
        if ($hasDishes) {
            return 'has_dishes';
        }
        
        $this->categories->set('id', $id);
        return $this->categories->delete() ? 'yes' : 'error';
    }
}