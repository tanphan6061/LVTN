<?php

namespace App\Taka\Filters;

trait Filterable
{
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }

    public function scopeFilterQ($query)
    {
        $name = request()->get('q');
        if ($name) {
            return $query->where('name', 'like', "%$name%");
        }
        return $query;
    }
}
