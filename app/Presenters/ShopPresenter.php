<?php

namespace App\Presenters;

class ShopPresenter extends CommonPresenter
{
    public function getHandle()
    {
        return [
            [
                'icon'  => 'plus',
                'class' => 'success',
                'title' => '新增',
                'route' => 'backend.shop.create',
            ],
        ];
    }
}