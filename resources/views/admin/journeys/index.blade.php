@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Company Journey</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD JOURNEY --}}

<form method="POST" action="{{ route('admin.journeys.store') }}">
@csrf

<div class="row mb-3">

<div class="col-md-2">
<input type="text"
name="period"
class="form-control"
placeholder="Period (2018-2020)"
required>
</div>

<div class="col-md-3">
<input type="text"
name="title"
class="form-control"
placeholder="Milestone Title"
required>
</div>

<div class="col-md-4">
<textarea name="description"
class="form-control"
placeholder="Description"></textarea>
</div>

<div class="col-md-1 d-flex align-items-center">
<label>
<input type="checkbox" name="status" value="1" checked>
Active
</label>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Add
</button>
</div>

</div>

</form>



{{-- JOURNEY LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Period</th>
<th>Title</th>
<th>Description</th>
<th>Status</th>
<th width="260">Actions</th>
</tr>
</thead>

<tbody>

@foreach($journeys as $journey)

<tr>

<td>{{ $loop->iteration }}</td>

<td><strong>{{ $journey->period }}</strong></td>

<td>{{ $journey->title }}</td>

<td>{{ $journey->description }}</td>

<td>
<span class="badge {{ $journey->status ? 'bg-success':'bg-secondary' }}">
{{ $journey->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.journeys.update',$journey->id) }}"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="period"
value="{{ $journey->period }}"
class="form-control mb-1">

<input type="text"
name="title"
value="{{ $journey->title }}"
class="form-control mb-1">

<textarea name="description"
class="form-control mb-1">{{ $journey->description }}</textarea>

<label class="mb-1">
<input type="checkbox"
name="status"
value="1"
{{ $journey->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.journeys.destroy',$journey->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete journey?')">
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