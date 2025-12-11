@extends('layout')

@section('title', 'จัดการสิทธิ์ผู้ใช้')

@section('content')
    <h4>จัดการสิทธิ์ผู้ใช้</h4>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>ชื่อ</th>
                <th>Email</th>
                <th>สิทธิ์ปัจจุบัน</th>
                <th>เปลี่ยนสิทธิ์</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role }}</td>
                    <td>
                        <form method="POST" action="{{ route('users.updateRole', $u->id) }}">
                            @csrf
                            <select name="role" class="form-select form-select-sm d-inline-block" style="width:auto;">
                                <option value="SALE"  @selected($u->role === 'SALE')>SALE</option>
                                <option value="ADMIN" @selected($u->role === 'ADMIN')>ADMIN</option>
                                <option value="HEAD"  @selected($u->role === 'HEAD')>HEAD</option>
                            </select>
                            <button class="btn btn-sm btn-primary">บันทึก</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
