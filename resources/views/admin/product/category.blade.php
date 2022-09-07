@extends('layout.admin', ['title' => 'Товары категории'])

@section('content')
    <h4>
    @php
        $i=1;
    @endphp
    @foreach ($parents as $parent)
        @if($i>1) <i class="fas fa-caret-right"></i> @endif
        @if($i<count($parents))
            <a href="{{ route('admin.product.category', ['category' => $parent->id]) }}">{{ $parent->name }}</a>
            @else <span class="font-weight-bold">{{ $parent->name }}</span>@endif
        @php $i++; @endphp
    @endforeach
    </h4>
    <!-- Дочерние категории для возможности навигации -->
    <ul>
        @foreach ($category->children as $child)
            <li>
                <a href="{{ route('admin.product.category', ['category' => $child->id]) }}">
                    {{ $child->name }}
                </a>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('admin.product.create', ['category' => $category->id]) }}" class="btn btn-success mb-4">
        Создать товар в этой категории
    </a>
    <!-- Список товаров выбранной категории -->
    @if (count($products))
        <table class="table table-bordered">
            <tr>
                <th width="30%">Наименование</th>
                <th width="65%">Описание</th>
                <th><i class="fas fa-edit"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <a href="{{ route('admin.product.show', ['product' => $product->id]) }}">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td>{{ iconv_substr($product->content, 0, 150) }}</td>
                    <td>
                        <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.product.destroy', ['product' => $product->id]) }}"
                              method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $products->links() }}
    @else
        <p>Нет товаров в этой категории</p>
    @endif
@endsection
