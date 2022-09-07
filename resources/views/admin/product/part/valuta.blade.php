@foreach ($items as $item)
    <option value="{{ $item->id }}" @if ($item->id == $valuta_id) selected @endif>
         {{ $item->vnazva }}
    </option>
@endforeach
