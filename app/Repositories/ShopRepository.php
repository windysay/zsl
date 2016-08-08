<?php

namespace App\Repositories;

use App\Traits\Repository\BaseRepositoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Factory;
/**
 * Shop Model Repository
 */
class ShopRepository extends CommonRepository
{
    /**
     * 根据角色模型获取分组权限
     *
     * @param $shop
     *
     * @return array
     */
    use BaseRepositoryTrait;

    protected $model;

    protected $validator;

    public function __construct(Model $model, Factory $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function clearCache()
    {

    }
}
