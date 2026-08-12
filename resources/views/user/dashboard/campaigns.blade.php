@extends('user.dashboard')

@section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Campaigns</h5>
          <small class="text-muted">Manage your SMS campaigns and review campaign states.</small>
        </div>
        <div class="card-body">
          <p class="text-muted">No active campaigns yet. Use the Send SMS page to create a new campaign or schedule a broadcast.</p>
        </div>
      </div>
    </div>
  </div>
@endsection

