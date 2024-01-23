@extends('layouts.app')

@section('title', 'Dashboard - ACR-GB')

@section('contents')
<div class="row">
  Dashboard




</div>
<div class="row">
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
              Over All Budget Disbursed</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><span>&#8369;</span>100,000,000
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-coins fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
              Over All Budget Used</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><span>&#8369;</span>6,000,000</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection