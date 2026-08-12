@extends('user.dashboard')

@section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row mb-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
              <div>
                <h5 class="card-title mb-1">Welcome back, {{ trim(($user->fname ?? '') . ' ' . ($user->lname ?? '')) ?: ($user->userid ?? 'User') }}!</h5>
                <p class="text-muted mb-0">This is your SMS partner dashboard overview.</p>
              </div>
              <div class="d-flex gap-2">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                  @csrf
                  <button type="submit" class="btn btn-outline-danger">Log Out</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-xl-4 col-md-6">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Active Campaigns</h6>
              <p class="mb-0 text-muted">Track ongoing messages and campaign performance at a glance.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Messages Sent</h6>
              <p class="mb-0 text-muted">View totals for today, this week, and this month.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-12">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">API Status</h6>
              <p class="mb-0 text-muted">Monitor API availability and usage limits.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

