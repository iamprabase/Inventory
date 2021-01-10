@extends('layouts.admin')

@section('customstyles')
@include('admin.purchaseorders.partials.customcss')
@endsection

@section('content')

@include('layouts.partials.admin.breadcrumbs')
<section class="content">
  <div class="container-fluid">
    <div class="callout callout-info col-md-12">
      <div class="row">
        <div class="col-md-3">
          {!! Form::label('supplier_id', 'Suppliers') !!}

          {!! Form::select('supplier_id', array( "0" => "All")+$suppliers, old('supplier_id'), ['class' =>
          'form-control
          select-2 supplier_id', 'data-placeholder' => 'Select Category', 'required']) !!}
        </div>
        <div class="col-md-3">
          {!! Form::label('product_id', 'Products') !!}

          {!! Form::select('product_id', array("0" => "All")+$products, old('product_id'), ['class' => 'form-control
          select-2 product_id', 'data-placeholder' => 'Select Product', 'required']) !!}
        </div>
        <div class="col-md-3">
          {!! Form::label('start_date', 'Start Date') !!}

          <div class="input-group date" id="datePicker" data-target-input="nearest">
            {!! Form::text('start_date', date('Y-m-d', strtotime('-30 day')), ['class' => 'form-control start_date datetimepicker-input',
            'placeholder' => 'Start Date', 'required', 'data-target' => 'datePicker' ]) !!}
            <div class="input-group-append" data-target="#datePicker" data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          {!! Form::label('end_date', 'End Date') !!}

         <div class="input-group date" id="datePicker2" data-target-input="nearest">
            {!! Form::text('end_date', date('Y-m-d'), ['class' => 'form-control end_date datetimepicker-input',
            'placeholder' => 'End Date', 'required', 'data-target' => 'datePicker2' ]) !!}
            <div class="input-group-append" data-target="#datePicker2" data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3">
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
                  <th>Purchase Date</th>
                  <th>No of Purchases</th>
                  <th>Total Order Value</th>
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
  

  $('#submitBtn').on("click", function (e) {
    e.preventDefault();
    let supplierId = $('.supplier_id').val();
    let productId = $('.product_id').val();
    let startDate = $('.start_date').val();;
    let endDate = $('.end_date').val();;
    if(startDate==""||endDate==""){
      alert("Please Select Dates");
      return;
    }
    if(startDate>endDate){
      alert("Incorrect Date Format");
      return;
    }
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: "{{ route('admin.reports.getPurchaseHistoryReport') }}",
      data: {
        supplier_id: supplierId,
        product_id: productId,
        start_date: startDate,
        end_date: endDate
      },
      dataType: 'json',
      success: function (data) {
        const tableBody = document.getElementById('reportsTable').getElementsByTagName('tbody')[0];
        $('#reportsTable').DataTable().destroy();
        tableBody.innerHTML = '';
        data.data.map(purchaseOrder => {
          let dateCell = document.createElement('td');
          dateCell.appendChild(document.createTextNode(purchaseOrder['purchase_date']));

          let numPurchaseCell = document.createElement('td');
          numPurchaseCell.appendChild(document.createTextNode(purchaseOrder['num_purchase']));

          let grandTotalCell = document.createElement('td');
          grandTotalCell.appendChild(document.createTextNode(purchaseOrder.grand_total_amount));

          let createRow = document.createElement('tr');
          createRow.appendChild(dateCell);
          createRow.appendChild(numPurchaseCell);
          createRow.appendChild(grandTotalCell);

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
