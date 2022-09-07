@foreach ($pages->where('parent_id', 0) as $page)
    @if (count($pages->where('parent_id', $page->id)))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                {{ $page->name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @if ($page->editable)
                    <a class="dropdown-item" href="{{ route('page.show', ['page' => $page->slug]) }}">
                        {{ $page->name }}
                    </a>
                @else
                    <a class="dropdown-item" href="{{ $page->slug }}">
                        {{ $page->name }}
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                @foreach ($pages->where('parent_id', $page->id) as $child)
                    <a class="dropdown-item" href="{{ route('page.show', ['page' => $child->slug]) }}">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        </li>
    @else
        <li class="nav-item">
            @if ($page->editable)
                <a class="nav-link" href="{{ route('page.show', ['page' => $page->slug]) }}">
                    {{ $page->name }}
                </a>
            @else
                <a class="nav-link" href="{{ $page->slug }}">
                    {{ $page->name }}
                </a>
            @endif
        </li>
    @endif
@endforeach
