<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BrandFilter extends QueryFilter
{

    const ITEMS_PER_PAGE = 10;

    public function name($search){
        $search = ('%'.$search.'%');
        $this->builder
            ->where('name', 'like', $search)
            ->orWhereHas('cars', fn (Builder $query) => $query->where('name', 'like', $search ));
    }

    public function createdBy($id){
        $this->builder
            ->where('created_by','=', $id);
    }
}
