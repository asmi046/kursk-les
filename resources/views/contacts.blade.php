@extends('layouts.all')

@section('main')
    <section class="contacts-page section__first">
        <div class="container">
            <x-breadcrumbs.main :title="$title"></x-breadcrumbs.main>
            <h1 class="section-head section-head--line section-head--top_space">{{ $title }}</h1>

            <div class="contacts-page__grid">
                <div class="contacts-page__info">
                    @if ($contacts['adress'])
                        <div class="contacts-page__item">
                            <h3 class="contacts-page__item-title">Адрес:</h3>
                            <p class="contacts-page__item-text">{{ $contacts['adress'] }}</p>
                        </div>
                    @endif

                    @if ($contacts['phone'])
                        <div class="contacts-page__item">
                            <h3 class="contacts-page__item-title">Телефон</h3>
                            <a href="tel:{{ phone_format($contacts['phone']) }}"
                                class="contacts-page__link">{{ $contacts['phone'] }}</a>
                        </div>
                    @endif

                    @if ($contacts['phone_2'])
                        <div class="contacts-page__item">
                            <a href="tel:{{ phone_format($contacts['phone_2']) }}"
                                class="contacts-page__link">{{ $contacts['phone_2'] }}</a>
                        </div>
                    @endif

                    @if ($contacts['email'])
                        <div class="contacts-page__item">
                            <h3 class="contacts-page__item-title">Электронная почта:</h3>
                            <a href="mailto:{{ $contacts['email'] }}"
                                class="contacts-page__link">{{ $contacts['email'] }}</a>
                        </div>
                    @endif

                    @if ($contacts['work_time'])
                        <div class="contacts-page__item">
                            <h3 class="contacts-page__item-title">Время работы:</h3>
                            <p class="contacts-page__item-text">{{ $contacts['work_time'] }}</p>
                        </div>
                    @endif
                </div>

                <div class="contacts-page__map">
                    @if ($contacts['geo'] && $contacts['adress'])
                        <x-map.map-in-page name="{{ contact('company_name') ?? 'Компания' }}" :geo="$contacts['geo']"
                            :adres="$contacts['adress']" :phone="$contacts['phone']"></x-map.map-in-page>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <x-individual-section />
    <x-projects-section />
@endsection
