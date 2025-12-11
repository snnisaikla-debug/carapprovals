@extends('layout')

@section('title', 'รายชื่อ Sales')

@section('content')
    <h4 class="mb-3">รายชื่อ Sales ทั้งหมด</h4>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อ - นามสกุล</th>
                <th>Email</th>
                <th>วันที่สร้าง</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->created_at }}</td>
                    <td>
                        <a href="{{ route('users.edit', $s->id) }}" class="btn btn-warning btn-sm">
                            แก้ไข
                        </a>

                        <form action="{{ route('users.destroy', $s->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('ลบ Sales คนนี้หรือไม่?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                ลบ
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection