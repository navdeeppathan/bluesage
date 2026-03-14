@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Services</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD SERVICE --}}

<form method="POST"
action="{{ route('admin.services.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text"
name="title"
class="form-control"
placeholder="Service Title"
required>
</div>

<div class="col-md-3">
<input type="file"
name="icon_img"
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
Add Service
</button>
</div>

</div>

</form>



{{-- SERVICE LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Icon</th>
<th>Title</th>
<th>Status</th>
<th width="250">Actions</th>
</tr>
</thead>

<tbody>

@foreach($services as $service)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($service->icon_img)
<img src="{{ asset($service->icon_img) }}" width="60">
@endif
</td>

<td>{{ $service->title }}</td>

<td>
<span class="badge {{ $service->status ? 'bg-success':'bg-secondary' }}">
{{ $service->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.services.update',$service->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="title"
value="{{ $service->title }}"
class="form-control mb-1">

<input type="file"
name="icon_img"
class="form-control mb-1">

<textarea name="description"
class="form-control mb-1">{{ $service->description }}</textarea>

<label>
<input type="checkbox"
name="status"
value="1"
{{ $service->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.services.destroy',$service->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete service?')">
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