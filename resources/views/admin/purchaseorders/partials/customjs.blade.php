@includeIf('layouts.partials.admin.datatablesjs')
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>

  @if(request()->is('purchase-orders'))
    $('#purchaseOrdersTable').on("click", '.fa-trash', function(e){
      e.preventDefault();
      $('#modal-delete').modal();
      $('#delForm').attr('action', this.parentElement.href);
    });
    const data = @json($purchase_orders);
    const tableBody = document.getElementById('purchaseOrdersTable').getElementsByTagName('tbody')[0];
    const editUrl = "{{ route('admin.purchase-orders.edit', ':purchaseOrderId') }}";
    const deleteUrl = "{{ route('admin.purchase-orders.destroy', ':purchaseOrderId') }}";

    data.map(purchaseOrder => {
      let invoiceCodeCell = document.createElement('td');
      invoiceCodeCell.appendChild(document.createTextNode(purchaseOrder['invoice_code']));

      let purchaseDateCell = document.createElement('td');
      purchaseDateCell.appendChild(document.createTextNode(purchaseOrder.purchase_date));

      let grandTotalCell = document.createElement('td');
      grandTotalCell.appendChild(document.createTextNode(purchaseOrder.grand_total_amount));

      let supplierNameCell = document.createElement('td');
      supplierNameCell.appendChild(document.createTextNode(purchaseOrder.supplier.name));

      let actionCell = document.createElement('td');

      let editBtn = document.createElement('a');
      editBtn.href = editUrl.replace(':purchaseOrderId', purchaseOrder['id']);
      editBtn.title = "Edit";
      let faEditIcon = document.createElement('span');
      faEditIcon.classList.add('fas', 'fa-edit');

      let deleteBtn = document.createElement('a');
      deleteBtn.href = deleteUrl.replace(':purchaseOrderId', purchaseOrder['id']);
      deleteBtn.title = "Delete";
      let faDelIcon = document.createElement('span');
      faDelIcon.classList.add('fas', 'fa-trash');

      editBtn.appendChild(faEditIcon);
      deleteBtn.appendChild(faDelIcon);
      actionCell.append(editBtn, deleteBtn);

      let createRow = document.createElement('tr');
      createRow.appendChild(invoiceCodeCell);
      createRow.appendChild(supplierNameCell);
      createRow.appendChild(purchaseDateCell);
      createRow.appendChild(grandTotalCell);
      createRow.appendChild(actionCell);

      tableBody.appendChild(createRow);
    });
    $('#purchaseOrdersTable').DataTable({
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
    const taxPercentage = @json(config('app.tax_percentage'));
    const taxOptions = Object.keys(taxPercentage).map(function(key, index) {
                          return `<option value="${key}" >${taxPercentage[key]}</option>`;
                        });
    $('#productSelect').on('select2:select', function (e) {
      var data = e.params.data;
      let selObj = products.filter( item => item.id == data.id )[0];
      buildTableData(selObj);
      $(this).val("").trigger('change');
    });

    const buildTableData  = product => {
      let id = product.id;
      let price = product.price;
      let findIfRowExist = $('#purchaseInvoice').find('.dynamicRows').find(`#prodId${id}`);
      
      if(findIfRowExist.length==0){
        let productCode = `<td>${product.sku}<input type="hidden" name="product_id[]" value="${id}"/></td>`;
        let productQuantity = `<td><input type="number" class="form-control qtyVal" min="1" name="quantity[]" class="purchaseQty" value="1" onChange="updateCalculation();"/></td>`;
        let productRate = `<td><input type="text" name="price[]" class="purchaseRate form-control" value="${price}" onChange="updateCalculation();"/></td>`;
        
        let taxPercent = `<td><select class="taxPercent form-control" onChange="updateCalculation();" name="tax_percent[]">
        ${taxOptions.join()}
        </select></td>`;
        let calTaxAmount = (taxPercentage / 100) * price;
        let taxAmount = `<td><input type="text" name="tax_amount[]" class="taxAmount form-control" value="${calTaxAmount}" readonly/></td>`;
        let calAmount = (1 * price) + calTaxAmount;
        let amount = `<td><input type="text" name="amount[]" class="amount form-control" value="${calAmount}" readonly/></td>`;
        let deleteBtn = `<td><a href="javascript:void(0)" onClick="removeRow(${id});" id="${id}" class="btn delete_row"><i class="fa fa-trash"></i></a></td>`;

        $('#purchaseInvoice').find('.dynamicRows').append(`<tr id="prodId${id}">${productCode}${productQuantity}${productRate}${taxPercent}${taxAmount}${amount}${deleteBtn}</tr>`);
      }else{
        let currentNum = parseInt(findIfRowExist.find('.qtyVal').val());
        findIfRowExist.find('.qtyVal').val(currentNum+1);
      }
      updateCalculation();      
    };

    const updateCalculation = () => {
      let findIfRowExist = $('#purchaseInvoice').find('.dynamicRows').find('tr');
      
      let subTotal = "";
      let totalTax = "";
      let grandTotal = "";
      if(findIfRowExist.length>0){
        subTotal = 0;
        totalTax = 0;
        grandTotal = 0;
        findIfRowExist.map((ind, row) => {
          let qtyVal = parseInt($(row).find('.qtyVal').val());
          let purchaseRate = parseFloat($(row).find('.purchaseRate').val());
          let taxPercent = parseFloat($(row).find('.taxPercent').val());
          let taxAmount = (taxPercent * purchaseRate * qtyVal) / 100;
          //parseFloat($(row).find('.taxAmount').val());
          let amount = (qtyVal * purchaseRate ) + taxAmount;
          //parseFloat($(row).find('.amount').val());
          $(row).find('.taxAmount').val( taxAmount );
          $(row).find('.amount').val( amount );
          
          subTotal += purchaseRate * qtyVal;
          totalTax += taxAmount;
          grandTotal += amount;
        });
      }

      $('#purchaseInvoice').find('.footerRows').find('#subTotal').val(subTotal);
      $('#purchaseInvoice').find('.footerRows').find('#taxTotal').val(totalTax);
      $('#purchaseInvoice').find('.footerRows').find('#grandTotal').val(grandTotal);
    };
    const removeRow = (id, purchaseOrderDetailId = null) => {
      $('#purchaseInvoice').find('.dynamicRows').find(`#prodId${id}`).remove();
      if(purchaseOrderDetailId){
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: "{{ route('admin.purchase-orders.deletePurchaseOrderDetail') }}",
          data: {
            id: purchaseOrderDetailId
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

