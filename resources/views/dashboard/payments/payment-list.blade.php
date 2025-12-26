@extends('layouts.app')
@section('title') ড্যাশবোর্ড | পেমেন্ট তালিকা @endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">

    <style>
    

    </style>
@endsection

@section('content')
  @section('page-header') পেমেন্ট তালিকা @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">পেমেন্ট তালিকা</li>
    </ol>
  @endsection
    <div class="card">
          <div class="card-header">
            <h3 class="card-title">পেমেন্ট তালিকা</h3>

            <div class="card-tools">
              {{-- <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addPackageModal" title="" rel="tooltip" data-original-title="পেমেন্ট যোগ করুন">
                <i class="fas fa-clipboard-check"></i> নতুন পেমেন্ট
              </button> --}}
              <div class="card-tools">
                                
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>প্যাকেজ</th>
                            <th>ট্রানজেকশন আইডি</th>
                            <th>পরিমাণ</th>
                            <th>কার্ডের ধ্রন</th>
                            <th>স্ট্যাটাস</th>
                            <th>সময়</th>
                        </tr>
                    </thead>
                    <tbody id="payment-history-body">
                      @foreach($payments as $i => $payment)
                        <tr>
                          <td>{{ bangla(++$i) }}</td>
                          <td>{{ $payment->package->name }}</td>
                          <td>{{ $payment->trx_id }}</td>
                          <td><b>৳ {{ $payment->store_amount }}</b> <small>(৳ {{ $payment->amount }})</small></td>
                          <td>{{ $payment->card_type }}</td>
                          <td>{{ $payment->payment_status == 1 ? 'Successfull' : 'Failed' }}</td>
                          <td>{{ bangla(date('F d, Y h:i A', strtotime($payment->created_at))) }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        {{ $payments->links() }}

    </div>
@endsection

@section('third_party_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="module">

      $(document).on('click', '#search-button', function() {
        if($('#search-param').val() != '') {
          var urltocall = '{{ route('dashboard.payments') }}' +  '/' + $('#search-param').val();
          location.href= urltocall;
        } else {
          $('#search-param').css({ "border": '#FF0000 2px solid'});
          Toast.fire({
              icon: 'warning',
              title: 'কিছু লিখে খুঁজুন!'
          })
        }
      });
      $("#search-param").keyup(function(e) {
        if(e.which == 13) {
          if($('#search-param').val() != '') {
            var urltocall = '{{ route('dashboard.payments') }}' +  '/' + $('#search-param').val();
            location.href= urltocall;
          } else {
            $('#search-param').css({ "border": '#FF0000 2px solid'});
            Toast.fire({
                icon: 'warning',
                title: 'কিছু লিখে খুঁজুন!'
            })
          }
        }
      });
    </script>
@endsection