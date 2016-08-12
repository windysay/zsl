<?php

namespace App\Presenters;

class ArticlePresenter extends CommonPresenter
{
    public function getHandle()
    {
        return [
            [
                'icon'  => 'plus',
                'class' => 'success',
                'title' => '新增',
                'route' => 'backend.article.create',
            ],
        ];
    }
}