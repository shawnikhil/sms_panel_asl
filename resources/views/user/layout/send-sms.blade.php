@extends('user.dashboard')

@section('content')
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Send SMS</h5>
          <small class="text-muted">Send a single SMS or start a new broadcast campaign.</small>
        </div>
        <div class="card-body">
          <form action="#" method="POST">
            <div class="mb-3">
              <label for="recipient" class="form-label">Recipient Number</label>
              <input type="text" id="recipient" name="recipient" class="form-control" placeholder="Enter phone number" />
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea id="message" name="message" class="form-control" rows="4" placeholder="Enter your SMS text"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

