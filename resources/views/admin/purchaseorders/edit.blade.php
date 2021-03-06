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
        <!-- /.card -->

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Purchase Order - {{$purchase_order->invoice_code}}</h3> 
            <a href="{{route('admin.purchase-orders.index')}}" class="btn btn-info float-right"> <i
                class="fas fa-arrow-left"></i> Back</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            {!! Form::model($purchase_order, ['route' => ['admin.purchase-orders.update', [$purchase_order->id]], 'method' => 'post',
            'files'=> false, 'id'=>'purchaseOrderForm']) !!}
            @include('admin.purchaseorders.form')
            {!! Form::submit('Update', ['class' => 'btn btn-warning', 'id'=>'submitPurchaseOrderBtn']) !!}
            {!! Form::close() !!}
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
@endsection

@section('customscripts')
@include('admin.purchaseorders.partials.customjs')
@endsection