@extends('layouts.admin')

@section('customstyles')
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endsection

@section('content')
@include('layouts.partials.admin.breadcrumbs')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> Purchase Order - {{$purchase_order->invoice_code}}
                <small class="float-right">Invoice Date: {{ date('j F Y', strtotime($purchase_order->purchase_date)) }}</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                {{$purchase_order->supplier->street_address}}<br>
                {{$purchase_order->supplier->country}}, {{$purchase_order->supplier->state }} , {{$purchase_order->supplier->city }}<br>
                Phone: {{$purchase_order->supplier->phone_number }}<br>
                Email: {{$purchase_order->supplier->email }}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-5 invoice-col">
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <b>Invoice #{{$purchase_order->invoice_code}}</b><br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Product SKU</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Tax(%)</th>
                    <th>Tax</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($purchase_order->purchaseOrderDetails as $order)
                    <tr>
                      <td>{{$order->product->name}}</td>
                      <td>{{$order->product->sku}}</td>
                      <td>{{$order->quantity}}</td>
                      <td>{{$order->price}}</td>
                      <td>{{$order->tax_percent}}</td>
                      <td>{{$order->tax_amount}}</td>
                      <td>{{$order->amount}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
              
            </div>
            <!-- /.col -->
            <div class="col-6">

              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <th style="width:50%">Subtotal Amount</th>
                      <td>{{$purchase_order->sub_total_amount}}</td>
                    </tr>
                    <tr>
                      <th>Total Tax Amount</th>
                      <td>{{$purchase_order->tax_total_amount}}</td>
                    </tr>
                    <tr>
                      <th>Grand Total Amount</th>
                      <td>{{$purchase_order->grand_total_amount}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
              <a href="#" target="_blank" class="btn btn-default print"><i class="fas fa-print"></i>
                Print</a>
            </div>
          </div>
        </div>
        <!-- /.invoice -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection

@section('customscripts')
<script>
  $('.print').click(function(){
    window.print()
  });
</script>
@endsection
