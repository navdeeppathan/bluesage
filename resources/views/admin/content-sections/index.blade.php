@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-4">Content Section</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.content.sections.store') }}">
@csrf

<div class="mb-3">
<label class="form-label">Title</label>
<input type="text"
name="title"
class="form-control"
value="{{ $section->title ?? '' }}"
required>
</div>

<div class="mb-3">
<label class="form-label">Content</label>

<textarea
name="content"
id="editor"
class="form-control"
rows="8">{{ $section->content ?? '' }}</textarea>

</div>

<div class="mb-3">
<label>
<input type="checkbox"
name="status"
value="1"
{{ isset($section) && $section->status ? 'checked' : '' }}>
Active
</label>
</div>

<button class="btn btn-primary">
Save Content
</button>

</form>

</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace('editor');
</script>

@endsection






