@props([
    'title',
    'parentTitle' => null,
    'parentHref' => null,
])

<div class="uni_breadcrumbs">
    <div class="_container">

        <div itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumbs">
            <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="{{route('home')}}" >
                    <span itemprop="name">Главная</span>
                    <meta itemprop="position" content="0">
                </a>
            </span>

            @if ($parentTitle && $parentHref)
                <span class="sep"> / </span>
                <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a title="{{ $parentTitle }}" itemprop="item" href="{{ $parentHref }}">
                        <span itemprop="name">{{ $parentTitle }}</span>
                        <meta itemprop="position" content="1">
                    </a>
                </span>
            @endif

            @if (isset($title))
                <span class="sep"> / </span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="finish">
                        <span title="{{ $title }}" itemprop="item">
                            <span itemprop="name">{{ $title }}</span>
                            <meta itemprop="position" content="{{ $parentTitle ? 2 : 1 }}">
                        </span>
                    </span>
            @endif

         </div>
    </div>
</div>
