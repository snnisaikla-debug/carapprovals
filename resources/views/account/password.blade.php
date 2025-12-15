@extends('layout')
@section('title','Change Password')

@section('content')
<div class="container" style="max-width:520px;">
  <h4 class="mb-3">Change Password</h4>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('account.password.update') }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Current Password</label>
      <input type="password" name="current_password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">New Password</label>
      <input type="password" name="new_password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Confirm New Password</label>
      <input type="password" name="new_password_confirmation" class="form-control" required>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('account.show') }}" class="btn btn-light w-50">Back</a>
      <button class="btn btn-primary w-50">Save</button>
    </div>
  </form>
</div>
@endsection
