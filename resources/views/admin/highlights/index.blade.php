@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Highlights</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD HIGHLIGHT --}}

<form method="POST"
action="{{ route('admin.highlights.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text"
name="title"
class="form-control"
placeholder="Highlight Title"
required>
</div>

<div class="col-md-3">
<input type="file"
name="image"
class="form-control">
</div>

<div class="col-md-3">
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
Add Highlight
</button>
</div>

</div>

</form>



{{-- HIGHLIGHT LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Image</th>
<th>Title</th>
<th>Status</th>
<th >Actions</th>
</tr>
</thead>

<tbody>

@foreach($highlights as $highlight)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($highlight->image)
<img src="{{ asset($highlight->image) }}" width="80">
@endif
</td>

<td>{{ $highlight->title }}</td>

<td>
<span class="badge {{ $highlight->status ? 'bg-success':'bg-secondary' }}">
{{ $highlight->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.highlights.update',$highlight->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="title"
value="{{ $highlight->title }}"
class="form-control mb-1">

<input type="file"
name="image"
class="form-control mb-1">

<textarea name="description"
class="form-control mb-1">{{ $highlight->description }}</textarea>

<label>
<input type="checkbox"
name="status"
value="1"
{{ $highlight->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.highlights.destroy',$highlight->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete highlight?')">
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