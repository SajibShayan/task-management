<?php

namespace App\Contract\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllTask(?int $limit = 3, ?string $status = null): Collection|Paginator;
}
