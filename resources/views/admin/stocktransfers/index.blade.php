@extends('layouts.admin')

@section('customstyles')
@include('admin.stocktransfers.partials.customcss')
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
            <div class="col-sm-12" id="btn_wrapper">
            </div>
            <div class="col-sm-12">
              <a href="{{route('admin.stock-transfers.create')}}" class="btn btn-info float-right"> <i class="fas fa-plus"></i>
                Create New</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="stockTransfersTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Source</th>
                  <th>Destination</th>
                  <th>Transfer Date</th>
                  <th>Total Quantity</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <tr>
                  <th>Source</th>
                  <th>Destination</th>
                  <th>Transfer Date</th>
                  <th>Total Quantity</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
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
  @include('layouts.partials.admin.deletemodal')
</section>


@endsection

@section('customscripts')
@include('admin.stocktransfers.partials.customjs')
@endsection