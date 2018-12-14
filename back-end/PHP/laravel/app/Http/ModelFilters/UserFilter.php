<?php namespace App\Http\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function search($value)
    {
        return $this->whereLike('name',$value)->orWhere('email','like','%'.$value.'%');
    }

    public function pageSize($value)
    {
        return $this->take($value);
    }

    public function pageNum($value)
    {
        $pageSize = $this->input('pageSize');
        return $this->skip(($value - 1) * $pageSize);
    }

    public function order($value)
    {
        return $this->latest($value);
    }

    //初始化按时间排序
    public function setUp()
    {
        if (!$this->input('order'))  {
            $this->push('order', 'created_at');
        }
        if(!$this->input('pageSize')){
            $this->push('pageSize', 10);
        }
        if(!$this->input('pageNum')){
            $this->push('pageNum', 1);
        }
    }
}
