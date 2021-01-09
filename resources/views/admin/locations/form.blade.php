<input type="hidden" name="id" value="{{ $location->id }}">
@if($location->id) <input type="hidden" name="_method" value="PATCH"> @endif
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">

      {!! Form::label('name', 'Location') !!}<span style="color: red">*</span>

      {!! Form::text('name', old('name'), ['class' => $errors->has('name')?'form-control is-invalid':'form-control',
      'placeholder' => 'Location','required']) !!}

      @if ($errors->has('name')) <p class="error invalid-feedback">{{ $errors->first('name') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">

      {!! Form::label('manager', 'Manager') !!}<span style="color: red">*</span>

      {!! Form::text('manager', old('manager'), ['class' => $errors->has('manager')?'form-control is-invalid':'form-control',
      'placeholder' => 'Manager','required']) !!}

      @if ($errors->has('manager')) <p class="error invalid-feedback">{{ $errors->first('manager') }}</p> @endif

    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('email', 'Email') !!}

      {!! Form::email('email', old('email'), ['class' => $errors->has('email')?'form-control
      is-invalid':'form-control', 'placeholder' => 'Email Address']) !!}
      
      @if ($errors->has('email')) <p class="error invalid-feedback">{{ $errors->first('email') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('phone_number', 'Phone Number') !!}

      {!! Form::text('phone_number', old('phone_number'), ['class' => $errors->has('phone_number')?'form-control
      is-invalid':'form-control', 'placeholder' => 'Phone Number']) !!}
      
      @if ($errors->has('phone_number')) <p class="error invalid-feedback">{{ $errors->first('phone_number') }}</p> @endif

    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group">

      {!! Form::label('location_code', 'Location Code') !!}<span style="color: red">*</span>

      {!! Form::text('location_code', old('location_code'), ['class' => $errors->has('location_code')?'form-control is-invalid':'form-control',
      'placeholder' => 'Location Code','required']) !!}

      @if ($errors->has('location_code')) <p class="error invalid-feedback">{{ $errors->first('location_code') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('status', 'Status') !!}<span style="color: red">*</span>

      {!! Form::select('status', array("Active" => "Active","Inactive" => "Inactive"),
      old('status'), ['class' => 'form-control select-2', 'data-placeholder' => 'Select Status', 'required']) !!}
      @if ($errors->has('status')) <p class="status-error invalid-feedback">{{ $errors->first('status') }}</p>
      @endif
    </div>
  </div>
</div>