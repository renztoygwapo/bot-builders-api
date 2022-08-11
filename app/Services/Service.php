<?php

namespace App\Services;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class Service
{
    /**
     * Variable that holds the Model Class.
     *
     * @var class
     */
    protected $model;

    /**
     * Register Constant Values.
     */
    // APP
    const AGENT = 'Agent';
    const GEN_COOR = 'General Coordinator';
    const COOR = 'Coordinator';
    const ACTIVE = 1;


    /**
     * Set specified Model for Repository.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = new Repository($model);
    }

    /**
     * This will directly call the model's method without calling model method.
     * Note : It will only called if the method doesn't exist in this class.
     *
     * @param string $method
     * @param $arguments
     * @return void
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->model, $method], $arguments);
    }
}
