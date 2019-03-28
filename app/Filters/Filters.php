<?php 

namespace App\Filters;

use Illuminate\Http\Request;


abstract class Filters  
{
    protected $request, $builder;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply ($builder) {

        $this->builder = $builder;

        $this->getFilters()
            ->filter(function ($filter) {
                return method_exists($this, $filter);
            })
            ->each(function ($filter, $value) {
                $this->$filter($value);
            });

        return $this->builder;
        
    }

    protected function getFilters () {
        return collect( collect($this->request)->filter(function ($value, $key) {
            return in_array($key, $this->filters);
        }))->flip();
    }

}