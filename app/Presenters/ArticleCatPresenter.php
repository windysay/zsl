<?php

namespace App\Presenters;

class ArticleCatPresenter extends CommonPresenter
{
    public function getHandle()
    {
        return [
            [
                'icon'  => 'plus',
                'class' => 'success',
                'title' => '新增',
                'route' => 'backend.articlecat.create',
            ],
        ];
    }
}