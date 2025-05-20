<?php
namespace app\controller;

use App\models\entities\Categories;
use App\models\entities\Dish;
use App\models\entities\Table;

class DihsesController
{

    function saveNewDish($resquest){
        $model = new Dish();
        $model->set('nombre', $resquest['namePerson']);
        $model->set('email', $resquest['emailPerson']);
        $model->set('edad', $resquest['agePerson']);
        $res = $model->update();
        return $res ? 'yes' : 'not';
    }
    function updateDish ($resquest){
        $model = new Dish();
        $model->set('id', $resquest['idPerson']);
        $model->set('nombre', $resquest['namePerson']);
        $model->set('email', $resquest['emailPerson']);
        $model->set('edad', $resquest['agePerson']);
        $res = $model->update();
        return $res ? 'yes' : 'not';
    }

   
}