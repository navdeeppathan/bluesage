@extends('admin.layouts.admin')

@section('content')

<div class="container">

<h3 class="mb-3">Counters</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


{{-- ADD COUNTER --}}

<form method="POST" action="{{ route('admin.counters.store') }}">
@csrf

<div class="row mb-3">

<div class="col-md-3">
<input type="number"
name="number"
class="form-control"
placeholder="Counter Number"
required>
</div>

<div class="col-md-5">
<input type="text"
name="subtitle"
class="form-control"
placeholder="Subtitle (Example: Students Enrolled)"
required>
</div>

<div class="col-md-2 d-flex align-items-center">
<label>
<input type="checkbox" name="status" value="1" checked>
Active
</label>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Add Counter
</button>
</div>

</div>

</form>



{{-- COUNTER LIST --}}

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>#</th>
<th>Number</th>
<th>Subtitle</th>
<th>Status</th>
<th >Actions</th>
</tr>
</thead>

<tbody>

@foreach($counters as $counter)

<tr>

<td>{{ $loop->iteration }}</td>

<td><strong>{{ $counter->number }}</strong></td>

<td>{{ $counter->subtitle }}</td>

<td>
<span class="badge {{ $counter->status ? 'bg-success':'bg-secondary' }}">
{{ $counter->status ? 'Active':'Inactive' }}
</span>
</td>

<td>

{{-- UPDATE --}}
<form method="POST"
action="{{ route('admin.counters.update',$counter->id) }}"
class="mb-2">

@csrf
@method('PUT')

<input type="number"
name="number"
value="{{ $counter->number }}"
class="form-control mb-1">

<input type="text"
name="subtitle"
value="{{ $counter->subtitle }}"
class="form-control mb-1">

<label class="mb-1">
<input type="checkbox"
name="status"
value="1"
{{ $counter->status ? 'checked':'' }}>
Active
</label>

<button class="btn btn-sm btn-warning w-100">
Update
</button>

</form>


{{-- DELETE --}}
<form method="POST"
action="{{ route('admin.counters.destroy',$counter->id) }}">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger w-100"
onclick="return confirm('Delete counter?')">
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