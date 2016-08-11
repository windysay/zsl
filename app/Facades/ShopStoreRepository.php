<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the menu repository facade class
 */
class ShopStoreRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shopstorerepository';
    }
}
