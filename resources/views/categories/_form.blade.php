{!! Form::hidden('redirect_to', URL::previous()) !!}

<div class="form-group {{ $errors->first('name')? ' has-error':'' }}">
   {!! Form::label('name','Name', ['class' => 'control-label']) !!}
   {!! Form::text('name', null, ['placeholder'=>'Enter category name','class'=>'form-control', 'id'=>'name']) !!}
</div>