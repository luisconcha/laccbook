@extends('layouts.app')

@section('title')
    New Category
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h3>New Category</h3>

            @include('errors._check')

            {!! Form::open(['route'=>'categories.store']) !!}

            @include('laccbook::categories._form')

            <div class="form-group text-center">
                {!! Form::submit('Save', ['class'=>'btn btn-primary btn-sm']) !!}
                <a href="{{ route('categories.index') }}" class="btn btn-warning btn-sm"> Return </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection