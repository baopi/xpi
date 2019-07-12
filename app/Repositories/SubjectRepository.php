<?php
namespace App\Repositories;

use App\Category;
use App\Subject as SubjectModel;
use Illuminate\Support\Facades\DB;
use App\App;

class SubjectRepository
{
    private static $table = 'subjects';

    public static function get(array $fields = ['*']): array
    {
        return DB::table(self::$table)->where(SubjectModel::STATUS_FIELD, SubjectModel::VALID_STATUS)->select($fields)->get()->toArray();
    }

    public static function getByApp(int $appId): array
    {
        $model = new App();
        return $model->with('subject')->where($model->getPrimaryKey(), $appId)->get()->toArray();
    }

    public static function getByCategory(array $categoryIds): array
    {
        $model = new Category();
        if (!empty($categoryIds)) {
            $model->whereIn($model->getPrimaryKey(), $categoryIds);
        }
        return $model->with('subject')->get()->toArray();
    }
}