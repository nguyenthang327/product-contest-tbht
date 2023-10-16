@extends('layouts.master')

@section('content')
    <pre>
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
    </pre>
    <form action="{{route('component.update', ['id' => $component->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" name="code" value="{{$component->code}}">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{$component->name}}">
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Desc</label>
            <input type="text" class="form-control" name="desc" value="{{$component->desc}}">
        </div>
        <div class="mb-3">
            <label for="measure" class="form-label">Measure</label>
            <input type="text" class="form-control" name="measure" value="{{$component->measure}}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" value="{{$component->price}}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
