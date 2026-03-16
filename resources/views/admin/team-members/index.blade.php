@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Team Members</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD MEMBER --}}

<form method="POST"
action="{{ route('admin.team.members.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text"
name="name"
class="form-control"
placeholder="Member Name"
required>
</div>

<div class="col-md-3">
<input type="text"
name="designation"
class="form-control"
placeholder="Designation">
</div>

<div class="col-md-3">
<input type="file"
name="image"
class="form-control">
</div>

<div class="col-md-1 d-flex align-items-center">
<label>
<input type="checkbox" name="status" value="1" checked>
Active
</label>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Add Member
</button>
</div>

</div>

</form>



{{-- TEAM LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Member</th>
<th>Status</th>
<th >Actions</th>
</tr>
</thead>

<tbody>

@foreach($members as $member)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($member->image)
<img src="{{ asset($member->image) }}" width="60" class="rounded mb-1">
@endif
<br>
<strong>{{ $member->name }}</strong>
<br>
<small>{{ $member->designation }}</small>
</td>

<td>
<span class="badge {{ $member->status ? 'bg-success':'bg-secondary' }}">
{{ $member->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.team.members.update',$member->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="name"
value="{{ $member->name }}"
class="form-control mb-1">

<input type="text"
name="designation"
value="{{ $member->designation }}"
class="form-control mb-1">

<input type="file"
name="image"
class="form-control mb-1">

<label class="mb-1">
<input type="checkbox"
name="status"
value="1"
{{ $member->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.team.members.destroy',$member->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete member?')">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection