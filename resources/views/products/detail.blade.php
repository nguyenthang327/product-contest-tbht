@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <p><strong>Tên sản phẩm:</strong>{{$product->name}}</p>
            <p><strong>Mã sản phẩm:</strong>{{$product->code}}</p>
        </div>
        <div class="row">
            <h3 class="text-red">Cấu hình</h3>
            <div class="col-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    + Thêm cấu hình
                  </button>
            </div>
            {{-- <div class="row d-flex mt-3">
                @foreach($product->productConfigs as $productConfig)
                    <button type="button" class="btn col-3 border" data-bs-toggle="modal" data-bs-target="#editConfig{{$productConfig->id}}">
                        {{$productConfig->name}}
                    </button>
                    
                @endforeach
            </div> --}}
            <div class="row mt-3">
                @include('products.partials.product-config')
            </div>
            <div class="mt-3 d-flex">
                
            </div>
        </div>
    </div>
    @include('products.partials.modal-config')
@endsection

@section('append_js')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.btn-add-specification', function(){
                // $(this).parent().append($('.specification').html())
                // console.log($('.wrap-select-specification').html());
                let newRow = `<tr class="specification-trow">
                    ${$('.wrap-select-specification').html()}
                    </tr>`
                $(this).closest('.specification_wrap').find('.specification-table-body').append(newRow)
            });

            // function setSelect2(){

            //     $('.specification-id').select2({
            //         allowClear: true,
            //         placeholder: "Chọn thông số",
            //     });
    
            //     $('.select-specificaiton-group').select2({
            //         allowClear: true,
            //         placeholder: "Chọn nhóm thông số",
            //     }).on('change', function(){
            //         let trow = $(this).closest('.specification-trow');
            //         var specification = trow.find('.specification-id');
            //         specification.val('');
            //         specification.html('<option></option>');
            //         if($(this).val()){
            //             $.ajax({
            //                 url: window.location.origin + '/get-by-specification-group',
            //                 data: {
            //                     specificationGroupId: $(this).val()
            //                 },
            //                 method: 'GET',
            //                 success: function (data){
            //                     console.log(data);
            //                     data.data.forEach((value, index) => {
            //                         specification.append(`<option value="${value.id}">${value.name}</option>`);
            //                     });
            //                     specification.select2({
            //                         allowClear: true,
            //                         placeholder: "Chọn thông số",
                                    
            //                     });
            //                 },
            //                 error: function (err){
            //                     console.log(err);
            //                 }
            //             })
            //         }
            //     });
            // }

            $(document).on('change', '.select-specificaiton-group', function(){
                let trow = $(this).closest('.specification-trow');
                var specification = trow.find('.specification-id');
                specification.val('');
                specification.html('<option>Chọn thông số</option>');
                if($(this).val()){
                    $.ajax({
                        url: window.location.origin + '/get-by-specification-group',
                        data: {
                            specificationGroupId: $(this).val()
                        },
                        method: 'GET',
                        success: function (data){
                            data.data.forEach((value, index) => {
                                specification.append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        },
                        error: function (err){
                            console.log(err);
                        }
                    })
                }
            })
        });
    </script>
@endsection