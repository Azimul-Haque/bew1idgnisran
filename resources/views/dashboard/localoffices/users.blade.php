@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ব্যবহারকারীগণ @endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
	@section('page-header') ব্যবহারকারীগণ (মোট {{ bangla($userscount) }} জন) @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">ব্যবহারকারীগণ</li>
    </ol>
  @endsection
    <div class="container-fluid">
		  <div class="card">
          <div class="card-header">
            <h3 class="card-title">ব্যবহারকারীগণ</h3>
            {{-- <small><a href="{{ route('dashboard.userssort')  }}" style="margin-left: 5px;">সর্বোচ্চ পরীক্ষার্থী</a></small>
            <small><a href="{{ route('dashboard.expiredusers')  }}" style="margin-left: 5px;">মেয়াদোত্তীর্ণ পরীক্ষার্থী</a></small> --}}

            <div class="card-tools">
              <form class="form-inline form-group-lg" action="">
                <div class="form-group">
                  <input type="search-param" class="form-control form-control-sm" placeholder="ব্যবহারকারী খুঁজুন" id="search-param" required>
                </div>
                <button type="button" id="search-button" class="btn btn-default btn-sm" style="margin-left: 5px;">
                  <i class="fas fa-search"></i> খুঁজুন
                </button>
                {{-- <button type="button" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#addBulkDate" style="margin-left: 5px;">
                  <i class="fas fa-calendar-alt"></i> বাল্ক মেয়াদ বাড়ান
                </button> --}}
                {{-- <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addUserModal" style="margin-left: 5px;">
                  <i class="fas fa-user-plus"></i> নতুন
                </button> --}}
              </form>
            	
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table">
              <tbody>
                <tr>
                  <th>নাম</th>
                  <th>ঠিকানা</th>
                  <th>মোট সনদ গ্রহণ</th>
                  {{-- <th><span class="badge bg-danger">55%</span></th> --}}
                </tr>
                @foreach($users as $user)
                	<tr>
                		<td>
                			<a href="{{ route('dashboard.localoffice.users.certificates', $user->id) }}" data-toggle="tooltip" data-original-title="সনদসমূহ দেখুন">{{ $user->name }}</a> <span class="badge @if($user->role == 'admin') bg-success @elseif($user->role == 'manager') bg-warning @else bg-info @endif">{{ checkrole($user->role) }}</span>
                			<br/>
                			<small class="text-black-50">এনআইডি/জন্মসনদ: {{ $user->nid }}</small><br/>
                      <small class="text-black-50">মোবাইল: {{ $user->mobile }}</small> 
                		</td>
                    <td>
                      {{ $user->localOffice != null ? $user->localOffice->name_bn : '' }}
                    </td>
                    <td>{{ bangla($user->certificates->count()) }} টি</td>
                    <td>
                      <a href="{{ route('dashboard.localoffice.users.certificates', $user->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-original-title="সনদসমূহ দেখুন">
                          <i class="fas fa-eye"></i> সনদ তালিকা
                      </a>
                    </td>
                        {{-- Delete User Modal Code --}}
                        {{-- Delete User Modal Code --}}
                        <!-- Modal -->
                        {{-- <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true" data-backdrop="static">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="deleteUserModalLabel">ব্যবহারকারী ডিলেট</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                আপনি কি নিশ্চিতভাবে এই ব্যবহারকারীকে ডিলেট করতে চান?<br/>
                                <center>
                                    <big><b>{{ $user->name }}</b></big><br/>
                                    <small><i class="fas fa-phone"></i> {{ $user->mobile }}</small>
                                </center>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                                <a href="{{ route('dashboard.users.delete', $user->id) }}" class="btn btn-danger">ডিলেট করুন</a>
                              </div>
                            </div>
                          </div>
                        </div> --}}
                        {{-- Delete User Modal Code --}}
                        {{-- Delete User Modal Code --}}
                	</tr>
                    {{-- Activate User Modal Code --}}
                    {{-- Activate User Modal Code --}}
                    <!-- Modal -->
                    {{-- <div class="modal fade" id="actiavateUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="actiavateUserModalLabel" aria-hidden="true" data-backdrop="static">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="actiavateUserModalLabel">ব্যবহারকারী এক্টিভেট</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            আপনি কি নিশ্চিতভাবে এই ব্যবহারকারীকে এক্টিভেট করতে চান?<br/>
                            <center>
                                <big><b>{{ $user->name }}</b></big><br/>
                                স্থানীয় সরকার কার্যালয়: {{ $user->localOffice != null ? $user->localOffice->name_bn : '' }}
                            </center>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ফিরে যান</button>
                            <a href="{{ route('dashboard.users.activate', $user->id) }}" class="btn btn-warning">এক্টিভেট করুন</a>
                          </div>
                        </div>
                      </div>
                    </div> --}}
                    {{-- Activate User Modal Code --}}
                    {{-- Activate User Modal Code --}}
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        {{ $users->links() }}
    </div>
@endsection

@section('third_party_scripts')
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script type="text/javascript">
        $(document).on('click', '#search-button', function() {
          if($('#search-param').val() != '') {
            var urltocall = '{{ route('dashboard.localoffice.users') }}' +  '/' + $('#search-param').val();
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
              var urltocall = '{{ route('dashboard.localoffice.users') }}' +  '/' + $('#search-param').val();
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