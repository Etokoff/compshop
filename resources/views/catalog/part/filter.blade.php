<div class="col-1">
    <a href="{{ route('catalog.viewmode', ['toViewMode' => '0']) }}" class="nav-item"><i class="fa fa-th-large fa-2x"></i></a>
    <a href="{{ route('catalog.viewmode', ['toViewMode' => '1']) }}" class="nav-item"><i class="fa fa-th-list fa-2x"></i></a>
</div>
<div class="col-3">
<!-- сортировка -->
    <div class="sorting">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSortButton"
                data-toggle="dropdown" data-order="{{ $orderBy }}" aria-haspopup="true" aria-expanded="false">
            {!!  $orderByName !!}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownSortButton">
            <li class="dropdown-item"><span class="sorting_item" style="width: 100%" data-order="default">По-умолчанию</span></li>
            <li class="dropdown-item"><span class="sorting_item" style="width: 100%" data-order="price-low-high">Цена <i class="fas fa-sort-numeric-down"></i></span></li>
            <li class="dropdown-item"><span class="sorting_item" style="width: 100%" data-order="price-high-low">Цена <i class="fas fa-sort-numeric-down-alt"></i></span></li>
            <li class="dropdown-item"><span class="sorting_item" style="width: 100%" data-order="name-a-z">Название <i class="fas fa-sort-alpha-down"></i></span></li>
            <li class="dropdown-item"><span class="sorting_item" style="width: 100%" data-order="name-z-a">Название <i class="fas fa-sort-alpha-down-alt"></i></span></li>
        </div>
    </div>
</div>
<div class="col-2">
    <select class="form-control" name="pagination" id="pagination">
        <option value="3">3</option>
        <option selected value="9">9</option>
        <option value="27">27</option>
        <option value="81">81</option>
    </select>
</div>
<div class="col-6">
    <div class="row">
<!-- новинка -->
        <div class="col">
            <input type="checkbox" name="new" class="form-check-input" id="new-product"
                @if(request()->has('new')) checked @endif value="yes">
            <label class="form-check-label" for="new-product">Новинка</label>
        </div>
        <div class="col">
<!-- лидер продаж -->
            <input type="checkbox" name="hit" class="form-check-input" id="hit-product"
                @if(request()->has('hit')) checked @endif value="yes">
            <label class="form-check-label" for="hit-product">Лидер продаж</label>
        </div>
        <div class="col">
<!-- распродажа -->
            <input type="checkbox" name="sale" class="form-check-input" id="sale-product"
                @if(request()->has('sale')) checked @endif value="yes">
            <label class="form-check-label" for="sale-product">Распродажа</label>
        </div>
        <div class="col">
<!-- скидка -->
            <input type="checkbox" name="discount" class="form-check-input" id="discount-product"
                   @if(request()->has('discount')) checked @endif value="yes">
            <label class="form-check-label" for="sale-product">Скидка</label>
        </div>
    </div>
</div>

