@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Testimonials</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD TESTIMONIAL --}}

<form method="POST"
action="{{ route('admin.testimonials.store') }}"
enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text"
name="name"
class="form-control"
placeholder="Client Name"
required>
</div>

<div class="col-md-3">
<input type="text"
name="designation"
class="form-control"
placeholder="Designation">
</div>

<div class="col-md-2">
<input type="number"
name="rating"
class="form-control"
placeholder="Rating (1-5)"
min="1"
max="5">
</div>

<div class="col-md-2">
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

<div class="col-md-1">
<button class="btn btn-primary w-100">
Add
</button>
</div>

</div>

<div class="row mb-3">
<div class="col-md-12">
<textarea name="message"
class="form-control"
placeholder="Testimonial Message"
rows="3"></textarea>
</div>
</div>

</form>



{{-- TESTIMONIAL LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Client</th>
<th>Rating</th>
<th>Status</th>
<th width="260">Actions</th>
</tr>
</thead>

<tbody>

@foreach($testimonials as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($item->image)
<img src="{{ asset($item->image) }}" width="60" class="rounded mb-1">
@endif
<br>
<strong>{{ $item->name }}</strong>
<br>
<small>{{ $item->designation }}</small>
</td>

<td>
⭐ {{ $item->rating }}/5
</td>

<td>
<span class="badge {{ $item->status ? 'bg-success':'bg-secondary' }}">
{{ $item->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.testimonials.update',$item->id) }}"
enctype="multipart/form-data"
class="mb-2">

@csrf
@method('PUT')

<input type="text"
name="name"
value="{{ $item->name }}"
class="form-control mb-1">

<input type="text"
name="designation"
value="{{ $item->designation }}"
class="form-control mb-1">

<input type="number"
name="rating"
value="{{ $item->rating }}"
class="form-control mb-1">

<input type="file"
name="image"
class="form-control mb-1">

<textarea name="message"
class="form-control mb-1">{{ $item->message }}</textarea>

<label class="mb-1">
<input type="checkbox"
name="status"
value="1"
{{ $item->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.testimonials.destroy',$item->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete testimonial?')">
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