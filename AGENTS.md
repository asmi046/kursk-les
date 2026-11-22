# Kursk-Les — сайт компании «КурскЛес» (каталог пиломатериалов)

Laravel 13 (PHP 8.3+, Blade) + Vite 8 (Sass, keen-slider, vanilla ES-модули).
Tailwind CSS 4 установлен, но в вёрстке **не используется** — вся стилизация на SCSS.
SPA-фреймворков в рантайме нет: `@vitejs/plugin-vue` есть в `vite.config.js`, но
`.vue`-файлов в проекте нет, JS — обычные модули в `resources/js/modules/`.

Ключевые пакеты: `laravel/framework ^13.8`, `asmi046/site_skelet ^1.0` (вендорный
«скелет» сайта: SEO, меню, контакты, хелперы), dev — `laravel/boost ^2.2`,
`laravel/pint`, `laravel/pail`, `pestphp/pest ^4.7`, `laravel/pao` (JSON-вывод Pest).

## Команды

- `composer setup` — установка с нуля (install, .env, key, migrate, npm, build).
- `composer dev` — 4 процесса сразу: `artisan serve`, `queue:listen`, `pail`, `npm run dev`.
- `npm run dev` / `npm run build` — Vite dev-server / прод-сборка.
- `php artisan migrate`, `php artisan db:seed` — миграции и сидеры.
- `vendor/bin/pint --dirty --format agent` — после правок PHP (обязательно).
- `php artisan test --compact` — тесты (см. «Тесты»: вывод идёт в JSON из-за `laravel/pao`).

## Маршруты

`routes/web.php` пуст (welcome закомментирован). Все публичные маршруты — в
`routes/asmi_all.php`, который подключается в `bootstrap/app.php` внутри группы
middleware `web`. Имена: `home`, `contacts`, `restaurant-offer`, `catalog`,
`category.show` (`/category/{slug}`), `product.show` (`/product/{slug}`).
Новые маршруты добавлять в `routes/asmi_all.php`, с `->name(...)`, ссылки — `route()`.

`app/Http/Controllers/ProjectController.php` нигде не замаршрутизирован (мёртвый код);
проекты рендерит view-компонент `ProjectsSection`.

## Главная страница: тестовый режим

`IndexController::index()` по умолчанию отдаёт **заглушку** `index_z` (placeholder),
а не рабочую страницу. Рабочий `index` включается кукой `testmode=1`:

- `/?test=1` — поставить куку `testmode` на 30 дней и открыть рабочую главную;
- `/?test=0` — снять режим (снова заглушка).

При проверке изменений на `/` нельзя делать вывод «страница сломалась» — сначала
проверь, не открыта ли заглушка.

## Контент приходит из БД, а не из шаблонов

- **Текстовые блоки** — модель `ContentBlock` (`group`, `key`, `title`, `value`,
  `icon`, `order`, `data`); группы: `about`, `advantages`, `individual`, `reasons`,
  `restaurant_offer`. В Blade: `content_block('reasons')`
  (`app/helpers/allHelpers.php`), наполнение — сидеры `*BlockSeeder`.
- **Контакты** (телефон, e-mail, адрес, ссылки на мессенджеры) — модель `Contact`
  (`name`/`title`/`value`), в Blade: `contact('phone')`, `contact('tg_lnk')`.
  Сидер — `ContactSeeder`.
- **Меню** — модель `App\Models\Menu\Menu` (именно такой namespace; таблица `menus`,
  колонка `menu_name`, `parent` — id родителя). В Blade: `<x-menues.puncts name="...">`,
  где `name` = `menu_name` из сидера: `Главное меню`, `Каталог в подвале`,
  `Информация в подвале`.
- **SEO** — таблица `seo_data`, ключ — текущий `Request::path()`. В шапке леяута
  стоят директивы `@header_seo` / `@header_seo_with_img($og_img)` (регистрируются
  пакетом `asmi046/site_skelet`) → `app/Services/SeoServices.php`. Дефолты —
  в `config/asmiseo.php`. Title/description в шаблонах не хардкодить.

Исключение (осознанное): список опций фильтров каталога зашит в Blade —
`resources/views/components/catalog/filters.blade.php` (`$materialOptions`,
`$colorOptions`), а не в БД.

## Кэш не сбрасывается сам

`ContentBlock::group()`, `Contact::allFromCacheName()/allFromCacheTitle()` и
`SeoServices::get_data_by_url()` используют `Cache::rememberForever`
(`CACHE_STORE=database`). После `db:seed` / правки сидера контент в браузере
**не обновится**, пока не выполнен `php artisan cache:clear` (на сервере —
`npm run cache_clear`).

## Картинки и файлы

- Изображения товаров лежат в `storage/app/public` (имена файлов в `products.img`),
  в шаблонах выводятся как `Storage::url($product->img)`, работает симлинк
  `public/storage` (`php artisan storage:link`).
- `FILESYSTEM_DISK=local`, а его root — `storage/app/private`. Поэтому
  `Storage::put()` в диск по умолчанию положит файл **вне веба**; для публичных
  файлов кладите их в `storage/app/public` или пишите в диск `public` явно.
