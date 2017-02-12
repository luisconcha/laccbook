<?php

namespace LaccBook\Repositories;

use LACC\Criteria\CriteriaTrashedInterface;
use LACC\Repositories\Traits\RepositoryRestoreInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BookRepository
 * @package namespace LACC\Repositories;
 */
interface BookRepository extends
    RepositoryInterface,
    RepositoryCriteriaInterface,
    CriteriaTrashedInterface ,
    RepositoryRestoreInterface
{
    //
}
