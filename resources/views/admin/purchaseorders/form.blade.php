<input type="hidden" name="id" value="{{ $purchase_order->id }}">
@if($purchase_order->id) <input type="hidden" name="_method" value="PATCH"> @endif
<div class="row">
  <div class="col-sm-12 col-md-4">
    <div class="form-group">

      {!! Form::label('invoice_code', 'Invoice Number') !!}<span style="color: red">*</span>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">PO-</span>
        </div>
        {!! Form::text('invoice_code', old('invoice_code'), ['class' => 'form-control', 'placeholder' =>
        'Invoice Code(Self Generated)', 'readonly' => true]) !!}
      </div>

      @if ($errors->has('invoice_code')) <p class="error invalid-feedback">{{ $errors->first('invoice_code') }}</p>
      @endif

    </div>
  </div>
  <div class="col-sm-12 col-md-4">
    <div class="form-group">

      {!! Form::label('supplier_id', 'Name') !!}<span style="color: red">*</span>

      {!! Form::select('supplier_id', array(null => "Select Supplier")+$suppliers, old('supplier_id'), ['class' =>
      'form-control
      select-2', 'data-placeholder' => 'Select Supplier', 'required']) !!}

      @if ($errors->has('supplier_id')) <p class="error invalid-feedback">{{ $errors->first('supplier_id') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-12 col-md-4">
    <div class="form-group">

      {!! Form::label('purchase_date', 'Purchase Date') !!}<span style="color: red">*</span>
      <div class="input-group date" id="datePicker" data-target-input="nearest">
        {!! Form::text('purchase_date', old('purchase_date'), ['class' => 'form-control datetimepicker-input',
        'placeholder' => 'Purchase Date', 'required', 'data-target' => 'datePicker' ]) !!}
        <div class="input-group-append" data-target="#datePicker" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
      </div>
      @if ($errors->has('purchase_date')) <p class="error invalid-feedback">{{ $errors->first('purchase_date') }}</p>
      @endif
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12 col-md-4">
    <div class="form-group">

      {!! Form::label('products', 'Select Products') !!}<span style="color: red">*</span>

      {!! Form::select('', array(null => "Select Products")+$products->pluck('name', 'id')->toArray(), old('products'), ['class' =>'form-control select-2','id' => 'productSelect', 'data-placeholder' => 'Select Products']) !!}

      @if ($errors->has('products')) <p class="error invalid-feedback">{{ $errors->first('products') }}</p> @endif

    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="box-header text-center">
      <h3 class="box-title">Purchase Items </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <div class="table-responsive">
        <table class="table table-bordered" id="purchaseInvoice">
          <thead>
            <tr>
              <th width="10%">Product SKU</th>
              <th width="5%">Quantity</th>
              <th width="15%">Price</th>
              <th width="15%">Tax(%)</th>
              <th width="15%">Tax</th>
              <th width="15%">Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="dynamicRows">
            @if($purchase_order->id)
              @foreach($purchase_order->purchaseOrderDetails as $purchaseOrderDetail)
                
                <tr id="prodId{{$purchaseOrderDetail->product_id}}">
                <input type="hidden" name="purchaseOrderDetail[]" value="{{$purchaseOrderDetail->id}}" >
                <td>{{$purchaseOrderDetail->product->sku}}<input type="hidden" name="product_id[]" value="{{$purchaseOrderDetail->product_id}}"/></td>
                <td><input type="number" class="form-control qtyVal" min="1" name="quantity[]" class="purchaseQty" value="{{$purchaseOrderDetail->quantity}}" onChange="updateCalculation();"/></td>
                <td><input type="text" name="price[]" class="purchaseRate form-control" value="{{$purchaseOrderDetail->price}}" onChange="updateCalculation();"/></td>
                <td><select class="taxPercent form-control" onChange="updateCalculation();" name="tax_percent[]">
                  @foreach(config('app.tax_percentage') as $key => $name)
                    <option value="{{$key}}" {{$key==$purchaseOrderDetail->tax_percent?"selected":""}}>{{$name}}</option>
                  @endforeach
                </select></td>
                <td><input type="text" name="tax_amount[]" class="taxAmount form-control" value="{{$purchaseOrderDetail->tax_amount}}" readonly/></td>
                <td><input type="text" name="amount[]" class="amount form-control" value="{{$purchaseOrderDetail->amount}}"/></td>
                <td><a href="javascript:void(0)" onClick="removeRow({{$purchaseOrderDetail->product_id}}, {{$purchaseOrderDetail->id}});" id="{{$purchaseOrderDetail->product_id}}" class="btn delete_row"><i class="fa fa-trash"></i></a></td>

                </tr>
              @endforeach
            @endif
          </tbody>
          <tfoot class="footerRows">
            <tr>
              <td colspan="6" align="right"><strong>Sub Total</strong></td>
              <td align="left" colspan="2">
                {!! Form::text('sub_total_amount', old('sub_total_amount'), ['class' => 'form-control', 'id'=> 'subTotal', 'placeholder' => 'Sub Total Amount', 'readonly' => true]) !!}
              </td>
            </tr>
            <tr>
              <td colspan="6" align="right"><strong>Total Tax</strong></td>
              <td align="left" colspan="2">
                {!! Form::text('tax_total_amount', old('tax_total_amount'), ['class' => 'form-control', 'id'=> 'taxTotal', 'placeholder' => 'Total Tax Amount', 'readonly' => true]) !!}
              </td>
            </tr>
            <tr>
              <td colspan="6" align="right"><strong>Grand Total</strong></td>
              <td align="left" colspan="2">
                {!! Form::text('grand_total_amount', old('grand_total_amount'), ['class' => 'form-control', 'id'=> 'grandTotal', 'placeholder' => 'Grand Total Amount', 'readonly' => true]) !!}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <br><br>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<div class="row">
  <div class="col-sm-12 col-md-8">
    <div class="form-group">

      {!! Form::label('description', 'Description') !!}
      {!! Form::textarea('description', old('description'), ['class' => $errors->has('description')?'form-control
      is-invalid':'form-control', 'rows' => 5, 'placeholder' => 'Description']) !!}
    </div>
  </div>
</div>

<!--<div class="row">
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
</div> -->
