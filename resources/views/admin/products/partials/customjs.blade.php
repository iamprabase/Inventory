@includeIf('layouts.partials.admin.datatablesjs')
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function () {
    bsCustomFileInput.init();
    // $(document).on('click', '[data-toggle="lightbox"]', function(event) {
    //   event.preventDefault();
    //   this.href = this.children.src;
    //   debugger;
    //   $(this).ekkoLightbox({
    //     alwaysShowClose: true
    //   });
    // });
  });

  @if(request()->is('products'))
    $('#productsTable').on("click", '.fa-trash', function(e){
      e.preventDefault();
      $('#modal-delete').modal();
      $('#delForm').attr('action', this.parentElement.href);
    });
    const data = @json($products);
    const tableBody = document.getElementById('productsTable').getElementsByTagName('tbody')[0];
    const editUrl = "{{ route('admin.products.edit', ':productId') }}";
    const deleteUrl = "{{ route('admin.products.destroy', ':productId') }}";
    
    data.map(product => {
      let nameCell = document.createElement('td');
      nameCell.appendChild(document.createTextNode(product['name']));
      
      let brandCell = document.createElement('td');
      brandCell.appendChild(document.createTextNode(product.brand.name));

      let categoryCell = document.createElement('td');
      let productCategories = product.category;
      if(productCategories.length>0){
        let categories = document.createElement('div');
        productCategories.map(category => {
          let badgeSpanCategory = document.createElement('span');
          let btnTag = 'info';
          badgeSpanCategory.classList.add('right', 'badge', 'badge-'+btnTag, 'mr-1');
          badgeSpanCategory.innerHTML = "";
          badgeSpanCategory.innerHTML = category['name'];
          categories.appendChild(badgeSpanCategory);
        });
        categoryCell.append(categories);
      }else{
        categoryCell.append('');
      }
      
      let priceCell = document.createElement('td');
      priceCell.appendChild(document.createTextNode(product['price']));

      let statusCell = document.createElement('td');
      let badgeSpan = document.createElement('span');
      let btnTag = 'primary';
      let productStatus = product['stock'];
      if(productStatus=="Out of Stock") btnTag = 'warning';
      badgeSpan.classList.add('right', 'badge', 'badge-'+btnTag);
      badgeSpan.innerHTML = productStatus;
      statusCell.appendChild(badgeSpan);
      
      let actionCell = document.createElement('td');
      
      let editBtn = document.createElement('a');
      editBtn.href = editUrl.replace(':productId', product['id']);
      editBtn.title = "Edit";
      let faEditIcon = document.createElement('span');
      faEditIcon.classList.add('fas', 'fa-edit');
      
      let deleteBtn = document.createElement('a');
      deleteBtn.href = deleteUrl.replace(':productId', product['id']);
      deleteBtn.title = "Delete";
      let faDelIcon = document.createElement('span');
      faDelIcon.classList.add('fas', 'fa-trash');
      
      editBtn.appendChild(faEditIcon);
      deleteBtn.appendChild(faDelIcon);
      actionCell.append(editBtn, deleteBtn);
      
      let createRow = document.createElement('tr');
      createRow.appendChild(nameCell);
      createRow.appendChild(brandCell);
      createRow.appendChild(categoryCell);
      createRow.appendChild(priceCell);
      createRow.appendChild(statusCell); 
      createRow.appendChild(actionCell);

      tableBody.appendChild(createRow);
    });
  @endif
  $('#productsTable').DataTable({
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

  $('.custom-file-input').change(function(){
    const maxFileSize = 2 * 1024 * 1024;
    const validUploads = ["image/png", "image/jpeg", "image/jpg"];
    let uploadeds = this.files;
    if(uploadeds.length > 4){
      document.getElementById('image_file').value = "";
      showToast('error', new Array('Maximum of 4 files allowed.'));
    }else{
      let isValidUploads = true;
      document.getElementsByClassName('imgPreview')[0].innerHTML = '';
      Object.keys(uploadeds).forEach(key => {
        let currentFile = uploadeds[key];
        let fileSize = currentFile.size;
        let type = currentFile.type;
        let isValidImageType = validUploads.includes(type);
        let isValidImageSize = maxFileSize > fileSize;
        if(!isValidImageType || !isValidImageSize){
          isValidUploads = false;
          if(!isValidImageType){
            document.getElementById('file-type-error').classList.remove("text-muted");
            document.getElementById('file-type-error').style.color = "#ff0000";  
            showToast('error', new Array(`File ${currentFile.name} should be of type jpeg, jpg or png.`));  
          }
          if(!isValidImageSize){
            document.getElementById('file-size-error').classList.remove("text-muted");
            document.getElementById('file-size-error').style.color = "#ff0000";
            showToast('error', new Array(`Image ${currentFile.name} is greater than 2Mb.`));  
          }
        }else{
          // instance of the FileReader
          let reader = new FileReader(); 
          // read the local file
          reader.readAsDataURL(currentFile); 
          
          reader.onloadend = function(){ 
            let divTag = document.createElement('div');
            divTag.classList.add('col-sm-2', 'col-md-3', 'd-inline-grid');
            let imgTag = document.createElement('img');
            imgTag.src = this.result;
            imgTag.classList.add('img-fluid', 'mb-2');
            imgTag.alt = 'Preview Image';
            if(isValidUploads){
              divTag.appendChild(imgTag);
              document.getElementById('imgPreview').append(divTag);
            }
          }
          if(!document.getElementById('file-type-error').classList.contains("text-muted")){
            document.getElementById('file-type-error').classList.add("text-muted");
            document.getElementById('file-type-error').style.color = "#6c757d!important";
          }
          if(!document.getElementById('file-size-error').classList.contains("text-muted")){
            document.getElementById('file-size-error').classList.add("text-muted");
            document.getElementById('file-size-error').style.color = "#6c757d!important";
          }

        }
      });

      if(!isValidUploads){
        document.getElementById('image_file').value = '';
        document.getElementsByClassName('imgPreview')[0].innerHTML = '';
      }
    }
  });

  @if(request()->is('products/*/edit'))
    @if(sizeof($images)>0)
      const images = @json($images);
      images.map(image => {
        let divTag = document.createElement('div');
        divTag.classList.add('col-sm-2', 'col-md-3', 'd-inline-grid');
        let imgTag = document.createElement('img');
        imgTag.src = "{{ asset($images[0]['src']) }}";
        imgTag.classList.add('img-fluid', 'mb-2');
        imgTag.alt = 'Preview Image';
        divTag.appendChild(imgTag);
        document.getElementById('imgPreview').append(divTag);
        debugger;
      });
    @endif
  @endif
</script>