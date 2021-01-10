@extends('layouts.admin')

@section('customstyles')
@include('admin.purchaseorders.partials.customcss')
@endsection

@section('content')

@include('layouts.partials.admin.breadcrumbs')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="callout callout-info col-md-4">
        <h5>Total Stock in Hand:</h5>
        <h4>{{$total_product_count}}</h4>
      </div>
      <div class="callout callout-info col-md-4">
        <h5>Product that needs Re-stocking :</h5>
        <h4>{{$product_below_threshold}}</h4>
      </div>
      <div class="callout callout-info col-md-4">
        <h5>Cost Value of Total Stock in Hand:</h5>
        <h4>{{$cost_value_total_stock}}</h4>
      </div>
      <!-- /.col -->
    </div>
    <div class="callout callout-info col-md-12">
      <div class="row">
        <div class="col-md-4">
          {!! Form::label('category_id', 'Categories') !!}

          {!! Form::select('category_id', array( "0" => "All")+$categories, old('category_id'), ['class' =>
          'form-control
          select-2 category_id', 'data-placeholder' => 'Select Category', 'required']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('product_id', 'Products') !!}

          {!! Form::select('product_id', array("0" => "All")+$products, old('product_id'), ['class' => 'form-control
          select-2 product_id', 'data-placeholder' => 'Select Product', 'required']) !!}
        </div>
        <div class="col-md-4">
          <label for="pwd">&nbsp;</label>
          <br />
          {!! Form::submit('Get Report', ['class' => 'btn btn-primary', 'id'=>'submitBtn']) !!}
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <!-- /.card -->
        <div class="card">
           <div class="card-header">
              <div class="col-sm-12" id="btn_wrapper">
              </div>
            </div>
          <div class="card-body table-responsive">
            <table id="reportsTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Product SKU</th>
                  <th>Available Quantity</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
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
</section>


@endsection
@section('customscripts')
@includeIf('layouts.partials.admin.datatablesjs') 
<script>
  $('.category_id').on("change", function () {
    let categoryId = $(this).val();
    $.ajax({
      // headers: {
      //   'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
      // },
      type: "GET",
      url: "{{ route('admin.reports.getCategoryProducts') }}",
      data: {
        id: categoryId
      },
      dataType: 'json',
      success: function (data) {
        $('.product_id').empty();
        if (data.data.length > 0) {

          $('.product_id').append(`<option value="0">All</option>`)
          data.data.forEach(element => {
            $('.product_id').append(`<option value="${element.id}">${element.name}</option>`)
          });
        }
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }
    });
  });

  $('#submitBtn').on("click", function (e) {
    e.preventDefault();
    let categoryId = $('.category_id').val();
    let productId = $('.product_id').val();

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: "{{ route('admin.reports.getReport') }}",
      data: {
        category_id: categoryId,
        product_id: productId
      },
      dataType: 'json',
      success: function (data) {
        const tableBody = document.getElementById('reportsTable').getElementsByTagName('tbody')[0];
        $('#reportsTable').DataTable().destroy();
        tableBody.innerHTML = '';
        data.data.map(product => {
          let nameCell = document.createElement('td');
          nameCell.appendChild(document.createTextNode(product['name']));

          let skuCell = document.createElement('td');
          skuCell.appendChild(document.createTextNode(product['sku']));

          let quantityCell = document.createElement('td');
          quantityCell.appendChild(document.createTextNode(product.available_quantity));

          let createRow = document.createElement('tr');
          createRow.appendChild(nameCell);
          createRow.appendChild(skuCell);
          createRow.appendChild(quantityCell);

          tableBody.appendChild(createRow);
        });
        reinitDT();
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }
    });
  });

  const reinitDT = () =>{
    $('#reportsTable').DataTable({
      "paging": true,
      "responsive": true,
      "scrollY": 200,
      "scrollX": false,
      "buttons": [
        {
          extend: 'pdfHtml5',
          title: '{{$title}}',
          exportOptions: {
            columns: [0, 1, 2],
            stripNewlines: false,
          },
          footer: true,
        },
        {
          extend: 'excelHtml5',
          title: '{{$title}}',
          exportOptions: {
            columns: [0, 1, 2],
          },
          footer: true,
        },
        {
          extend: 'print',
          title: '{{$title}}',
          exportOptions: {
            columns: [0, 1, 2],
          },
          footer: true,
        },
      ],
    }).buttons().container().appendTo('#btn_wrapper');
  };
  reinitDT();
  $('#submitBtn').trigger("click");
  // const editUrl = "{{ route('admin.locations.edit', ':locationId') }}";
  // const deleteUrl = "{{ route('admin.locations.destroy', ':locationId') }}";
</script>
@endsection
