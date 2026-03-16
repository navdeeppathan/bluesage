@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Content Sections</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD SECTION --}}
<form method="POST" action="{{ route('admin.content.sections.store') }}">
@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text"
name="title"
class="form-control"
placeholder="Section Title"
required>
</div>

<div class="col-md-6">
<textarea name="content"
class="form-control"
placeholder="Content"></textarea>
</div>

<div class="col-md-1 d-flex align-items-center">
<label>
<input type="checkbox" name="status" value="1" checked>
Active
</label>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Add Section
</button>
</div>

</div>

</form>



{{-- SECTION LIST --}}
<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Title</th>
<th>Status</th>
<th width="260">Actions</th>
</tr>
</thead>

<tbody>

@foreach($sections as $section)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
<strong>{{ $section->title }}</strong><br>
<small>{{ Str::limit($section->content,80) }}</small>
</td>

<td>
<span class="badge {{ $section->status ? 'bg-success':'bg-secondary' }}">
{{ $section->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.content.sections.update',$section->id) }}"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="title"
value="{{ $section->title }}"
class="form-control mb-1">

<textarea name="content"
class="form-control mb-1">{{ $section->content }}</textarea>

<label>
<input type="checkbox"
name="status"
value="1"
{{ $section->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.content.sections.destroy',$section->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete section?')">
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