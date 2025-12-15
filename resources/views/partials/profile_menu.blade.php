@php
  $u = auth()->user();
  $avatarUrl = $u->avatar_path ? asset('storage/'.$u->avatar_path) : null;
  $initials = strtoupper(mb_substr($u->name ?? 'U', 0, 1));
@endphp

<span class="d-inline-flex justify-content-center align-items-center"
      style="width:34px;height:34px;border-radius:50%;overflow:hidden;background:#6c757d;color:#fff;font-weight:700;">
  @if($avatarUrl)
    <img src="{{ $avatarUrl }}" style="width:100%;height:100%;object-fit:cover;">
  @else
    {{ $initials }}
  @endif
</span>
