@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ভোটকেন্দ্র @endsection

@section('third_party_stylesheets')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection

@section('content')
    @section('page-header') ভোটকেন্দ্র @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">ভোটকেন্দ্র</li>
    </ol>
  @endsection
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-9">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">ভোটকেন্দ্র তালিকা</h3>

                  <div class="card-tools">
                    
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    
                </div>
                <!-- /.card-body -->
              </div>
        </div>  
        <div class="col-md-3"></div>  
      </div>
    </div>
@endsection

@section('third_party_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $('#notifdemo').hide();
        $('#headings').keyup(function () {
          $('#notifdemo').show();
          $('#headingstext').text(this.value);
        });
        $('#message').keyup(function () {
          $('#notifdemo').show();
          $('#messagetext').text(this.value);
        });
    </script>
@endsection