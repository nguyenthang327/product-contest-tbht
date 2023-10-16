@extends('layouts.master')

@section('content')
    <pre>
        @if($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
    </pre>
    <form action="{{route('specification.store')}}" method="POST">
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
            <div class="col-4">
                <label for="specification_group_id" class="form-label">Thuộc nhóm thông số</label>
                <select class="form-select" name="specification_group_id" required>
                    <option selected value="">Chọn nhóm thông số</option>
                    <option value="1">CPU</option>
                    <option value="2">RAM</option>
                    <option value="3">Ổ cứng</option>
                    <option value="4">Màu</option>
                    <option value="5">Pin</option>
                </select>
            </div>
        </div>
        <div class="component-group">
            <p>Chọn linh kiện cần dùng cho thông số này:</p>
            <a href="#" class="add-component">+ Thêm linh kiện</a>
            <div class="d-none" id="initComponent">
                <div class="mb-3 d-flex ">
                    <div class="col-4">
                        <select class="form-select" name="component[id][]">
                            <option selected value="">Chọn linh kiện</option>
                            @foreach ($components as $component)
                                <option value="{{$component->id}}">{{$component->name}} ({{$component->measure}})</option>
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="col-4">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="component[quantity][]"/>
                    </div>
                </div>
            </div>
    
            {{-- <div class="mb-3 d-flex">
                <div class="col-4">
                    <select class="form-select" name="component[id][]">
                        <option selected value="">Chọn linh kiện</option>
                        @foreach ($components as $component)
                            <option value="{{$component->id}}">{{$component->name}} ({{$component->measure}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="component[quantity][]"/>
                </div>
            </div> --}}
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('append_js')
    <script>
        $(document).on('click', '.add-component', function(){
            $('.component-group').append($('#initComponent').html());
            // $('#initComponent').html();
            // console.log($('#initComponent').html());
        })
    </script>
@endsection
