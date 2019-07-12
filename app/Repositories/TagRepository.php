<?php
namespace App\Repositories;

use App\Tag;
use Illuminate\Support\Facades\DB;
use App\App;

class TagRepository
{
    private static $table = 'tags';

    public static function get(array $fields = ['*']): array
    {
        return DB::table(self::$table)->where(Tag::STATUS_FIELD, Tag::VALID_STATUS)->select($fields)->get()->toArray();
    }

    public static function getByApp(int $appId): array
    {
        $model = new App();
        return $model->with('tag')->where($model->getPrimaryKey(), $appId)->get()->toArray();
    }
}