- Статика сайта — `public/img/...` (`hero`, `shop`, `logo`, `sprite`, `favicons` …).
- Иконки — единый SVG-спрайт `public/img/sprite/sprite.svg`, который инлайнится в
  `layouts/all.blade.php`. В разметке: `<svg class="sprite_icon"><use xlink:href="#icon-bag"></use></svg>`.
  Новую иконку — добавлять в спрайт, а не отдельным `<img>`.

## Вёрстка и стили (SCSS, не Tailwind)

- Стили — `public/scss/_*.scss` (partial-файлы с подчёркиванием), точка входа —
  `public/scss/main.scss`; новый partial подключается там же через `@use "имя";`.
- Каждый partial начинается с `@use "vars" as *;` и использует **только**
  переменные из `public/scss/_vars.scss` (цвета, отступы, шрифты, `$bp_tablet: 820px`,
  `$bp_mobile: 520px`). Свои переменные туда же.
- Нейминг — BEM: `block__element`, модификаторы `block--mod`.
- Секция = `<section id="..." class="...">` + внутри `<div class="container">`;
  стилизовать сам `section` и `.container` не нужно — они уже настроены.
- Кнопка по умолчанию — `<a class="button">` (+ модификаторы `button--light`,
  `button--outline`, `button--white`); не делать hover-эффекты без прямого указания.
