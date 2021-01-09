@includeIf('layouts.partials.admin.datatablesjs')
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
  @if(request()->is('stock-transfers'))
    $('#stockTransfersTable').on("click", '.fa-trash', function(e){
      e.preventDefault();
      $('#modal-delete').modal();
      $('#delForm').attr('action', this.parentElement.href);
    });
    const data = @json($stock_transfers);
    console.log(data);
    const tableBody = document.getElementById('stockTransfersTable').getElementsByTagName('tbody')[0];
    const editUrl = "{{ route('admin.stock-transfers.edit', ':stockTransferId') }}";
    const printUrl = "{{ route('admin.stock-transfers.show', ':stockTransferId') }}";
    const deleteUrl = "{{ route('admin.stock-transfers.destroy', ':stockTransferId') }}";

    data.map(stockTransfer => {
      
      let grandTotalCell = document.createElement('td');
      grandTotalCell.appendChild(document.createTextNode(stockTransfer.total_quantity));

      let sourceLocationCell = document.createElement('td');
      sourceLocationCell.appendChild(document.createTextNode(stockTransfer.source.name));
      
      let transferDateCell = document.createElement('td');
      transferDateCell.appendChild(document.createTextNode(stockTransfer.transfer_date));

      let destinationLocationCell = document.createElement('td');
      destinationLocationCell.appendChild(document.createTextNode(stockTransfer.destination.name));

      let actionCell = document.createElement('td');

      let editBtn = document.createElement('a');
      editBtn.href = editUrl.replace(':stockTransferId', stockTransfer['id']);
      editBtn.title = "Edit";
      let faEditIcon = document.createElement('span');
      faEditIcon.classList.add('fas', 'fa-edit');

      let printBtn = document.createElement('a');
      printBtn.href = printUrl.replace(':stockTransferId', stockTransfer['id']);
      printBtn.title = "Print";
      let faprintIcon = document.createElement('span');
      faprintIcon.classList.add('fas', 'fa-eye', 'mr-2');

      let deleteBtn = document.createElement('a');
      deleteBtn.href = deleteUrl.replace(':stockTransferId', stockTransfer['id']);
      deleteBtn.title = "Delete";
      let faDelIcon = document.createElement('span');
      faDelIcon.classList.add('fas', 'fa-trash');

      printBtn.appendChild(faprintIcon);
      editBtn.appendChild(faEditIcon);
      deleteBtn.appendChild(faDelIcon);
      actionCell.append(printBtn, editBtn, deleteBtn);

      let createRow = document.createElement('tr');
      createRow.appendChild(sourceLocationCell);
      createRow.appendChild(destinationLocationCell);
      createRow.appendChild(transferDateCell);
      createRow.appendChild(grandTotalCell);
      createRow.appendChild(actionCell);

      tableBody.appendChild(createRow);
    });
    $('#stockTransfersTable').DataTable({
      "paging": true,
      "responsive": true,
      "scrollY": 200,
      "scrollX": false,
      "buttons": [
                    {
                      extend: 'pdfHtml5',
                      title: '{{$title}}',
                      exportOptions: {
                        columns: [0,1,2,3,4],
                        stripNewlines: false,
                      },
                      footer: true,
                    },
                    {
                      extend: 'excelHtml5',
                      title: '{{$title}}',
                      exportOptions: {
                        columns: [0,1,2,3,4],
                      },
                      footer: true,
                    },
                    {
                      extend: 'print',
                      title: '{{$title}}',
                      exportOptions: {
                        columns: [0,1,2,3,4],
                      },
                      footer: true,
                    },
                  ],
    }).buttons().container().appendTo('#btn_wrapper');
  @else
    const products = @json($products);
    const locations = @json($locations);
    
    $('#productSelect').on('select2:select', function (e) {
      let data = e.params.data;
      let selObj = products.filter( item => item.id == data.id )[0];
      buildTableData(selObj);
      $(this).val("").trigger('change');
    });

    $('#locationSelect').on('select2:select', function (e) {
      let data = e.params.data;
      let buildList = new Array;
      let selObj = Object.keys(locations).map(function(key, index) {
                      if(key != data.id) buildList[key] = locations[key]
                    });
      $('#transferLocationSelect').find('option').remove();
      buildList.map(( option, ind) => {
        $('#transferLocationSelect').append(`<option value="${ind}">${option}</option>`);
      });
    });

    const buildTableData  = product => {
      let id = product.id;
      let findIfRowExist = $('#purchaseInvoice').find('.dynamicRows').find(`#prodId${id}`);
      
      if(findIfRowExist.length==0){
        let productCode = `<td>${product.sku}<input type="hidden" name="product_id[]" value="${id}"/></td>`;
        let productQuantity = `<td><input type="number" class="form-control qtyVal" min="1" name="quantity[]" class="purchaseQty" value="1" onChange="updateCalculation();"/></td>`;
        let deleteBtn = `<td><a href="javascript:void(0)" onClick="removeRow(${id});" id="${id}" class="btn delete_row"><i class="fa fa-trash"></i></a></td>`;

        $('#purchaseInvoice').find('.dynamicRows').append(`<tr id="prodId${id}">${productCode}${productQuantity}${deleteBtn}</tr>`);
      }else{
        let currentNum = parseInt(findIfRowExist.find('.qtyVal').val());
        findIfRowExist.find('.qtyVal').val(currentNum+1);
      }
      updateCalculation();      
    };

    const updateCalculation = () => {
      let findIfRowExist = $('#purchaseInvoice').find('.dynamicRows').find('tr');
      
      let totalQty = "";
      if(findIfRowExist.length>0){
        totalQty = 0;
        findIfRowExist.map((ind, row) => {
          let qtyVal = parseInt($(row).find('.qtyVal').val());
          totalQty += qtyVal;
        });
      }

      $('#purchaseInvoice').find('.footerRows').find('#totalQty').val(totalQty);
    };
    const removeRow = (id, stockTransferDetailId = null) => {
      $('#purchaseInvoice').find('.dynamicRows').find(`#prodId${id}`).remove();
      if(stockTransferDetailId){
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: "{{ route('admin.stock-transfers.deleteStockTransferDetail') }}",
          data: {
            id: stockTransferDetailId
          },
          dataType: 'json',
          success: function (data) {
              
          },
          error: function (xhr) {
            alert(xhr.responseText);
          }
        });
      }
      updateCalculation();
    };

  @endif

</script>

