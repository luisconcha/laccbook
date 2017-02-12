@extends('layouts.app')

@section('title')
    List of Category
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h3>List of categories</h3>

            {!! Form::model(compact($search), ['class' => 'form-search', 'method' => 'GET']) !!}
            <div class="input-group">
                <span class="input-group-btn">
                    {!! Form::submit('Search by:', ['class'=>'btn btn-warning']) !!}
                </span>
                {!! Form::text('search', null, ['placeholder'=> ($search) ? $search : 'id, or name','class'=>'form-control']) !!}
                <span class="input-group-btn">
                    <a href="{{ route( 'categories.create' )  }}" class="btn btn-primary">New category</a>
                </span>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{route('categories.edit',['id'=>$category->id])}}"
                               class="btn btn-warning btn-outline btn-xs">
                                <strong>Edit</strong>
                            </a>
                            <a href="{{route('categories.destroy',['id'=>$category->id])}}"
                               class="btn btn-danger btn-outline btn-xs">
                                <strong>Send to trash</strong>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-center">{{ $categories->links() }}</div>

        </div>
    </div>
@endsection
