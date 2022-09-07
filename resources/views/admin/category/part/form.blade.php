@csrf
<div class="form-group">
    <input type="text" class="form-control" name="name" placeholder="Наименование"
           required maxlength="100" value="{{ old('name') ?? $category->name ?? '' }}">
</div>
<div class="form-group">
    <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $category->slug ?? '' }}">
</div>
<div class="form-group">
    @php
        $parent_id = old('parent_id') ?? $category->parent_id ?? 0;
        if (isset($parent)) {
            $parent_id = $parent->id;
            $parent_name = $parent->name;
        } else {
            $parent_name = $category->getParent->name;
        }
    @endphp
    <select name="category_id" class="form-control" title="Категория">
        <option value="{{ $parent_id }}">{{ $parent_name  }}</option>
    </select>
</div>
<div class="form-group">
    <textarea class="form-control" name="content" placeholder="Краткое описание"
              maxlength="200" rows="3">{{ old('content') ?? $category->content ?? '' }}</textarea>
</div>
<div class="form-group">
    <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
</div>
@isset($category->image)
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">Удалить загруженное изображение</label>
    </div>
@endisset
<div class="form-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
