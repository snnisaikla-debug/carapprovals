@extends('layout')

@section('content')
<div class="container" style="max-width: 420px;">
    <h4 class="mb-3 text-danger">ยืนยันการลบบัญชี</h4>

    <div class="alert alert-warning">
        การลบบัญชีไม่สามารถกู้คืนได้<br>
        กรุณาพิมพ์คำว่า <strong>DELETE</strong> เพื่อยืนยัน
    </div>

    <form method="POST" action="{{ route('account.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label class="form-label">
                พิมพ์คำว่า <strong>DELETE</strong> เพื่อยืนยัน
            </label>
            <input type="text"
                name="confirm_text"
                class="form-control"
                required>
        </div>

        <button type="submit" class="btn btn-danger">
            ลบบัญชีถาวร
        </button>
    </form>

</div>
@endsection
