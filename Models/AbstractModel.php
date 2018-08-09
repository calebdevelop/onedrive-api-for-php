<?php
/**
 * Created by PhpStorm.
 * User: esokia
 * Date: 09/08/18
 * Time: 17:17
 */

namespace Tsk\OneDrive\Models;


abstract class AbstractModel
{
    protected $tzModel;

    public function __construct()
    {
        if (func_num_args() == 1 && is_array(func_get_arg(0))) {
            // Initialize the model with the array's contents.
            $array = func_get_arg(0);
            $this->mapFromArray($array);
        }
    }

    protected function mapFromArray($array)
    {
        $this->tzModel = $array;
        return $array;
    }

    /**
     * @return mixed
     */
    public function getTzModel()
    {
        return $this->tzModel;
    }

}