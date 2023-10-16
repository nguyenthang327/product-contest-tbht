@extends('layouts.master')

@section('content')
    <form action="{{route('component.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" name="code" >
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" >
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Desc</label>
            <input type="text" class="form-control" name="desc" >
        </div>
        <div class="mb-3">
            <label for="measure" class="form-label">Measure</label>
            <input type="text" class="form-control" name="measure">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
