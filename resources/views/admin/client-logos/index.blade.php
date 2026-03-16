@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Client Logos</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD LOGO --}}

<form method="POST"
action="{{ route('admin.client.logos.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-4">
<input type="file"
name="logo"
class="form-control"
required>
</div>

<div class="col-md-4">
<input type="url"
name="website_url"
class="form-control"
placeholder="Client Website URL">
</div>

<div class="col-md-2 d-flex align-items-center">
<label>
<input type="checkbox" name="status" value="1" checked>
Active
</label>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Add Logo
</button>
</div>

</div>

</form>



{{-- LOGO LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Logo</th>
<th>Website</th>
<th>Status</th>
<th >Actions</th>
</tr>
</thead>

<tbody>

@foreach($logos as $logo)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($logo->logo)
<img src="{{ asset($logo->logo) }}" width="120">
@endif
</td>

<td>
@if($logo->website_url)
<a href="{{ $logo->website_url }}" target="_blank">
{{ $logo->website_url }}
</a>
@endif
</td>

<td>
<span class="badge {{ $logo->status ? 'bg-success':'bg-secondary' }}">
{{ $logo->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.client.logos.update',$logo->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<input type="file"
name="logo"
class="form-control mb-1">

<input type="url"
name="website_url"
value="{{ $logo->website_url }}"
class="form-control mb-1">

<label class="mb-1">
<input type="checkbox"
name="status"
value="1"
{{ $logo->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.client.logos.destroy',$logo->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete logo?')">
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