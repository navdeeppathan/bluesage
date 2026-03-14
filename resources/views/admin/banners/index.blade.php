@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Banners</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD BANNER --}}

<form method="POST"
action="{{ route('admin.banners.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text"
name="title"
class="form-control"
placeholder="Banner Title">
</div>

<div class="col-md-3">
<input type="file"
name="image"
class="form-control"
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

<div class="col-md-1">
<button class="btn btn-primary w-100">
Add
</button>
</div>

</div>

</form>



{{-- BANNER LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Image</th>
<th>Title</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($banners as $banner)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($banner->image)
<img src="{{ asset($banner->image) }}" width="120">
@endif
</td>

<td>{{ $banner->title }}</td>

<td>
<span class="badge {{ $banner->status ? 'bg-success':'bg-secondary' }}">
{{ $banner->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.banners.update',$banner->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="title"
value="{{ $banner->title }}"
class="form-control mb-1">

<input type="file"
name="image"
class="form-control mb-1">

<textarea name="description"
class="form-control mb-1">{{ $banner->description }}</textarea>

<label class="mb-1">
<input type="checkbox"
name="status"
value="1"
{{ $banner->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.banners.destroy',$banner->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete banner?')">
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