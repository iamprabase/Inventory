{{-- <div class="modal fade" id="modal-delete" style="display: block; padding-right: 15px;" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content bg-default">
      <div class="modal-header">
        <h4 class="modal-title">Delete Item Confirmation?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center">Are you sure you want to delte the selected item?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light btn-danger" onclick="event.preventDefault(); document.getElementById('delForm').submit();">Delete</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div> --}}
<div class="modal fade" id="modal-delete">
  <div class="modal-dialog">
    <div class="modal-content bg-default">
      <div class="modal-header">
        <h4 class="modal-title">Delete Item Confirmation?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center">Are you sure you want to delte the selected item?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-light btn-danger" onclick="event.preventDefault(); document.getElementById('delForm').submit();">Delete</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
{!! Form::open(['action' => null, 'method' => 'post', 'files'=> false, 'id'=>'delForm']) !!}
  {{ method_field('DELETE') }}
{!! Form::close() !!}