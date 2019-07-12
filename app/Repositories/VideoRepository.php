<?php
namespace App\Repositories;

use App\Category;
use App\Subject;
use App\Tag;
use App\Video;
use App\Services\ServiceCaller;
use App\Services\Search\Tasks\SearchVideos;

class VideoRepository
{
    public static function get(array $ids = [], array $page = [], $order = null): array
    {
        $model = new Video();
        $primaryKey = $model->getPrimaryKey();

        $queryBuilder = $model->where(Video::STATUS_FIELD, Video::VALID_STATUS);

        if ($ids) {
            $queryBuilder->whereIn($primaryKey, $ids);
        }

        if ($page) {
            if (isset($page[0]) && (int)$page[0]) {
                $queryBuilder->offset($page[0]);
            }

            if (isset($page[1]) && (int)$page[1]) {
                $queryBuilder->limit($page[1]);
            }
        }

        if($order) {
            $queryBuilder->orderBy($order);
        }

        return $queryBuilder->get()->toArray();
    }

    public static function find(int $id): array
    {
        return Video::where(Video::STATUS_FIELD, Video::VALID_STATUS)->find($id)->toArray()?: [];
    }

    public static function getByCategory(array $categoryIds = null, array $page = null, $order = null): array
    {
        $model = new Category();
        $primaryKey = $model->getPrimaryKey();

        if (isset($page[0]) && (int)$page[0]) {
            $model->setCurrentOffset((int)$page[0]);
        }

        if (isset($page[1]) && (int) $page[1]) {
            $model->setPerPageLimit((int)$page[1]);
        }

        if($order) {
            $model->setOrder($order);
        }

        $queryBuilder = $model->with('video');

        if ($categoryIds) {
            $queryBuilder->whereIn($primaryKey, $categoryIds);
        }

        return $queryBuilder->where(Category::STATUS_FIELD, Category::VALID_STATUS)->get()->toArray();
    }

    public static function getBySubject(array $subjectIds = null, array $page = null, $order = null): array
    {
        $model = new Subject();
        $primaryKey = $model->getPrimaryKey();

        if (isset($page[0]) && (int)$page[0]) {
            $model->setCurrentOffset((int)$page[0]);
        }

        if (isset($page[1]) && (int) $page[1]) {
            $model->setPerPageLimit((int)$page[1]);
        }

        if($order) {
            $model->setOrder($order);
        }

        $queryBuilder = $model->with('video');

        if ($subjectIds) {
            $queryBuilder->whereIn($primaryKey, $subjectIds);
        }

        return $queryBuilder->where(Subject::STATUS_FIELD, Subject::VALID_STATUS)->get()->toArray();
    }

    public static function getByTag(array $tagIds, array $page = null, $order = null): array
    {
        $videoModel = new Video();

        if (empty($tagIds)) {
            if (isset($page[0]) && $page[0]) {
                $videoModel->offset($page[0]);
            }

            if (isset($page[1]) && $page[1]) {
                $videoModel->limit($page[1]);
            }

            return $videoModel->get()->toArray();
        }

        $tagModel = new Tag;
        $tags = $tagModel->whereIn($tagModel->getPrimaryKey(), $tagIds)->select($tagModel->getPrimaryKey())->get()->toArray();

        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = $tag['id'];
        }

        return ServiceCaller::call(ServiceCaller::TASK_SERVICE,
                    new SearchVideos(0, implode(',', $tagIds), isset($page[0])? (int)$page[0]:0, isset($page[1]) ? (int)$page[1]: 0)
                );
    }
}