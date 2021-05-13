<?php

namespace App\Taka\Review;

trait Reviewable
{

    public function getStarsAttribute()
    {
        return [
            'star1' => $this->reviews->where('star', 1)->count(),
            'star2' => $this->reviews->where('star', 2)->count(),
            'star3' => $this->reviews->where('star', 3)->count(),
            'star4' => $this->reviews->where('star', 4)->count(),
            'star5' => $this->reviews->where('star', 5)->count(),
        ];
    }

    public function getReviewedAttribute()
    {
        $user = auth('api')->user();
        if (!$user) {
            return false;
        }

        return !!$user->reviews->where('product_id', $this->id)->first();
    }

    public function getListWaitingForReviewAttribute()
    {
        $user = auth('api')->user();
        if (!$user) {
            return [];
        }

        $productAvailable = $user->order_details->pluck('product_id')->unique();
        $productReviewed = $user->reviews->pluck('product_id')->unique();
        return $productAvailable->diff($productReviewed);
    }
}
