@extends('layouts.admin')

@section('customstyles')
@include('admin.products.partials.customcss')
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
              <a href="{{route('admin.products.create')}}" class="btn btn-info float-right"> <i class="fas fa-plus"></i>
                Create New</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="productsTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Product SKU</th>
                  <th>Category</th>
                  <th>MRP</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Product SKU</th>
                  <th>Category</th>
                  <th>MRP</th>
                  <th>Status</th>
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
@include('admin.products.partials.customjs')
@endsection