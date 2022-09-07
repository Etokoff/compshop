@extends('layout.site', ['title' => $category->name])

@section('content')
    <h4>
        @php
            $i=1;
        @endphp
        @foreach ($parents as $parent)
            @if($i>1) <i class="fas fa-caret-right"></i> @endif
            @if($i<count($parents))
                <a href="{{ route('catalog.category', ['category' => $parent->slug]) }}">{{ $parent->name }}</a>
            @else <span class="font-weight-bold">{{ $parent->name }}</span>@endif
            @php $i++; @endphp
        @endforeach
    </h4>
    <p>{{ $category->content }}</p>
    <div class="row">
        @foreach ($category->children as $child)
            @include('catalog.part.category', ['category' => $child])
        @endforeach
    </div>
    <!-- Фильтр для товаров категории -->
    <div class="bg-info p-2 mb-4" style="margin-left: -15px; margin-right: -15px;">
        <div class="row">
            @include('catalog.part.filter', ['orderBy' => $orderBy, 'orderByName' => $orderByName])
        </div>
    </div>
    <div id="products">
    @include('catalog.part.list', ['products' => $products])
    </div>
@endsection
