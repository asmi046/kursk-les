<?php

namespace App\Services\ProductList;

class FavoriteService extends AbstractProductListService
{
    protected function sessionKey(): string
    {
        return 'favorites.items';
    }
}
