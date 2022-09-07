@csrf
<div class="form-group">
    <input type="text" class="form-control" name="order" default="0" title="Порядок сортировки"
           required maxlength="4" value="{{ old('order') ?? $page->order ?? '0' }}">
</div>
<!-- разрешено редактировать -->
<div class="form-check form-check-inline">
    @php
        $checked = false; // создание нового товара
        if (isset($page)) $checked = $page->editable;
        if (old('editable')) $checked = true; // были ошибки при заполнении формы
    @endphp
    <input type="checkbox" name="editable" class="form-check-input" id="editable"
           @if($checked) checked @endif value="1">
    <label class="form-check-label" for="editable">Разрешено редактировать</label>
</div>
<div class="form-group">
    @php
        $adminka = old('adminka') ?? $page->adminka ?? 0
    @endphp
        <select name="adminka" class="form-control" title="Тип страницы">
            <option value="0" @if ($adminka == 0) selected @endif>
                 Страницы сайта
            </option>
            <option value="1" @if ($adminka == 1) selected @endif>
                Страницы панели управления сайтом
            </option>
        </select>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="name" placeholder="Наименование"
               required maxlength="100" value="{{ old('name') ?? $page->name ?? '' }}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
               required maxlength="100" value="{{ old('slug') ?? $page->slug ?? '' }}">
    </div>
    <div class="form-group">
        @php
            $parent_id = old('parent_id') ?? $page->parent_id ?? 0;
    @endphp
    <select name="parent_id" class="form-control" title="Родитель">
        <option value="0">Без родителя</option>
        @foreach($parents as $parent)
            <option value="{{ $parent->id }}" @if ($parent->id == $parent_id) selected @endif>
                {{ $parent->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <textarea id="editor" class="form-control" name="content" placeholder="Контент (html)" required
              rows="10">{{ old('content') ?? $page->content ?? '' }}</textarea>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
