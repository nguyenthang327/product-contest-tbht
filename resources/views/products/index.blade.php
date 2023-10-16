@extends('layouts.master')

@section('content')
    <a href="{{route('product.create')}}">Thêm sản phẩm</a>
    <form action="" method="get">
        <input type="text" name="keySearch" value="{{request()->get('keySearch')}}">
        <select name="type">
            <option value="" selected>Chọn loại sản phẩm</option>
            <option value="1" {{request()->get("type") == 1 ? "selected" : ''}}>Sản phẩm</option>
            <option value="2" {{request()->get("type") == 2 ? "selected" : ''}}>Biến thể</option>
        </select>
        <button type="submit">search</button>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã hiệu</th>
                <th scope="col">Tên</th>
                {{-- <th scope="col">Giá bán</th> --}}
                <th scope="col">Loại</th>
                <th scope="col">Mã sản phẩm cha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
            <tr class='clickable-row' data-href='{{route('product.detail', ['id'=> $product->id])}}'>
                <th scope="row">{{++$index}}</th>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                {{-- <td>{{ $product->price ?? 0 }}</td> --}}
                <td>{{ $product->type == 1 ? 'Sản phẩm' : ($product->type == 2 ? 'Biến thể' : '') }}</td>
                {{-- <td>{{ !empty($product->parent) ? $product->parent->code : '' }}</td> --}}
                <td>{{ $product->parent_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('append_js')
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
@endsection
