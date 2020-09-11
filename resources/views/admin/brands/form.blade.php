<input type="hidden" name="id" value="{{ $brand->id }}">
@if($brand) <input type="hidden" name="_method" value="PATCH"> @endif

<div class="form-group @if ($errors->has('name')) has-error @endif">

  {!! Form::label('name', 'Name') !!}<span style="color: red">*</span>

  {!! Form::text('name', old('status'), ['class' => 'form-control', 'placeholder' => 'Brand Name','required']) !!}

  @if ($errors->has('name')) <p class="help-block has-error">{{ $errors->first('name') }}</p> @endif

</div>


<div class="form-group">

  {!! Form::label('status', 'Status') !!}<span style="color: red">*</span>

  {!! Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive'), old('status'), ['class' => 'form-control']) !!}

</div>