<?php

namespace App\Core\Filters;

class UserFilters extends Filters {

    protected $filters = ['blocked'];

    public function blocked($blocked)
    {
        $this->builder->where('status', '=', config('app.status.blocked'));
    }


}
