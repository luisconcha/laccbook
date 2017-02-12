@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>New Book</h3>

            @include('errors._check')

            {!! Form::open(['route'=>'books.store']) !!}

            @include('laccbook::books._form')

            <div class="form-group text-center">
                {!! Form::submit('Save', ['class'=>'btn btn-primary btn-sm']) !!}
                <a href="{{ route('books.index') }}" class="btn btn-warning btn-sm"> Return </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection