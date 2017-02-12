<?php

namespace LaccBook\Repositories;

use LACC\Criteria\CriteriaTrashedTrait;
use LaccBook\Models\Book;
use LACC\Repositories\Traits\BaseRepositoryTrait;
use LACC\Repositories\Traits\RepositoryRestoreTrait;
use LaccBook\Repositories\BookRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BookRepositoryEloquent
 * @package namespace LACC\Repositories;
 */
class BookRepositoryEloquent extends BaseRepository implements BookRepository
{
    use BaseRepositoryTrait,
        CriteriaTrashedTrait,
        RepositoryRestoreTrait;

    protected $fieldSearchable = [
        'id',
        'title'           => 'like',
        'price',
        'categories.name' => 'like',
        'author.name'     => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    /**
     * Função que sobreescreve o method CREATE do repository para poder fazer o sync e salvar
     * na tbl pivot
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $model = parent::create($attributes);
        $model->categories()->sync( $attributes['categories'] );

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);
        $model->categories()->sync( $attributes['categories'] );

        return $model;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
/**
 *  Exemplos de como implementar Criteria (orderBy asc é padrão):
 *
 * a) Procura pelo id do author = a 5
 *   http://editora.dev/books?search=5&searchFields=author_id:=
 *
 * b) Procura pelo titulo utilizando like (search=Re)
 *  http://editora.dev/books?search=Re&searchFields=title:like
 *
 * c) Abreviar o search e já definir como like:
 *   protected $fieldSearchable = [
 *    'title' => 'like',
 *   ];
 * d) Para procurar por algum campo no relacionamento, se coloca o nome do relacionamento
 *    (author) seguido pelo nome do campo procurado
 *   protected $fieldSearchable = [
 *       'title' => 'like',
 *       'author.name'
 *   ];
 * e) Delimitar a procura fazendo combinações
 *    http://editora.dev/books?search=title:p;author.name:Luis&searchFields=title:=;author.name:like
 *    http://editora.dev/books?search=title:p;price:9491&searchFields=title:=;price:=
 *
 * f) Ordenar a busca por coluna determinada
 *    http://editora.dev/books?orderBy=title
 *    http://editora.dev/books?orderBy=id&sortedBy=desc
 *    http://editora.dev/books?orderBy=price&sortedBy=desc
 *
 *    Ordenar utilizando coluna com chave estrangeira
 *    http://editora.dev/books?orderBy=users:author_id|name&sortedBy=desc
 *
 * g) Filtrar o retorno da consulta com colunas determinadas; lembrando que se tem coluna relacionada
 *    o campo tem que ser ternonado caso ela esteja sendo renderizada na view
 *
 *    http://editora.dev/books?filter=title;author_id;category_id
 */
