<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('productConfig.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm cấu hình</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Mã cấu hình</label>
                        <input type="text" class="form-control" name="code">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên cấu hình</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá bán</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="mb-3 specification_wrap">
                        <h6>Thông số</h6>
                        <a href="#" class="btn-add-specification"> + Thêm thông số</a>
                        {{-- <div class="col-12 specification d-none">
                            <select class="form-select mt-3" name="specification_ids[]">
                                <option selected value="">Chọn thông số</option>
                                @foreach ($specifications as $specification)
                                    <option value="{{$specification->id}}">{{$specification->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nhóm thông số</th>
                                    <th scope="col">Thông số</th>
                                </tr>
                            </thead>
                            <tbody class="specification-table-body">
                                <tr class="specification-trow wrap-select-specification d-none">
                                    <td class="col-6">
                                        <select class="form-select select-specificaiton-group"
                                            name="specification_group_id[]">
                                            <option selected value="">Chọn nhóm thông số</option>
                                            <option value="1">CPU</option>
                                            <option value="2">RAM</option>
                                            <option value="3">Ổ cứng</option>
                                            <option value="4">Màu</option>
                                            <option value="5">Pin</option>
                                        </select>
                                    </td>
                                    <td class="col-6">
                                        <select class="form-select mt-3 specification-id" name="specification_ids[]"
                                            multiple>
                                            <option selected value="">Chọn thông số</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal Edit -->
@foreach ($product->productConfigs as $productConfig)
    <div class="modal fade" id="editConfig{{ $productConfig->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('productConfig.update', ['id' => $productConfig->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sửa cấu hình</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="code" class="form-label">Mã cấu hình</label>
                            <input type="text" class="form-control" name="code"
                                value="{{ $productConfig->code }}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên cấu hình</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ $productConfig->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá bán</label>
                            <input type="number" class="form-control" name="price"
                                value="{{ $productConfig->price }}">
                        </div>
                        <div class="mb-3 specification_wrap">
                            <h6>Thông số</h6>
                            <a href="#" class="btn-add-specification"> + Thêm thông số</a>
                            <div class="col-12">
                                {{-- @foreach ($productConfig->specifications as $item)
                                <select class="form-select mt-3" name="specification_ids[]">
                                    <option selected value="">Chọn thông số</option>
                                    @foreach ($specifications as $specification)
                                        <option value="{{$specification->id}}" {{ $item->id == $specification->id ? 'selected' : ''}}>{{$specification->name}}</option>
                                    @endforeach
                                </select>
                            @endforeach --}}
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nhóm thông số</th>
                                        <th scope="col">Thông số</th>
                                    </tr>
                                </thead>
                                <tbody class="specification-table-body">
                                    {{-- @foreach ($productConfig->specifications as $item) --}}
                                    @php
                                        // nhóm theo danh sách thông số
                                        $groupSpecifications = $productConfig->specifications->groupBy('specification_group_id');
                                    @endphp
                                    @forEach($groupSpecifications as $groupKey => $value)
                                    @php
                                        $specificationSelected = $value->pluck("id")->all();
                                    @endphp
                                    <tr class="specification-trow wrap-select-specification">
                                        <td class="col-6">
                                            <select class="form-select select-specificaiton-group"
                                                name="specification_group_id[]">
                                                <option value="">Chọn nhóm thông số</option>
                                                <option value="1" {{ $groupKey == 1 ? 'selected' : '' }}>CPU</option>
                                                <option value="2" {{ $groupKey == 2 ? 'selected' : '' }}>RAM</option>
                                                <option value="3" {{ $groupKey == 3 ? 'selected' : '' }}>Ổ cứng</option>
                                                <option value="4" {{ $groupKey == 4 ? 'selected' : '' }}>Màu</option>
                                                <option value="5" {{ $groupKey == 5 ? 'selected' : '' }}>Pin</option>
                                            </select>
                                        </td>
                                        <td class="col-6">
                                            <select class="form-select mt-3 selectpicker specification-id" name="specification_ids[]"
                                                multiple>
                                                <option value="">Chọn thông số</option>
                                                @forEach($listSpecificationGroup[$groupKey] as $item)
                                                    <option value="{{$item->id}}" {{ in_array($item->id, $specificationSelected) ? 'selected' : ''}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
