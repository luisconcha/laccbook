@extends('layouts.app')

@section('title')
    Trash Books
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h3>List of books in the trash</h3>

            {!! Form::model(compact($search), ['class' => 'form-search', 'method' => 'GET']) !!}
            <div class="input-group">
                <span class="input-group-btn">
                    {!! Form::submit('Search by:', ['class'=>'btn btn-warning']) !!}
                </span>
                {!! Form::text('search', null, ['placeholder'=> ($search) ? $search : 'id, title or categories','class'=>'form-control']) !!}
                <span class="input-group-btn">
                    <a href="{{ route( 'books.index' )  }}" class="btn btn-primary">
Return to the active books</a>
                </span>
            </div>
            {!! Form::close() !!}

        </div>


        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Categories</th>
                    <th>Creation date</th>
                    <th>Update date</th>
                    <th>Date of removal</th>
                </tr>
                </thead>
                <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->categories->implode('name_trashed',',') }}</td>
                        <td>{{ $book->created_at }}</td>
                        <td>{{ $book->updated_at }}</td>
                        <td>{{ $book->deleted_at }}</td>
                        <td>
                            <a href="{{route('trashed.categories.restore',['id'=>$book->id])}}"
                               class="btn btn-danger btn-outline btn-xs"
                               onclick="event.preventDefault();document.getElementById('restore').submit();">
                                <strong>Restore</strong>
                            </a>
                            {!! Form::open(['route' => ['trashed.books.restore', 'book' =>$book->id],'method'=>'GET', 'id' => 'restore', 'style' => 'display:none']) !!}
                            {!! Form::hidden('redirect_to', URL::previous()) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center"><span class="label label-warning">No records</span></td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="text-center">{{ $books->links() }}</div>
        </div>
    </div>
@endsection