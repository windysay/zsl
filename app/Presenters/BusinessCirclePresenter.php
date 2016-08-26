<?php

namespace App\Presenters;

class BusinessCirclePresenter extends CommonPresenter
{
    public function getHandle()
    {
        return [
            [
                'icon'  => 'plus',
                'class' => 'success',
                'title' => '新增',
                'route' => 'backend.businesscircle.create',
            ],
        ];
    }
}