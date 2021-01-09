<input type="hidden" name="id" value="{{ $supplier->id }}">
@if($supplier->id) <input type="hidden" name="_method" value="PATCH"> @endif
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">

      {!! Form::label('name', 'Name') !!}<span style="color: red">*</span>

      {!! Form::text('name', old('name'), ['class' => $errors->has('name')?'form-control is-invalid':'form-control',
      'placeholder' => 'Supplier Name','required']) !!}

      @if ($errors->has('name')) <p class="error invalid-feedback">{{ $errors->first('name') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">

      {!! Form::label('contact_person', 'Contact Person') !!}<span style="color: red">*</span>

      {!! Form::text('contact_person', old('contact_person'), ['class' => $errors->has('contact_person')?'form-control is-invalid':'form-control',
      'placeholder' => 'Contact Person','required']) !!}

      @if ($errors->has('contact_person')) <p class="error invalid-feedback">{{ $errors->first('contact_person') }}</p> @endif

    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('email', 'Email') !!}<span style="color: red">*</span>

      {!! Form::email('email', old('email'), ['class' => $errors->has('email')?'form-control
      is-invalid':'form-control', 'placeholder' => 'Email Address', 'required']) !!}
      
      @if ($errors->has('email')) <p class="error invalid-feedback">{{ $errors->first('email') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('phone_number', 'Phone Number') !!}

      {!! Form::text('phone_number', old('phone_number'), ['class' => $errors->has('phone_number')?'form-control
      is-invalid':'form-control', 'placeholder' => 'Phone Number', 'required']) !!}
      
      @if ($errors->has('phone_number')) <p class="error invalid-feedback">{{ $errors->first('phone_number') }}</p> @endif

    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('city', 'City') !!}

      {!! Form::text('city', old('city'), ['class' => $errors->has('city')?'form-control
      is-invalid':'form-control', 'placeholder' => 'City']) !!}
      
      @if ($errors->has('city')) <p class="error invalid-feedback">{{ $errors->first('city') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('state', 'State') !!}

      {!! Form::text('state', old('state'), ['class' => $errors->has('state')?'form-control
      is-invalid':'form-control', 'placeholder' => 'State']) !!}
      
      @if ($errors->has('state')) <p class="error invalid-feedback">{{ $errors->first('state') }}</p> @endif

    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('country', 'Country') !!}

       {!! Form::text('country', old('country'), ['class' => $errors->has('country')?'form-control
      is-invalid':'form-control', 'placeholder' => 'Country']) !!}

    </div>
  </div>
  
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('street_address', 'Street Address') !!}
      {!! Form::textarea('street_address', old('street_address'), ['class' => $errors->has('street_address')?'form-control is-invalid':'form-control', 'rows' => 2, 'placeholder' => 'Street Address']) !!}
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('status', 'Status') !!}<span style="color: red">*</span>

      {!! Form::select('status', array("Active" => "Active","Inactive" => "Inactive"),
      old('status'), ['class' => 'form-control select-2', 'data-placeholder' => 'Select Status', 'required']) !!}
      @if ($errors->has('status')) <p class="status-error invalid-feedback">{{ $errors->first('status') }}</p>
      @endif
    </div>
  </div>
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('supplier_image', 'Select Supplier Image') !!}<small class="ml-1 text-muted"
        id="file-size-error">Maximum 2 Mb.</small>
      <div class="input-group custom-file">
        {!! Form::file('image_file', ['class' => $errors->has('image_file')?'custom-file-input
        is-invalid':'custom-file-input', 'id' => 'image_file']) !!}
        {!! Form::label('custom-file-label', 'Choose Image', ['class' => 'custom-file-label overflow-hidden']) !!}
        <span class="text-muted" id="file-type-error">Allowed Types: jpeg, png and jpg</span>
      </div>
      @if ($errors->has('image_file')) <p class="image-error invalid-feedback">{{ $errors->first('image_file') }}</p>
      @endif
    </div>
    <div class="row text-center imgPreview" id="imgPreview">
      
    </div>

  </div>
</div>