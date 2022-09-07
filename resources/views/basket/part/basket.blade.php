<a class="nav-link @if ($positions) text-success @endif"
   href="{{ route('basket.index') }}">
    <i class="fa fa-shopping-basket" aria-hidden="true" title="Корзина"></i>
    @if ($positions) ({{ $positions }}) @endif
</a>
