@extends('layouts.app')

@section('title')
    Edit Book
@endsection

@section('content')
    <div class="container">
        <h1>Edit book: <strong><b>{{ $book->title }}</b></strong></h1>

        @include('errors._check')
        
        {!! Form::model($book,['route'=>['books.update','id'=>$book->id],'method'=>'put']) !!}

        @include('laccbook::books._form')

        <div class="form-group text-center">
            {!! Form::submit('Edit', ['class'=>'btn btn-primary btn-sm']) !!}
            <a href="{{ route('books.index') }}" class="btn btn-warning btn-sm"> Return </a>
        </div>

        {!! Form::close() !!}
    </div>
@endsection