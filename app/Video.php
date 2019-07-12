<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Video extends Model
{
    use BaseTrait;
    use Searchable;

    const STATUS_FIELD = 'status';
    const TAG_IDS_FIELD = 'tag_ids';
    const SEE_NUM_FIELD = 'see_num';
    const CATEGORY_ID_FIELD = 'category_id';
    const SUBJECT_ID_FIELD = 'subject_id';
    const PRIMARY_ID_FIELD = 'id';
    const NAME_FIELD = 'name';

    const VALID_STATUS = 1;

    /**
     * 索引的字段
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only($this->primaryKey, self::NAME_FIELD, self::TAG_IDS_FIELD);
    }
}