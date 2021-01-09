@extends('layouts.admin')

@section('customstyles')
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
            <h3 class="card-title">Add New Location</h3>
            <a href="{{route('admin.locations.index')}}" class="btn btn-info float-right"> <i
                class="fas fa-arrow-left"></i> Back</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            {!! Form::model($location, ['route' => ['admin.locations.store'], 'method' => 'post', 'files'=> true,
            'id'=>'locationForm']) !!}
            @include('admin.locations.form')
            {!! Form::submit('Add', ['class' => 'btn btn-primary submitBtn', 'id'=>'submitLocationBtn']) !!}
            {!! Form::close() !!}
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
@endsection