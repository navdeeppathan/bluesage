@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Awards</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD AWARD --}}

<form method="POST"
action="{{ route('admin.awards.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text"
name="title"
class="form-control"
placeholder="Award Title"
required>
</div>

<div class="col-md-2">
<input type="number"
name="year"
class="form-control"
placeholder="Year">
</div>

<div class="col-md-3">
<input type="file"
name="image"
class="form-control">
</div>

<div class="col-md-2 d-flex align-items-center">
<label>
<input type="checkbox" name="status" value="1" checked>
Active
</label>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Add Award
</button>
</div>

</div>

<div class="row mb-3">
<div class="col-md-12">
<textarea name="description"
class="form-control"
placeholder="Award Description"></textarea>
</div>
</div>

</form>



{{-- AWARD LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Image</th>
<th>Title</th>
<th>Year</th>
<th>Status</th>
<th width="260">Actions</th>
</tr>
</thead>

<tbody>

@foreach($awards as $award)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($award->image)
<img src="{{ asset($award->image) }}" width="100">
@endif
</td>

<td>{{ $award->title }}</td>

<td>{{ $award->year }}</td>

<td>
<span class="badge {{ $award->status ? 'bg-success':'bg-secondary' }}">
{{ $award->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.awards.update',$award->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="title"
value="{{ $award->title }}"
class="form-control mb-1">

<input type="number"
name="year"
value="{{ $award->year }}"
class="form-control mb-1">

<input type="file"
name="image"
class="form-control mb-1">

<textarea name="description"
class="form-control mb-1">{{ $award->description }}</textarea>

<label class="mb-1">
<input type="checkbox"
name="status"
value="1"
{{ $award->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.awards.destroy',$award->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete award?')">
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