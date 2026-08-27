<form class="toolbar" action="{{ route('catalog') }}" method="get" aria-label="Параметры выборки" id="catalog-toolbar">
    @foreach((array) request('material', []) as $mat)
        <input type="hidden" name="material[]" value="{{ $mat }}">
    @endforeach
    @foreach((array) request('color', []) as $col)
        <input type="hidden" name="color[]" value="{{ $col }}">
    @endforeach
    @foreach((array) request('handle_exist', []) as $h)
        <input type="hidden" name="handle_exist[]" value="{{ $h }}">
    @endforeach
    @foreach((array) request('rust_exist', []) as $r)
        <input type="hidden" name="rust_exist[]" value="{{ $r }}">
    @endforeach

    <div class="toolbar__sort">
        <label class="toolbar__label" for="catalog-sort">Сортировать:</label>
        <div class="toolbar__select-wrap">
            <select id="catalog-sort" class="toolbar__select" name="sort" onchange="this.form.submit()">
                <option value="default" @selected(request('sort', 'default') === 'default')>По умолчанию</option>
                <option value="price-asc" @selected(request('sort') === 'price-asc')>По цене (сначала дешевле)</option>
                <option value="price-desc" @selected(request('sort') === 'price-desc')>По цене (сначала дороже)</option>
                <option value="name" @selected(request('sort') === 'name')>По названию</option>
            </select>
            <svg class="sprite_icon toolbar__select-icon" aria-hidden="true">
                <use xlink:href="#icon-chevron-down"></use>
            </svg>
        </div>
    </div>

    <a class="toolbar__compare button button--outline" href="#">
        <svg class="sprite_icon" aria-hidden="true">
            <use xlink:href="#icon-compare"></use>
        </svg>
        <span>Сравнение товаров (0)</span>
    </a>
</form>
