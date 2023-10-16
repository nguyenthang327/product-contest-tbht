@extends('layouts.master')

@section('content')
    <a href="{{route('component.create')}}">Thêm linh kiện</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Tên</th>
                <th scope="col">Giá</th>
                <th scope="col">Đơn vị</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($components as $index => $item)
            <tr>
                <th scope="row">{{++$index}}</th>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->measure }}</td>
                <td>{{ $item->desc }}</td>
                <td>
                    <a href="{{route('component.edit', ['id' => $item->id])}}">Edit</a>
                    <form method="POST" action="{{route('component.delete', ['id' => $item->id])}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
