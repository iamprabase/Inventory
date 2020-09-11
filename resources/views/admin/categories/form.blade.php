<input type="hidden" name="id" value="{{ $category->id }}">
@if($category->id) <input type="hidden" name="_method" value="PATCH"> @endif

<div class="form-group">

  {!! Form::label('name', 'Name') !!}<span style="color: red">*</span>

  {!! Form::text('name', old('status'), ['class' => $errors->has('name')?'form-control is-invalid':'form-control', 'placeholder' => 'Brand Name','required']) !!}

  @if ($errors->has('name')) <p class="error invalid-feedback">{{ $errors->first('name') }}</p> @endif

</div>


<div class="form-group">

  {!! Form::label('status', 'Status') !!}<span style="color: red">*</span>

  {!! Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive'), old('status'), ['class' => 'form-control']) !!}

</div>