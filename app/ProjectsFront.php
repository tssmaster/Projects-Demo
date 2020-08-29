<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectsFront extends Model
{
    /**
     * Convert array to Eloquent model collection
     *
     */
    public function paginate($items, $itemsTotalCount, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items, $itemsTotalCount, $perPage, $page, $options);
    }
}
