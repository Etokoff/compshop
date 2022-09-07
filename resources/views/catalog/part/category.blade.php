<div class="card"
     onmouseover="$(this).addClass('shadow p-0').addClass('text-primary');this.style.cursor='pointer';"
     onmouseout="$(this).removeClass('shadow p-0').removeClass('text-primary');"
     onclick="return location.href = '{{ route('catalog.category', ['category' => $category->slug]) }}'">
    <div class="card-header">
        <h4 class="mb-0">{{ $category->name }}</h4>
    </div>
</div>