- Общие повторяющиеся стили выносятся в `public/scss/_current.scss`, кнопки —
  в `public/scss/elements/_button.scss` (в т.ч. глобальный модификатор
  `.slider-nav--round` — не дублировать в скоупах секций; иконки стрелок рисуются
  stroke'ем, цвет задавать через `.sprite_icon { stroke: ... }`).
- Tailwind подключён (`resources/css/app.css`) и используется фактически только в
  `welcome.blade.php` и `components/pagination/pagination.blade.php`.
- ТЗ автора на вёрстку — `promts/verstka_main.md` и `promts/verstka.md`
  (примеры ТЗ и правила), промты на сидеры — `promts/seeder.md`. Сверяться при вёрстке.

## JS

`resources/js/app.js` — единственная точка входа, инициализирует модули из
`resources/js/modules/`: `side-menu`, `catalog-filters`, `sliders` (keen-slider,
брейкпоинты 820/520), `product-readmore`, `product-qty`. Модули работают по
`data-*` атрибутам (`data-qty-group`, `data-readmore`, `data-slider-prev="<id>"`),
инициализация идёт после `DOMContentLoaded`. Класс `CatalogFilters` — это раскрытие
фильтров, сами фильтры — обычная GET-форма (`material[]`, `color[]`, `rust_exist[]`,
`handle_exist[]`, `sort` = `default|price-asc|price-desc|name`, по 9 товаров на
страницу, `withQueryString()`).

## Компоненты

Классовые view-компоненты лежат в `app/View/Components/`, шаблоны — в
`resources/views/components/` (те же имена в snake-case): `ShopSection` → `<x-shop-section />`,
`App\View\Components\Menues\Puncts` → `<x-menues.puncts />`. Данные для компонентов
берутся из моделей (`Product::inRandomOrder()`, `Project::all()`, `ContentBlock::group()`).

## Страницы проектов

- Роуты проектов — в отдельном файле `routes/projects.php` (`projects.index` `/projects`,
  `projects.show` `/projects/{project}` — route model binding по **slug**:
  в модели `Project` переопределён `getRouteKeyName()`, колонка `slug`, уникальный
  индекс — миграция `add_slug_to_projects_table`). Подключён в `bootstrap/app.php`
  в `using:` группой `web`, рядом с `asmi_all.php`. Контроллер —
  `app/Http/Controllers/ProjectController.php` (index: `paginate(9)->withQueryString()`;
  show). Slug'и задаются в `ProjectSeeder`, SEO-url проекта — `projects/{slug}`.
- Вьюхи: `resources/views/projects/index.blade.php` (карточки `x-cards.project-card`,
  пагинация через `x-pagination.index` — компонент ждёт переменную `$tovars`, передавать
  `:tovars="$projects"`) и `resources/views/projects/show.blade.php` (слайдер слева /
  текст справа, сетка 1/2 через `#project .product__inner`, не трогать `.product__inner`
  глобально — страница товара использует 3 колонки).
- Сидер `ProjectSeeder`: `description` — html из файлов `public/tmp/projects/*.html`
  (читаются через `file_get_contents(public_path(...))`); `gallery` — JSON-массив
  `[{"img": "projects/{dir}/{file}.webp", "alt": "..."}]` под поле `Json` в MoonShine
  (ключи `img`, `alt`). Фото копируются из `public/tmp/projects/{dir}/` в диск `public`
  (`copyGallery()`). Главное фото проекта — в `img` (для новых проектов — первое фото
  галереи либо явно указанный файл). SEO-записи `SeoData` создаются тем же сидером
  через `firstOrCreate`.
- На слайдер проекта (`#product-slider`) повешен лайтбокс: `data-lightbox`
  (+ `data-lightbox-group`). Кнопки навигации слайдера — `data-slider-prev/next`,
  обработчики в `initProductSlider()` (`resources/js/modules/sliders.js`).

## Лайтбокс

- Модуль `resources/js/modules/lightbox.js` (vanilla, без зависимостей), стили —
  `public/scss/_lightbox.scss` (подключён в `main.scss`). Инициализация в `app.js`.
- Применение: повесить `data-lightbox` на любой контейнер с `<img>` — клик открывает
  оверлей со всеми картинками контейнера. Навигация: стрелки, ←/→, Esc, клик по
  подложке закрывает. `data-lightbox-group="имя"` объединяет несколько контейнеров
  в одну галерею.

## Хлебные крошки

- Компонент `x-breadcrumbs.main` (`resources/views/components/breadcrumbs/main.blade.php`)
  поддерживает опциональные пропсы `parent-title` / `parent-href` — промежуточный
  пункт цепочки (Schema.org BreadcrumbList, позиции 0/1/2). На странице проекта так
  выведен линк на `projects.index`.

## Тесты

- `phpunit.xml` переопределяет окружение тестов: `DB_CONNECTION=sqlite`,
  `DB_DATABASE=:memory:`, `CACHE_STORE=array`. То есть тесты идут на **SQLite в памяти**,
  а разработка/прод — на MySQL (`kursk_les`): SQL/MySQL-специфику в тестах писать нельзя.
- В `tests/Pest.php` трейт `RefreshDatabase` **закомментирован** — БД в тестах не
  мигрируется автоматически. Тест, ходящий в БД, обязан объявить
  `uses(RefreshDatabase::class)` сам, иначе будет `no such table: ...`.
- Штатный `tests/Feature/ExampleTest.php` (проверяет 200 на `/`) сейчас падает:
  без `RefreshDatabase` нет таблицы `seo_data` → 500. Это ожидаемо, не регрессия.
- Тесты — Pest 4; `php artisan make:test --pest ИмяТеста` (без префикса `Feature/`).
- `laravel/pao` перехватывает вывод Pest и печатает **JSON** (`{"tool":"pest",...}`)
  — не искать там привычный текстовый отчёт.
- Фабрик для моделей нет — в тестах создавайте записи через `Model::create()`/`forceFill`,
  с фабриками `database/factories/` (пока их почти нет).

## Деплой (Beget, shared-хостинг, SSH)

Скрипты в `package.json` ходят на прод-хост `progreg0_asmi@progreg0.beget.tech`
(`~/kursk-les.ru`, PHP 8.4 через `composer.phar`):

- `npm run deploy_m` — `vite build` → scp `public/build` → `git pull` → `optimize_all`.
- `npm run pull_rep` / `stash` / `reset_rep` / `clean_rep` — git-операции на сервере.
- `npm run migrate_rep` / `rollback_rep` / `seed_rep` / `db_update` /
  `db_update_total` (`migrate:refresh --seed`) — БД. `db_update_total` **сносит
  данные** — не запускать без явного запроса.
- `npm run cache_clear` / `optimize` / `optimize_all` — кэш Laravel
  (`config:cache`, `route:cache`, `view:cache`); после изменения маршрутов на
  сервере кэш маршрутов надо пересобрать.
- `npm run send_vite_build`, `storage_link`, `key_gen`, `composer_install/update`.

Эти скрипты бьют по продакшену — не запускать без согласования.

## Пакет `asmi046/site_skelet` (вендор)

Даёт неиспользуемые пока модули сайта. Публикуются из пакета по тегам:
`all-cart` (корзина/избранное), `autch-all` (авторизация), `asmi-pages` (страницы),
`consultation-form` (форма консультации), `site-options-component` (опции),
`asmi-menu`, `asmi-contacts`, `seo-all`, `site-helper-lib`, `breadcrumb-component`,
`pagination-component`, `map-component`, `asmi-side-menue`, `asmi-icon-sprite`,
`asmi-messenger-icon`, `asmi-watermark`, `scilet-all`.
Требуемые в проекте части (SEO, меню, контакты, хелперы) уже опубликованы
в `app/`, `config/`, `database/` — **не публиковать повторно**, это перезапишет
локальные правки.

## Правила работы

- Laravel Boost guidelines в конце этого файла вставлены автогенератором
  (`php artisan boost:update`, вызывается из `post-update-cmd` в `composer.json`) —
  блок `<laravel-boost-guidelines>…</laravel-boost-guidelines>` не редактировать
  руками, иначе правки пропадут. Скиллы Boost лежат в `.github/skills/` и `.ai/skills/`.
- Перед правками кода — `search-docs` через Boost MCP (сервер уже настроен в
  `.vscode/mcp.json`).
- Зависимости (`composer.json`, `package.json`) не менять без согласования.
- Новые файлы — через `php artisan make:*`; фабрики/сидеры — вместе с моделью.
- PHP 8: type hints и явные типы возврата, constructor property promotion,
  фигурные скобки всегда, PHPDoc вместо инлайн-комментариев.
- Eloquent: `$fillable` списком, касты в `$casts`, связи с типами возврата.
- Перед завершением: `vendor/bin/pint --dirty --format agent` и `php artisan test --compact`.

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>
