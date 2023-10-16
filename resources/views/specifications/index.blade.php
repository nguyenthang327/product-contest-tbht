@extends('layouts.master')

@section('content')
    <a href="{{route('specification.create')}}">Thêm thông số</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Tên</th>
                <th scope="col">Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($specifications as $index => $item)
                @php
                    $price = 0;
                    foreach($item->components as $component)
                    {
                        $price += $component->price * $component->pivot->quantity;
                    }       
                @endphp
            <tr>
                <th scope="row">{{++$index}}</th>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
