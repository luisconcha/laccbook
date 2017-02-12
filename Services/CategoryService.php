<?php
/**
 * File: CategoryService.php
 * Created by: Luis Alberto Concha Curay.
 * Email: luisconchacuray@gmail.com
 * Language: PHP
 * Date: 04/02/17
 * Time: 17:24
 * Project: lacc_editora
 * Copyright: 2017
 */

namespace LaccBook\Services;

use LACC\Services\BaseService;
use LaccBook\Models\Category;

class CategoryService extends BaseService
{
    /**
     * @var Category
     */
    private $categorymodel;

    public function __construct(Category $category)
    {
        $this->categorymodel = $category;
    }


    public function getListCategoriesInSelect()
    {
        $users = [ '' => '--select an category--' ];
        $users += $this->categorymodel->orderby( 'name', 'asc' )->pluck( 'name','id' )->all();

        return $users;
    }
}