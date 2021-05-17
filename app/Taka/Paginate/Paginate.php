<?php

namespace App\Taka\Paginate;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Paginate
{
    protected $data;
    protected $total;

    public function __construct(Builder $builder, $page = 1, $limit = 20)
    {
        //$offset = request()->offset ?? $offset;
        $limit = request()->offset ?? $limit;
        $page = request()->page ?? $page;
        $limit = $limit > 0 ? $limit : 20;
        $page = $page > 0 ? $page : 1;
        $offset = ($page - 1) * $limit;
        //DB::enableQueryLog();
        $this->total = $builder->get()->count();
        //dd(DB::getQueryLog());
        $this->data = $builder->latest()->skip($offset)->take($limit)->get();
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getData()
    {
        return $this->data;
    }

}
