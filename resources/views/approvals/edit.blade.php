<form method="POST" action="{{ route('approvals.update', $current->group_id) }}">
    @csrf
    @method('PUT')
        <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name', $current->customer_name) }}" required>
