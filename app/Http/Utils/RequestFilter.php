<?php

namespace App\Http\Utils;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RequestFilter
{
    protected $builder;
    protected $request;
    protected $filters = [
        'name' => 'like',
        'category' => '=',
        'min_price' => '>=',
        'max_price' => '<='
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters as $field => $operator) {
            if ($this->request->has($field)) {
                $value = $this->request->query($field);
                
                if ($operator === 'like') {
                    $this->builder->where($field, $operator, '%' . $value . '%');
                } else {
                    $this->builder->where($field, $operator, $value);
                }
            }
        }

        // Ordenação
        $sortBy = $this->request->query('sort_by', 'name');
        $sortOrder = $this->request->query('sort_order', 'asc');
        $this->builder->orderBy($sortBy, $sortOrder);

        return $this->builder;
    }
}