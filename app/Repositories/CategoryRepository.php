<?php
namespace App\Repositories;

use App\App;
use App\BaseTrait;
use Illuminate\Support\Facades\DB;

use App\Category as Category;

class  CategoryRepository
{
    use BaseTrait;

    private static $table = 'categories';

    public static function get(array $fields = ['*']): array
    {
        return DB::table(self::$table)->where(Category::STATUS_FIELD, Category::VALID_STATUS)->select($fields)->get()->toArray();
    }

    public static function getByApp(int $appId): array
    {
        $model = new App();
        return $model->with('category')->where($model->getPrimaryKey(), $appId)->get()->toArray();
    }
}