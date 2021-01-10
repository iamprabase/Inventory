@extends('layouts.admin')

@section('content')
@include('layouts.partials.admin.breadcrumbs')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$purchase_orders_count}}</h3>

            <p>Purchase Orders</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{route('admin.purchase-orders.index')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$products_count}}<sup style="font-size: 20px">%</sup></h3>

            <p>Products</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{route('admin.products.index')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$suppliers_count}}</h3>

            <p>Suppliers</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{route('admin.suppliers.index')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$stock_transfers_count}}</h3>

            <p>Stock Transfer</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{route('admin.stock-transfers.index')}}" class="small-box-footer">More info <i
              class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>

    <!-- /.row -->
    <!-- /.row (main row) -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">Latest Stock Transfers</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Total Quantity</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($stock_transfers as $stock_transfer)
                  <tr>
                    <td>{{$stock_transfer['source']['name']}}</td>
                    <td>{{$stock_transfer['destination']['name']}}</td>
                    <td><a href="{{route('admin.stock-transfers.show', [$stock_transfer['id']])}}">
                        {{$stock_transfer['total_quantity']}} </a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <a href="{{route('admin.stock-transfers.create')}}" class="btn btn-sm btn-info float-left">Place New</a>
            <a href="{{route('admin.stock-transfers.index')}}" class="btn btn-sm btn-secondary float-right">View All</a>
          </div>
          <!-- /.card-footer -->
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">Latest Purchase Orders</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>Invoice Code</th>
                    <th>Supplier Name</th>
                    <th>Purchase Date</th>
                    <th>Grand Total Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($purchase_orders as $purchase_order)
                  <tr>
                    <td><a
                        href="{{route('admin.purchase-orders.show', [$purchase_order['id']])}}">{{$purchase_order['invoice_code']}}</a>
                    </td>
                    <td>{{$purchase_order['supplier']['name']}}</td>
                    <td>{{ date("j F Y", strtotime($purchase_order['supplier']['name']))}}</td>
                    <td>{{$purchase_order['grand_total_amount']}} </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <a href="{{route('admin.purchase-orders.create')}}" class="btn btn-sm btn-info float-left">Place New</a>
            <a href="{{route('admin.purchase-orders.index')}}" class="btn btn-sm btn-secondary float-right">View All</a>
          </div>
          <!-- /.card-footer -->
        </div>
      </div>

    </div>
    <!-- /.card -->
  </div><!-- /.container-fluid -->
</section>
@endsection
