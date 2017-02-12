@extends('layouts.app')

@section('title')
    Trash Categories
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h3>List of categories in the trash</h3>

            {!! Form::model(compact($search), ['class' => 'form-search', 'method' => 'GET']) !!}
            <div class="input-group">
                <span class="input-group-btn">
                    {!! Form::submit('Search by:', ['class'=>'btn btn-warning']) !!}
                </span>
                {!! Form::text('search', null, ['placeholder'=> ($search) ? $search : 'id, name','class'=>'form-control']) !!}
                <span class="input-group-btn">
                    <a href="{{ route( 'categories.index' )  }}" class="btn btn-primary">
Return to the active categories</a>
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
                    <th>Creation date</th>
                    <th>Update date</th>
                    <th>Date of removal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>{{ $category->deleted_at }}</td>
                        <td>
                            <a href="{{route('trashed.categories.restore',['id'=>$category->id])}}"
                               class="btn btn-danger btn-outline btn-xs"
                               onclick="event.preventDefault();document.getElementById('restore').submit();">
                                <strong>Restore</strong>
                            </a>
                            {!! Form::open(['route' => ['trashed.categories.restore', 'book' =>$category->id],'method'=>'GET', 'id' => 'restore', 'style' => 'display:none']) !!}
                            {!! Form::hidden('redirect_to', URL::previous()) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="text-center">{{ $categories->links() }}</div>
        </div>
    </div>
@endsection