@extends('layouts.app')

@section('title')
    List of Books
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h3>List of books</h3>

            {!! Form::model(compact($search), ['class' => 'form-search', 'method' => 'GET']) !!}
            <div class="input-group">
                <span class="input-group-btn">
                    {!! Form::submit('Search by:', ['class'=>'btn btn-warning']) !!}
                </span>
                {!! Form::text('search', null, ['placeholder'=> ($search) ? $search : 'id, title, author, price or categories','class'=>'form-control']) !!}
                <span class="input-group-btn">
                    <a href="{{ route( 'books.create' )  }}" class="btn btn-primary">New book</a>
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
                    <th>Price</th>
                    <th>Author</th>
                    <th>Categories</th>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->price }}</td>
                        <td>{{ $book->author->name }}</td>
                        <td>{{ $book->categories->implode('name_trashed',',') }}</td>
                        <td>
                            <a href="{{route('books.edit',['id'=>$book->id])}}"
                               class="btn btn-warning btn-outline btn-xs">
                                <strong>Edit</strong>
                            </a>
                            <a href="{{route('books.detail',['id'=>$book->id])}}"
                               class="btn btn-info btn-outline btn-xs">
                                <strong>Detail</strong>
                            </a>
                            <a href="{{route('books.destroy',['id'=>$book->id])}}"
                               class="btn btn-danger btn-outline btn-xs">
                                <strong>Send to trash</strong>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-center">{{ $books->links() }}</div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection