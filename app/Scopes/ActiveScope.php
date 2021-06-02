<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $class_name = class_basename($model);
        if ($class_name == "Product") {
            $builder->where('products.is_deleted', 0);
        } else {
            $builder->where('is_deleted', 0);
        }

    }
}
