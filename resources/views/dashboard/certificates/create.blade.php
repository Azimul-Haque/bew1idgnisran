@extends('layouts.app')
@section('title') ড্যাশবোর্ড | সনদের আবেদন @endsection

@section('third_party_stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">

    <style>
    

    </style>
@endsection

@section('content')
  @section('page-header') সনদের আবেদন ({{ checkcertificatetype($certificate_type) }}) @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('dashboard.certificates.index') }}">সনদের আবেদন</a></li>
        <li class="breadcrumb-item active">{{ checkcertificatetype($certificate_type) }}</li>
    </ol>
  @endsection
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-10 offset-md-1">
          @if($certificate_type == 'heir-certificate')
            @include('dashboard.certificates.forms.heir-certificate')
          @elseif($certificate_type == 'citizen-certificate')
            @include('dashboard.certificates.forms.citizen-certificate')
          @elseif($certificate_type == 'permanent-resident')
            @include('dashboard.certificates.forms.permanent-resident')
          @elseif($certificate_type == 'same-person')
            @include('dashboard.certificates.forms.same-person')
          @elseif($certificate_type == 'character-certificate')
            @include('dashboard.certificates.forms.character-certificate')
          @elseif($certificate_type == 'unmarried-certificate')
            @include('dashboard.certificates.forms.unmarried-certificate')
          @elseif($certificate_type == 'death-certificate')
            @include('dashboard.certificates.forms.death-certificate')
          @elseif($certificate_type == 'voter-area-change')
            @include('dashboard.certificates.forms.voter-area-change')
          @elseif($certificate_type == 'landless-certificate')
            @include('dashboard.certificates.forms.landless-certificate')
          @elseif($certificate_type == 'monthly-income')
            @include('dashboard.certificates.forms.monthly-income')
          @elseif($certificate_type == 'yearly-income')
            @include('dashboard.certificates.forms.yearly-income')
          @elseif($certificate_type == 'new-voter')
            @include('dashboard.certificates.forms.new-voter')
          @elseif($certificate_type == 'financial-insolvency')
            @include('dashboard.certificates.forms.financial-insolvency')
          @endif
        </div>
      </div>
    </div>
@endsection

@section('third_party_scripts')
  <script type="module">

    
  </script>
@endsection