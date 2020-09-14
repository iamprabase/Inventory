<input type="hidden" name="id" value="{{ $product->id }}">
@if($product->id) <input type="hidden" name="_method" value="PATCH"> @endif
<div class="row">
  <div class="col-sm-12">
    <div class="form-group">

      {!! Form::label('name', 'Name') !!}<span style="color: red">*</span>

      {!! Form::text('name', old('name'), ['class' => $errors->has('name')?'form-control is-invalid':'form-control',
      'placeholder' => 'Product Name','required']) !!}

      @if ($errors->has('name')) <p class="error invalid-feedback">{{ $errors->first('name') }}</p> @endif

    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('price', 'Price') !!}<span style="color: red">*</span>

      {!! Form::text('price', old('price'), ['class' => $errors->has('price')?'form-control
      is-invalid':'form-control', 'placeholder' => 'Product Price', 'required']) !!}

    </div>
  </div>
  <div class="col-sm-12 col-md-6">
    <div class="form-group">

      {!! Form::label('brand_id', 'Brand') !!}

      {!! Form::select('brand_id', array(null => "Select Brand")+$brands, old('brand_id'), ['class' => 'form-control
      select-2', 'data-placeholder' => 'Select Brand', 'required']) !!}

    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="form-group">

      {!! Form::label('category_id', 'Category') !!}

      {!! Form::select('category_id[]', $categories, isset($category_id)?$category_id:old('category_id'), ['class' =>
      'form-control select-2', 'multiple' => 'multiple', 'data-placeholder' => 'Select Category', 'style' => 'width:
      100%;', 'required']) !!}
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="form-group">

      {!! Form::label('product_image', 'Select Product Image') !!}<small class="ml-1 text-muted"
        id="file-size-error">Maximum 4 files of 2 Mb each.</small>
      <div class="input-group custom-file">
        {!! Form::file('image_file[]', ['class' => $errors->has('image_file')?'custom-file-input
        is-invalid':'custom-file-input', 'multiple' => 'multiple', 'id' => 'image_file']) !!}
        {!! Form::label('custom-file-label', 'Choose Image', ['class' => 'custom-file-label overflow-hidden']) !!}
        <span class="text-muted" id="file-type-error">Allowed Types: jpeg, png and jpg</span>
      </div>
      @if ($errors->has('image_file')) <p class="image-error invalid-feedback">{{ $errors->first('image_file') }}</p>
      @endif
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">

      {!! Form::label('stock', 'Product Stock') !!}<span style="color: red">*</span>

      {!! Form::select('stock', array("In-stock" => "In-stock", "Out of Stock" => "Out of Stock"),
      old('stock'), ['class' => 'form-control select-2', 'data-placeholder' => 'Select Stock', 'required']) !!}
      @if ($errors->has('stock')) <p class="stock-error invalid-feedback">{{ $errors->first('stock') }}</p>
      @endif
    </div>
  </div>
</div>

<div class="row">
  <div class="row text-center imgPreview" id="imgPreview">
    {{-- <a href="#" class="imagePreviewModal" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery"> --}}
    {{-- <img src="https://via.placeholder.com/300/FFFFFF?text=1" class="img-fluid mb-2" alt="white sample" /> --}}
    {{-- </a> --}}
  </div>
</div>

<div class="row">
  <div class="col-sm-12 mb-3">
    <div class="form-group">
      {!! Form::label('description', 'Description') !!}
      {!! Form::textarea('description', old('description'), ['class' => $errors->has('description')?'form-control
      textarea is-invalid':'form-control textarea', 'placeholder' => 'Place some text here']) !!}
    </div>
  </div>
</div>