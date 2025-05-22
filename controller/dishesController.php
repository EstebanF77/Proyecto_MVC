<?php
namespace app\controller;


use App\models\entities\Dish;



    class DishesController
{
   
    public function getAllDishes()
    {
        $dish = new Dish();
        return $dish->all();
    }

  
    public function saveNewDish($data)
    {
        if (empty($data['descriptionDish']) || empty($data['unitPrice']) || empty($data['categories'])) {
            return 'error';
        }

        $dish = new Dish();
        $dish->set('description', $data['descriptionDish']);
        $dish->set('price', $data['unitPrice']);
        $dish->set('idCategory', $data['categories']);

        return $dish->save() ? 'yes' : 'error';
    }

    public function updateDish($data)
    {
        if (empty($data['id']) || empty($data['descriptionDish']) || empty($data['unitPrice'])) {
            return 'error';
        }

        $dish = new Dish();
        $dish->set('id', $data['id']);
        $dish->set('description', $data['descriptionDish']);
        $dish->set('price', $data['unitPrice']);

        return $dish->update() ? 'yes' : 'error';
    }


    public function deleteDish($id)
    {
        if (!$id) return 'error';

    $dish = new Dish();
    $dish->set('id', $id);
    return $dish->delete(); 
    }

    
    public function getDishById($id)
    {
        $dish = new Dish();
        $dish->set('id', $id);
        return $dish->find();
    }
}
