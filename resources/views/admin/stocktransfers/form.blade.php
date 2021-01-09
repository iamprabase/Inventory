<input type="hidden" name="id" value="{{ $stock_transfer->id }}">
@if($stock_transfer->id) <input type="hidden" name="_method" value="PATCH"> @endif
<div class="row">
  <div class="col-sm-12 col-md-4">
    <div class="form-group">
      {!! Form::label('source_location_id', 'Transfer From') !!}<span style="color: red">*</span>

      {!! Form::select('source_location_id', array(null => "Select Transfer Location")+$locations, old('source_location_id'), ['class' =>
      'form-control select-2', 'id' => 'locationSelect', 'data-placeholder' => 'Select Source Location', 'required']) !!}

      @if ($errors->has('source_location_id')) <p class="error invalid-feedback">{{ $errors->first('source_location_id') }}</p> @endif
    </div>
  </div>
  <div class="col-sm-12 col-md-4">
    <div class="form-group">

      {!! Form::label('destination_location_id', 'Transfer To') !!}<span style="color: red">*</span>

      {!! Form::select('destination_location_id', array(null => "Transfer To")+$transferToLocations, old('destination_location_id'), ['class' =>
      'form-control select-2', 'id' => 'transferLocationSelect', 'data-placeholder' => 'Select Transfer Location', 'required']) !!}

      @if ($errors->has('destination_location_id')) <p class="error invalid-feedback">{{ $errors->first('destination_location_id') }}</p> @endif

    </div>
  </div>
  <div class="col-sm-12 col-md-4">
    <div class="form-group">

      {!! Form::label('transfer_date', 'Transfer Date') !!}<span style="color: red">*</span>
      <div class="input-group date" id="datePicker" data-target-input="nearest">
        {!! Form::text('transfer_date', old('transfer_date'), ['class' => 'form-control datetimepicker-input',
        'placeholder' => 'Transfer Date', 'required', 'data-target' => 'datePicker' ]) !!}
        <div class="input-group-append" data-target="#datePicker" data-toggle="datetimepicker">
          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
      </div>
      @if ($errors->has('transfer_date')) <p class="error invalid-feedback">{{ $errors->first('transfer_date') }}</p>
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
              <th width="5%">Action</th>
            </tr>
          </thead>
          <tbody class="dynamicRows">
            @if($stock_transfer->id)
              @foreach($stock_transfer->stockTransferDetails as $stockTransferDetail)
                
                <tr id="prodId{{$stockTransferDetail->product_id}}">
                <input type="hidden" name="stockTransferDetail[]" value="{{$stockTransferDetail->id}}" >
                <td>{{$stockTransferDetail->product->sku}}<input type="hidden" name="product_id[]" value="{{$stockTransferDetail->product_id}}"/></td>
                <td><input type="number" class="form-control qtyVal" min="1" name="quantity[]" class="purchaseQty" value="{{$stockTransferDetail->quantity}}" onChange="updateCalculation();"/></td>
                <td><a href="javascript:void(0)" onClick="removeRow({{$stockTransferDetail->product_id}}, {{$stockTransferDetail->id}});" id="{{$stockTransferDetail->product_id}}" class="btn delete_row"><i class="fa fa-trash"></i></a></td>

                </tr>
              @endforeach
            @endif
          </tbody>
          <tfoot class="footerRows">
            <tr>
              <td colspan="2" align="right"><strong> Total Quantity</strong></td>
              <td align="left" colspan="2">
                {!! Form::text('total_quantity', old('total_quantity'), ['class' => 'form-control', 'id'=> 'totalQty', 'placeholder' => 'Total Quantity', 'readonly' => true]) !!}
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