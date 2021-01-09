@includeIf('layouts.partials.admin.datatablesjs')
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>

  $('#locationsTable').on("click", '.fa-trash', function (e) {
    e.preventDefault();
    $('#modal-delete').modal();
    $('#delForm').attr('action', this.parentElement.href);
  });
  const data = @json($locations);
  const tableBody = document.getElementById('locationsTable').getElementsByTagName('tbody')[0];
  const editUrl = "{{ route('admin.locations.edit', ':locationId') }}";
  const deleteUrl = "{{ route('admin.locations.destroy', ':locationId') }}";

  data.map(location => {
    let nameCell = document.createElement('td');
    nameCell.appendChild(document.createTextNode(location['name']));

    let codeCell = document.createElement('td');
    codeCell.appendChild(document.createTextNode(location['location_code']));

    let contactPersonCell = document.createElement('td');
    contactPersonCell.appendChild(document.createTextNode(location.manager));

    let emailCell = document.createElement('td');
    emailCell.appendChild(document.createTextNode(location.email));

    let phoneNumberCell = document.createElement('td');
    phoneNumberCell.appendChild(document.createTextNode(location.phone_number));

    let statusCell = document.createElement('td');
    let badgeSpan = document.createElement('span');
    let btnTag = 'primary';
    let locationstatus = location['status'];
    if (locationstatus == "Inactive") btnTag = 'warning';
    badgeSpan.classList.add('right', 'badge', 'badge-' + btnTag);
    badgeSpan.innerHTML = locationstatus;
    statusCell.appendChild(badgeSpan);

    let actionCell = document.createElement('td');

    let editBtn = document.createElement('a');
    editBtn.href = editUrl.replace(':locationId', location['id']);
    editBtn.title = "Edit";
    let faEditIcon = document.createElement('span');
    faEditIcon.classList.add('fas', 'fa-edit');

    let deleteBtn = document.createElement('a');
    deleteBtn.href = deleteUrl.replace(':locationId', location['id']);
    deleteBtn.title = "Delete";
    let faDelIcon = document.createElement('span');
    faDelIcon.classList.add('fas', 'fa-trash');

    editBtn.appendChild(faEditIcon);
    deleteBtn.appendChild(faDelIcon);
    actionCell.append(editBtn, deleteBtn);

    let createRow = document.createElement('tr');
    createRow.appendChild(nameCell);
    createRow.appendChild(codeCell);
    createRow.appendChild(contactPersonCell);
    createRow.appendChild(phoneNumberCell);
    createRow.appendChild(statusCell);
    createRow.appendChild(actionCell);

    tableBody.appendChild(createRow);
  });
  $('#locationsTable').DataTable({
    "paging": true,
    "responsive": true,
    "scrollY": 200,
    "scrollX": false,
    "buttons": [
      {
        extend: 'pdfHtml5',
        title: '{{$title}}',
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
          stripNewlines: false,
        },
        footer: true,
      },
      {
        extend: 'excelHtml5',
        title: '{{$title}}',
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
        footer: true,
      },
      {
        extend: 'print',
        title: '{{$title}}',
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
        footer: true,
      },
    ],
  }).buttons().container().appendTo('#btn_wrapper');

</script>
