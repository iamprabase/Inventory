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
                <i class="fas fa-globe"></i> Stock Transfer
                <small class="float-right">Transfer Date: {{ date('j F Y', strtotime($stock_transfer->purchase_date)) }}</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                {{$stock_transfer->source->name}}<br>
                Phone: {{$stock_transfer->source->phone_number }}<br>
                Email: {{$stock_transfer->source->email }}
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <address>
                {{$stock_transfer->destination->name}}<br>
                Phone: {{$stock_transfer->destination->phone_number }}<br>
                Email: {{$stock_transfer->destination->email }}
              </address>
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
                  </tr>
                </thead>
                <tbody>
                  @foreach($stock_transfer->stockTransferDetails as $transfer)
                    <tr>
                      <td>{{$transfer->product->name}}</td>
                      <td>{{$transfer->product->sku}}</td>
                      <td>{{$transfer->quantity}}</td>
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
                      <th>Total Quantity</th>
                      <td>{{$stock_transfer->total_quantity}}</td>
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
