<?php

namespace App\Taka\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use ReflectionClass;

class Filter
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getMethods()
    {
        $class = new ReflectionClass(static::class);
        $methods = array_map(function ($method) use ($class) {
            return $method->class == $class->getName() ? $method->getName() : null;
        }, $class->getMethods());
        return array_filter($methods);
    }

    public function getFilters()
    {
        return array_filter($this->request->only($this->getMethods()));
    }


    public function apply(Builder $builder)
    {
        $states = $this->getFilters();
        //dd($states);
        $this->builder = $builder;
        foreach ($states as $method_name => $value) {
            if (method_exists($this, $method_name)) {
                if ($value) {
                    $this->$method_name($value);
                } else {
                    $this->$method_name();
                }
            }
        }

        return $this->response();
    }

    protected function response()
    {
        return $this->builder;
    }
}
