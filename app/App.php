<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use BaseTrait;

    const APP_ID_FIELD = 'app_id';

    const CATEGORY_ID_FIELD = 'category_id';

    const SUBJECT_ID_FIELD = 'subject_id';

    const TAG_ID_FIELD = 'tag_id';

    public function category()
    {
        return $this->belongsToMany(Category::class, (new AppCategory())->getTable(), self::APP_ID_FIELD, self::CATEGORY_ID_FIELD)->wherePivot(AppCategory::FIELD_STATUS, AppCategory::VALID_STATUS);
    }

    public function subject()
    {
        return $this->belongsToMany(Subject::class, (new AppSubject())->getTable(), self::APP_ID_FIELD, self::SUBJECT_ID_FIELD)->wherePivot(AppSubject::FIELD_STATUS, AppSubject::VALID_STATUS);
    }

    public function tag()
    {
        return $this->belongsToMany(Subject::class, (new AppTag())->getTable(), self::APP_ID_FIELD, self::TAG_ID_FIELD)->wherePivot(AppTag::FIELD_STATUS, AppTag::VALID_STATUS);
    }
}