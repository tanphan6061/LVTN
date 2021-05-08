<?php

namespace App\Taka\Filters;

trait Filterable
{
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }
}
