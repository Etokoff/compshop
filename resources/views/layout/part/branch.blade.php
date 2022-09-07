<ul class="list-unstyled">
    @foreach ($items->where('parent_id', $parent) as $item)
        <li>
            <a href="{{ route('catalog.category', [$item->slug]) }}">{{ $item->name }}</a>
            @if ($item->chld_ct>0)
                <span class="badge badge-dark" onclick="ToggleCatalog(this)" onmouseover="this.style.cursor='pointer'">
                    <i id="fa-{{$item->slug}}" class="fa fa-plus"></i>
                </span>
                <ul id="{{$item->slug}}" style="display: none;"></ul>
            @endif
        </li>
    @endforeach
</ul>
