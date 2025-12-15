@extends('layout')
@section('title','Edit Profile')

@section('content')
<div class="container" style="max-width:520px;">
  <h4 class="mb-3">Edit Profile</h4>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('account.update') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" value="{{ old('name',$user->name) }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input class="form-control" type="email" name="email" value="{{ old('email',$user->email) }}" required>
      <div class="form-text">ตอนนี้ยังไม่ยืนยันผ่านอีเมล (ข้ามเมลไว้ก่อน)</div>
    </div>

    <div class="d-flex gap-2">
      <a href="{{ route('account.show') }}" class="btn btn-light w-50">Back</a>
      <button class="btn btn-primary w-50">Save</button>
    </div>
  </form>
</div>
@endsection
