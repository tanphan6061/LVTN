<?php

namespace App\Taka\Filters;

trait Filterable
{
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }

    public function scopeFilterQ()
    {
        $name = request()->get('q');
        if ($name) {
            return $this->where('name', 'like', "%$name%");
        }
        return $this;
    }
}
