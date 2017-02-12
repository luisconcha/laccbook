<?php

namespace LaccBook\Repositories;

use LACC\Criteria\CriteriaTrashedInterface;
use LACC\Repositories\Traits\RepositoryRestoreInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoryRepository
 * @package namespace LACC\Repositories;
 */
interface CategoryRepository extends
    RepositoryInterface,
    RepositoryCriteriaInterface,
    CriteriaTrashedInterface,
    RepositoryRestoreInterface
{

    public function listsWithMutators($column, $key = null);
}
