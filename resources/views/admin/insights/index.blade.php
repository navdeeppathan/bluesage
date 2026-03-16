@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Insights</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD INSIGHT --}}

<form method="POST"
action="{{ route('admin.insights.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<select name="media_type" class="form-control" required>
<option value="">Select Media Type</option>
<option value="image">Image</option>
<option value="video">Video</option>
</select>
</div>

<div class="col-md-4">
<input type="file" name="media" class="form-control" required>
</div>

<div class="col-md-2 d-flex align-items-center">
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



{{-- INSIGHT LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Media</th>
<th>Type</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($insights as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>

@if($item->media_type == 'image')

<img src="{{ asset($item->media_url) }}" width="120">

@else

<video width="150" controls>
<source src="{{ asset($item->media_url) }}">
</video>

@endif

</td>

<td>{{ ucfirst($item->media_type) }}</td>

<td>
<span class="badge {{ $item->status ? 'bg-success':'bg-secondary' }}">
{{ $item->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.insights.update',$item->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<select name="media_type" class="form-control mb-1">
<option value="image" {{ $item->media_type=='image'?'selected':'' }}>Image</option>
<option value="video" {{ $item->media_type=='video'?'selected':'' }}>Video</option>
</select>

<input type="file" name="media" class="form-control mb-1">

<label>
<input type="checkbox" name="status" value="1" {{ $item->status?'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.insights.destroy',$item->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete insight?')">
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