<?php

namespace App\Http\Services;

use App\Models\Products;
use App\Http\Utils\RequestFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $filter = new RequestFilter($this->request);
        return $filter->apply($builder);
    }
}