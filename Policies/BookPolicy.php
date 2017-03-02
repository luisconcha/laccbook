<?php
namespace LaccBook\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use LaccBook\Models\Book;
use LaccUser\Models\User;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Book $book
     *
     * @return bool
     */
    public function update( User $user, Book $book )
    {
        return $user->id == $book->author_id;
    }
}
