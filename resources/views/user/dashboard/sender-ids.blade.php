@extends('user.dashboard')

@section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Sender IDs</h5>
          <small class="text-muted">Manage the sender IDs that your SMS campaigns use.</small>
        </div>
        <div class="card-body">
          <p class="text-muted">Your approved sender IDs will appear here once connected with your SMS provider.</p>
        </div>
      </div>
    </div>
  </div>
@endsection

