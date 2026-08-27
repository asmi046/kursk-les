@php
    $selectedMaterial = (array) request('material', []);
    $selectedColor = (array) request('color', []);
    $selectedHandle = (array) request('handle_exist', []);
    $selectedRust = (array) request('rust_exist', []);

    $materialOptions = ['Дуб', 'Ясень', 'Бук'];
    $colorOptions = ['Классический', 'Коричневый', 'Шоколадный', 'Графит', 'Натуральный'];
@endphp

<form class="filters" action="{{ route('catalog') }}" method="get" id="catalog-filters">
    <h2 class="filters__title">Фильтры</h2>

    <details class="filters__group" open>
        <summary class="filters__group-title">
            <span>Материал</span>
            <svg class="sprite_icon details__chevron" aria-hidden="true">
                <use xlink:href="#icon-chevron-down"></use>
            </svg>
        </summary>
        <div class="filters__group-body">
            @foreach ($materialOptions as $option)
                <label class="filters__option">
                    <input type="checkbox" class="filters__checkbox" name="material[]" value="{{ $option }}" @checked(in_array($option, $selectedMaterial))>
                    <span class="filters__checkbox-mark"></span>
                    <span class="filters__option-label">{{ $option }}</span>
                </label>
            @endforeach
        </div>
    </details>

    <details class="filters__group" open>
        <summary class="filters__group-title">
            <span>Цвет</span>
            <svg class="sprite_icon details__chevron" aria-hidden="true">
                <use xlink:href="#icon-chevron-down"></use>
            </svg>
        </summary>
        <div class="filters__group-body">
            @foreach ($colorOptions as $option)
                <label class="filters__option">
                    <input type="checkbox" class="filters__checkbox" name="color[]" value="{{ $option }}" @checked(in_array($option, $selectedColor))>
                    <span class="filters__checkbox-mark"></span>
                    <span class="filters__option-label">{{ $option }}</span>
                </label>
            @endforeach
        </div>
    </details>

    <details class="filters__group" open>
        <summary class="filters__group-title">
            <span>Руст</span>
            <svg class="sprite_icon details__chevron" aria-hidden="true">
                <use xlink:href="#icon-chevron-down"></use>
            </svg>
        </summary>
        <div class="filters__group-body">
            <label class="filters__option">
                <input type="checkbox" class="filters__checkbox" name="rust_exist[]" value="yes" @checked(in_array('yes', $selectedRust))>
                <span class="filters__checkbox-mark"></span>
                <span class="filters__option-label">Да</span>
            </label>
            <label class="filters__option">
                <input type="checkbox" class="filters__checkbox" name="rust_exist[]" value="no" @checked(in_array('no', $selectedRust))>
                <span class="filters__checkbox-mark"></span>
                <span class="filters__option-label">Нет</span>
            </label>
        </div>
    </details>

    <details class="filters__group" open>
        <summary class="filters__group-title">
            <span>Наличие ручки</span>
            <svg class="sprite_icon details__chevron" aria-hidden="true">
                <use xlink:href="#icon-chevron-down"></use>
            </svg>
        </summary>
        <div class="filters__group-body">
            <label class="filters__option">
                <input type="checkbox" class="filters__checkbox" name="handle_exist[]" value="yes" @checked(in_array('yes', $selectedHandle))>
                <span class="filters__checkbox-mark"></span>
                <span class="filters__option-label">Да</span>
            </label>
            <label class="filters__option">
                <input type="checkbox" class="filters__checkbox" name="handle_exist[]" value="no" @checked(in_array('no', $selectedHandle))>
                <span class="filters__checkbox-mark"></span>
                <span class="filters__option-label">Нет</span>
            </label>
        </div>
    </details>

    <div class="filters__actions">
        <button class="button" type="submit">Применить</button>
        <a class="button button--white" href="{{ route('catalog') }}">Сбросить</a>
    </div>
</form>
