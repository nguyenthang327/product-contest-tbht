<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    @foreach($product->productConfigs as $key => $productConfig)
    <li class="nav-item" role="presentation">
        <button class="nav-link {{$key == 0 ? 'active' : ''}}" id="pills-product-config-tab-{{$productConfig->id}}" data-bs-toggle="pill" data-bs-target="#pills-product-config-{{$productConfig->id}}" type="button"
            role="tab" aria-controls="pills-product-config-{{$productConfig->id}}" aria-selected="true"> {{$productConfig->name}}</button>
    </li>
    @endforeach
</ul>
<div class="tab-content" id="pills-tabContent">
    @foreach($product->productConfigs as $key => $productConfig)
    <div class="tab-pane fade {{$key == 0 ? 'show active' : ''}}" id="pills-product-config-{{$productConfig->id}}" role="tabpanel" aria-labelledby="pills-home-tab">
        {{-- {{$productConfig->name}} --}}
        <h5>Danh sách thông số</h5>
        @php
            $sumPriceComponent = 0;
    
            // nhóm theo danh sách thông số
            $groupSpecifications = $productConfig->specifications->groupBy('specification_group_id');
        @endphp
        @foreach($productConfig->specifications as $specification)
            @foreach($specification->components as $component)
                @php
                    $sumPriceComponent += $component->price * $component->pivot->quantity;
                @endphp
            @endforeach
            {{-- <p>{{$specification->name}}</p> --}}
        @endforeach
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Nhóm thông số</th>
                    <th scope="col">Thông số</th>
                </tr>
            </thead>
            <tbody>
                @forEach($groupSpecifications as $keyGroup => $groupSpecification)
                <tr>
                    <td class="col-6">
                        @php
                            $nameGroupSpecification = '';
                            switch ($keyGroup) {
                                case 1:
                                    $nameGroupSpecification = 'CPU';
                                    break;
                                case 2:
                                    $nameGroupSpecification = 'RAM';
                                    break;
                                case 3:
                                    $nameGroupSpecification = 'Ổ cứng';
                                    break;
                                case 4:
                                    $nameGroupSpecification = 'Màu';
                                    break;
                                case 5:
                                    $nameGroupSpecification = 'Pin';
                                    break;
                            }
                        @endphp
                        {{$nameGroupSpecification}}
                    </td>
                    <td class="col-6">
                        {{$groupSpecification->pluck('name')->implode(", ")}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h6>Mã cấu hình: {{$productConfig->code}}</h6>
        <h6>Tổng giá nguyên liệu: {{$sumPriceComponent}}</h6>
        <h6>Giá bán: {{$productConfig->price}}</h6>
        <button type="button" class="btn col-1 border" data-bs-toggle="modal" data-bs-target="#editConfig{{$productConfig->id}}">
            edit
        </button>        
    </div>
    @endforeach
</div>
