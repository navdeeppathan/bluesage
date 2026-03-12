@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Blogs</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD BLOG --}}
<form method="POST"
      action="{{ route('admin.blogs.store') }}"
      enctype="multipart/form-data">

@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="text" name="title" class="form-control" placeholder="Title" required>
</div>

<div class="col-md-2">
<input type="text" name="author" class="form-control" placeholder="Author">
</div>

<div class="col-md-2">
<input type="text" name="category" class="form-control" placeholder="Category">
</div>

<div class="col-md-2">
<input type="date" name="published_date" class="form-control">
</div>

<div class="col-md-3">
<input type="file" name="image" class="form-control">
</div>

</div>

<div class="row mb-3">

<div class="col-md-10">
<textarea name="description"
          class="form-control"
          placeholder="Description"></textarea>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Add Blog
</button>
</div>

</div>

</form>



{{-- BLOG LIST --}}

<table class="table table-bordered align-middle">

<thead>

<tr>
<th>#</th>
<th>Blog</th>
<th>Category</th>
<th>Date</th>
<th width="250">Actions</th>
</tr>

</thead>

<tbody>

@foreach($blogs as $blog)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
@if($blog->image)
<img src="{{ asset($blog->image) }}" width="60" class="rounded mb-1">
@endif
<br>
<strong>{{ $blog->title }}</strong>
<br>
<small>{{ $blog->author }}</small>
</td>

<td>{{ $blog->category }}</td>

<td>{{ $blog->published_date?->format('d M Y') }}</td>

<td>

{{-- UPDATE --}}
<form method="POST"
      action="{{ route('admin.blogs.update',$blog->id) }}"
      enctype="multipart/form-data"
      class="mb-2">

@csrf
@method('PUT')

<input type="text" name="title" value="{{ $blog->title }}" class="form-control mb-1">

<input type="text" name="author" value="{{ $blog->author }}" class="form-control mb-1">

<input type="text" name="category" value="{{ $blog->category }}" class="form-control mb-1">

<input type="date" name="published_date" value="{{ $blog->published_date?->format('Y-m-d') }}" class="form-control mb-1">

<input type="file" name="image" class="form-control mb-1">

<textarea name="description" class="form-control mb-1">{{ $blog->description }}</textarea>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
      action="{{ route('admin.blogs.destroy',$blog->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete blog?')">
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