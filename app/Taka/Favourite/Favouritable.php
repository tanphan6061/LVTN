<?php

namespace App\Taka\Favourite;

trait Favouritable
{

    public function getFavouritedAttribute()
    {
        $user = auth('api')->user();
        if (!$user) {
            return false;
        }

        $favourites = $user->favourites->where('is_deleted', 0)->pluck('product_id')->toArray();
        return in_array($this->id, $favourites);
    }
}
