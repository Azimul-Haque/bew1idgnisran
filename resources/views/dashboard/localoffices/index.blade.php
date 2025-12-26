@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ইউনিয়ন/পৌরসভা @endsection

@section('third_party_stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

    <style>
    

    </style>
@endsection

@section('content')
  @section('page-header') ইউনিয়ন/পৌরসভা @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">ইউনিয়ন/পৌরসভা</li>
    </ol>
  @endsection
    <div class="container-fluid">
      <div class="card">
          <div class="card-header">
            <h3 class="card-title">ইউনিয়ন/পৌরসভা তালিকা (মোট: {{ $localofficescount }})</h3>

            <div class="card-tools">
              {{-- <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addPackageModal" title="" rel="tooltip" data-original-title="ইউনিয়ন/পৌরসভা যোগ করুন">
                <i class="fas fa-clipboard-check"></i> নতুন ইউনিয়ন/পৌরসভা
              </button> --}}
              <div class="card-tools">
                <form class="form-inline form-group-lg" action="">
                  <div class="form-group">
                    <input type="search-param" class="form-control form-control-sm" placeholder="ইউনিয়ন/পৌরসভা খুঁজুন" id="search-param" required>
                  </div>
                  <button type="button" id="search-button" class="btn btn-default btn-sm" style="margin-left: 5px;">
                    <i class="fas fa-search"></i> খুঁজুন
                  </button>
                </form>
                
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table">
              <thead>
                <thead>
                  <th>কার্যালয়</th>
                  <th>অবস্থা</th>
                  <th>ধরন</th>
                  <th>প্রতিনিধি</th>
                  <th>যোগদান</th>
                  <th>একশন</th>
                </thead>
              </thead>
              <tbody>
                @foreach($localoffices as $localoffice)
                  <tr>
                    <td>
                      {{ $localoffice->name_bn }} <small>({{ bangla($localoffice->payments->count()) }} বার)</small></br>
                      <span class="badge badge-primary">📞 {{ $localoffice->mobile }}</span>
                      <span class="badge badge-warning">✉ {{ $localoffice->email }}</span>
                    </td>
                    <td>
                      <span class="badge badge-{{ $localoffice->is_active == 0 ? 'light' : 'success' }}">{{ $localoffice->is_active == 0 ? 'এক্টিভ নয়' : 'একটিভ' }}</span><br/>
                      <small><span>প্যাকেজ: <b>{{$localoffice->package_expiry_date != null ? date('d F, Y', strtotime($localoffice->package_expiry_date)) : 'N/A' }}</b></span></small>
                    </td>
                    <td>{{ $localoffice->office_type == 'up' ? 'ইউনিয়ন পরিষদ' : 'পৌরসভা' }}</td>
                    <td>
                      @php
                          $managers = $localoffice->users->filter(function ($user) {
                              return $user->role === 'manager';
                          });
                      @endphp
                      @foreach($managers as $manager)
                        <span class="badge badge-success">{{ $manager->name }}</span>
                      @endforeach
                    </td>
                    <td><small>{{ date('F d, Y', strtotime($localoffice->created_at)) }}</small></td>
                    <td>
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addPaymentModal{{ $localoffice->id }}">
                        <i class="fas fa-hand-holding-usd"></i>
                      </button>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editLocalOfficeModal{{ $localoffice->id }}">
                        <i class="fas fa-pen"></i>
                      </button>
                    </td>
                  </tr>
                  {{-- Add Payment Modal Code --}}
                  {{-- Add Payment Modal Code --}}
                  <!-- Modal -->
                  <div class="modal fade" id="addPaymentModal{{ $localoffice->id }}" tabindex="-1" role="dialog" aria-labelledby="editLocalOfficeModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-warning">
                          <h5 class="modal-title" id="editLocalOfficeModalLabel"><b>ম্যানুয়ালি</b> পেমেন্ট এড করুন</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="{{ route('dashboard.local-offices.payment.add', $localoffice->id) }}">
                          <div class="modal-body">
                            @php
                              $authlevel = '';
                              if($localoffice->users && $localoffice->users->count() > 0) {
                                if($localoffice->users[0]->authorities->isNotEmpty()) {
                                  $auth = $localoffice->users[0]->authorities->first();
                                  // $authlevel = (new \ReflectionClass($auth->authority_type))->getShortName();
                                  $authlevel = $auth->getFullHierarchy();
                                }
                              }
                            @endphp
                            <small>{!! $authlevel !!}</small><br/><br/>
                            
                                @csrf
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                               class="form-control"
                                               value="{{ $localoffice->name_bn }}"
                                               placeholder="নাম" disabled>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-landmark"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="ইংরেজি নাম" disabled>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-landmark"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                      <input type="number"
                                             name="amount"
                                             autocomplete="off"
                                             class="form-control"
                                             placeholder="টাকার পরিমাণ" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-coins"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                               name="packageexpirydate"
                                               id="packageexpirydate2{{ $localoffice->id }}" 
                                               value="{{ $localoffice->package_expiry_date ? date('F d, Y', strtotime($localoffice->package_expiry_date)) : '' }}"
                                               autocomplete="off"
                                               class="form-control"
                                               placeholder="প্যাকেজের মেয়াদ বৃদ্ধি">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-calendar-check"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="form-check">
                                  <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" value="" required>আরেকবার দেখে নিশ্চিত করুন
                                  </label>
                                </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                            <button type="submit" class="btn btn-warning">দাখিল করুন</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  {{-- Add Payment Modal Code --}}
                  {{-- Add Payment Modal Code --}}

                  {{-- Edit Modal Code --}}
                  {{-- Edit Modal Code --}}
                  <!-- Modal -->
                  <div class="modal fade" id="editLocalOfficeModal{{ $localoffice->id }}" tabindex="-1" role="dialog" aria-labelledby="editLocalOfficeModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-primary">
                          <h5 class="modal-title" id="editLocalOfficeModalLabel">স্থানীয় সরকার কার্যালয় তথ্য হালনাগাদ</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="post" action="{{ route('dashboard.local-offices.update', $localoffice->id) }}" enctype="multipart/form-data">
                          <div class="modal-body">
                            @php
                              $authlevel = '';
                              if($localoffice->users && $localoffice->users->count() > 0) {
                                if($localoffice->users[0]->authorities->isNotEmpty()) {
                                  $auth = $localoffice->users[0]->authorities->first();
                                  // $authlevel = (new \ReflectionClass($auth->authority_type))->getShortName();
                                  $authlevel = $auth->getFullHierarchy();
                                }
                              }
                            @endphp
                            <small>{!! $authlevel !!}</small><br/><br/>
                            
                                @csrf

                                <div class="custom-control custom-switch mb-3">
                                  <input type="checkbox" class="custom-control-input" name="is_active" {{ $localoffice->is_active ? 'checked' : '' }} id="switchIsActive{{ $localoffice->id }}">
                                  <label class="custom-control-label" for="switchIsActive{{ $localoffice->id }}">একটিভ স্ট্যাটাস</label>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                               name="name_bn"
                                               class="form-control"
                                               value="{{ $localoffice->name_bn }}"
                                               placeholder="নাম" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-landmark"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text"
                                               name="name"
                                               class="form-control"
                                               value="{{ $localoffice->name }}"
                                               placeholder="ইংরেজি নাম (OPTIONAL)">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-landmark"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                      <input type="text"
                                             name="mobile"
                                             value="{{ $localoffice->mobile }}"
                                             autocomplete="off"
                                             class="form-control"
                                             placeholder="মোবাইল নম্বর (১১ ডিজিট)" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-phone"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="email"
                                               name="email"
                                               value="{{ $localoffice->email }}"
                                               autocomplete="off"
                                               class="form-control"
                                               placeholder="অফিস ইমেইল এড্রেস" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="draft_memo"
                                               name="draft_memo"
                                               value="{{ $localoffice->draft_memo }}"
                                               class="form-control"
                                               placeholder="স্মারকের টেমপ্লেট (রহি/ইউপি/ওয়ারিশান/২০২৫/)" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-tag"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                      <select name="signatory" class="form-control" required>
                                        <option disabled="" value="">সনদে স্বাক্ষর সংখ্যা</option>
                                        <option value="1" @if($localoffice->signatory == 1) selected="" @endif>শুধু অনুমোদনকারী (চেয়ারম্যান/মেয়র ইত্যাদি)</option>
                                        <option value="2" @if($localoffice->signatory == 2) selected="" @endif>প্রস্তুতকারী ও অনুমোদনকারী</option>
                                      </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-hand-writing"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="input-group mb-3">
                                      <select name="office_type" class="form-control" required>
                                        <option disabled="" value="">ধরন নির্ধারণ করুন</option>
                                        <option value="up" @if($localoffice->office_type == 'up') selected="" @endif>ইউনিয়ন পরিষদ</option>
                                        <option value="poura" @if($localoffice->office_type == 'poura') selected="" @endif>পৌরসভা</option>
                                      </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-landmark"></span></div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">                                       
                                      <!-- Bootstrap 4 Custom File Input -->
                                      <div class="custom-file">
                                          <!-- 
                                              The 'accept' attribute restricts the file picker 
                                              to show only common image types.
                                          -->
                                          <input 
                                              type="file" 
                                              class="custom-file-input" 
                                              id="monogram{{ $localoffice->id }}" 
                                              name="monogram"
                                              
                                              accept="image/png, image/jpeg, image/gif"
                                              @if($localoffice->monogram == null) required @endif
                                          >
                                          <label class="custom-file-label" for="monogram">মনোগ্রাম সিলেক্ট করুন</label>
                                      </div>
                                      <small class="form-text text-muted">Max file size 300KB. Accepts PNG, JPG, GIF. (300px X 300px)</small>
                                    </div>
                                  </div>
                                </div>
                                
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                            <button type="submit" class="btn btn-primary">দাখিল করুন</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  {{-- Edit Modal Code --}}
                  {{-- Edit Modal Code --}}
                  <script type="text/javascript" src="{{ asset('js/jquery-for-dp.min.js') }}"></script>
                  <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
                  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
                  <script>
                    $("#packageexpirydate{{ $localoffice->id }}").datepicker({
                      format: 'MM dd, yyyy',
                      todayHighlight: true,
                      autoclose: true,
                    });
                    $("#packageexpirydate2{{ $localoffice->id }}").datepicker({
                      format: 'MM dd, yyyy',
                      todayHighlight: true,
                      autoclose: true,
                    });
                  </script>
                  <script>
                    // JavaScript to update the label text of the custom file input
                    document.querySelector('#monogram{{ $localoffice->id }}').addEventListener('change', function (e) {
                        var fileName = e.target.files[0].name;
                        var nextSibling = e.target.nextElementSibling;
                        nextSibling.innerText = fileName;
                    });
                  </script>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        {{ $localoffices->links() }}
    </div>
@endsection

@section('third_party_scripts')
  {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
  <script type="module">

    $(document).on('click', '#search-button', function() {
      if($('#search-param').val() != '') {
        var urltocall = '{{ route('dashboard.local-offices') }}' +  '/' + $('#search-param').val();
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
          var urltocall = '{{ route('dashboard.local-offices') }}' +  '/' + $('#search-param').val();
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