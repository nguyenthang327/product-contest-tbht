@extends('layouts.master')

@section('content')
    <pre>
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
    </pre>
    <form action="{{route('product.store')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Mã hiệu</label>
            <input type="text" class="form-control" name="code">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá bán</label>
            <input type="text" class="form-control" name="price">
        </div>

        <div class="mb-3 d-flex">
            <div class="col-4">
                <select class="form-select" name="type" required id="type_product">
                    <option selected value="">Chọn phân loại</option>
                    <option value="1">Sản phẩm</option>
                    <option value="2">Biển thể</option>
                </select>
            </div>
        </div>
        
        <div class="is_variant d-none">
            <div class="mb-3 d-flex">
                <div class="col-4">
                    <select class="form-select" name="parent_id" id="parent_product">
                        <option selected value="">Chọn sản phẩm cha</option>
                        @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- <div class="is_product">
            <p>Chọn thông số cho cấu hình mặc định</p>
            <div class="mb-3 d-flex">
                <div class="col-4">
                    <select class="form-select" name="specification[]">
                        <option selected value="">Chọn thông số</option>
                        @foreach ($specifications as $specification)
                            <option value="{{$specification->id}}">{{$specification->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 d-flex">
                <div class="col-4">
                    <select class="form-select" name="specification[]">
                        <option selected value="">Chọn thông số</option>
                        @foreach ($specifications as $specification)
                            <option value="{{$specification->id}}">{{$specification->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> --}}
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection


@section('append_js')
    <script>
        $(document).ready(function(){
            $(document).on('change', '#type_product', function(){
                if($(this).val() == 2){
                    $('.is_variant').removeClass('d-none');
                    $("#parent_product").attr("required", true);
                }else{
                    $('.is_variant').addClass('d-none');
                    $("#parent_product").attr("required", false);
                }
            })
        })
    </script>
@endsection
