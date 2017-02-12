@extends('layouts.app')

@section('title')
    Edit Category
@endsection

@section('content')
    <div class="container">
        <h1>Edit Category: <strong>{{$category->name}}</strong></h1>

        @include('errors._check')

        {!! Form::model($category,['route'=>['categories.update','id'=>$category->id],'method'=>'put']) !!}

        @include('laccbook::categories._form')

        <div class="form-group text-center">
            {!! Form::submit('Edit', ['class'=>'btn btn-primary btn-sm']) !!}
            <a href="{{ route('categories.index') }}" class="btn btn-warning btn-sm"> Return </a>
        </div>

        {!! Form::close() !!}
    </div>
@endsection