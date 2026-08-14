@extends('user.dashboard')

@section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">API Usage</h5>
          <small class="text-muted">Monitor your partner API call volume and usage limits.</small>
        </div>
        <div class="card-body">
          <p class="text-muted">API usage metrics will help you track requests and prevent rate-limit issues.</p>
        </div>
      </div>
    </div>
  </div>
@endsection

