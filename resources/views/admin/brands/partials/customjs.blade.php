@includeIf('layouts.partials.admin.datatablesjs')
<script>

  $('#brandsTable').on("click", '.fa-trash', function(e){
    e.preventDefault();
    $('#modal-delete').modal();
    $('#delForm').attr('action', this.parentElement.href);
  });

  const data = @json($brands);
  const tableBody = document.getElementById('brandsTable').getElementsByTagName('tbody')[0];
  const editUrl = "{{ route('admin.brands.edit', ':brandId') }}";
  const deleteUrl = "{{ route('admin.brands.destroy', ':brandId') }}";
  
  data.map(brand => {
    let nameCell = document.createElement('td');
    nameCell.appendChild(document.createTextNode(brand['name']));
    
    let statusCell = document.createElement('td');
    let badgeSpan = document.createElement('span');
    let btnTag = 'primary';
    let brandStatus = brand['status'];
    if(brandStatus=="Inactive") btnTag = 'warning';
    badgeSpan.classList.add('right', 'badge', 'badge-'+btnTag);
    badgeSpan.innerHTML = brandStatus;
    statusCell.appendChild(badgeSpan);
    
    let actionCell = document.createElement('td');
    
    let editBtn = document.createElement('a');
    editBtn.href = editUrl.replace(':brandId', brand['id']);
    editBtn.title = "Edit";
    let faEditIcon = document.createElement('span');
    faEditIcon.classList.add('fas', 'fa-edit');
    
    let deleteBtn = document.createElement('a');
    deleteBtn.href = deleteUrl.replace(':brandId', brand['id']);
    deleteBtn.title = "Delete";
    let faDelIcon = document.createElement('span');
    faDelIcon.classList.add('fas', 'fa-trash');
    
    editBtn.appendChild(faEditIcon);
    deleteBtn.appendChild(faDelIcon);
    actionCell.append(editBtn, deleteBtn);
    
    let createRow = document.createElement('tr');
    createRow.appendChild(nameCell);
    createRow.appendChild(statusCell); 
    createRow.appendChild(actionCell);

    tableBody.appendChild(createRow);
  });

  $('#brandsTable').DataTable({
    "paging": true,
    "responsive": true,
    "fixedHeader": true,
    "scrollY": 200,
    "scrollX": false,
    "buttons": [
                  {
                    extend: 'pdfHtml5', 
                    title: '{{$title}}', 
                    exportOptions: {
                      columns: [0,1,2],
                      stripNewlines: false,
                    },
                    footer: true,
                  },
                  {
                    extend: 'excelHtml5', 
                    title: '{{$title}}', 
                    exportOptions: {
                      columns: [0,1,2],
                    },
                    footer: true,
                  },
                  {
                    extend: 'print', 
                    title: '{{$title}}', 
                    exportOptions: {
                      columns: [0,1,2],
                    },
                    footer: true,
                  },
                ],
  }).buttons().container().appendTo('#btn_wrapper');
</script>