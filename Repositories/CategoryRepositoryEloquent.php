<?php

namespace LaccBook\Repositories;

use Illuminate\Database\Eloquent\Collection;
use LACC\Criteria\CriteriaTrashedTrait;
use LaccBook\Models\Category;
use LACC\Repositories\Traits\BaseRepositoryTrait;
use LACC\Repositories\Traits\RepositoryRestoreTrait;
use LaccBook\Repositories\CategoryRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CategoryRepositoryEloquent
 * @package namespace LACC\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    use BaseRepositoryTrait,
        CriteriaTrashedTrait,
        RepositoryRestoreTrait;


    protected $fieldSearchable = [
        'id',
        'name' => 'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }


    /**
     * @param $column
     * @param null $key
     * @return \Illuminate\Support\Collection
     */
    public function listsWithMutators($column, $key = null)
    {
        /** @var  Collection $collection */
        $collection = $this->all();
        return $collection->pluck( $column, $key );
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
