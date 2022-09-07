@extends('layout.site', ['title' => 'Каталог товаров'])

@section('content')
    <h1>Каталог товаров</h1>

    <p>
        Интернет-магазин электроники и бытовой техники Conishua.
        Компьюютерная техника, телевизоры, планшеты, мобильные телефоны, мелкая и крупная бытовая техника и многое другое! Официальная гарантия.
    </p>

    <h2 class="mb-4">Разделы каталога</h2>
    <div class="row">
        @foreach ($roots as $root)
            @include('catalog.part.category', ['category' => $root])
        @endforeach
    </div>
@endsection
