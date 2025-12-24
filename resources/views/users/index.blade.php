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
                                <option value="sale"  @selected($u->role === 'sale')>sale</option>
                                <option value="admin" @selected($u->role === 'admin')>admin</option>
                                <option value="menager"  @selected($u->role === 'menager')>menager</option>
                            </select>
                            <button class="btn btn-sm btn-primary">บันทึก</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
