<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Base\BaseTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package App\Models
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read \App\Models\Status|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel default($exclude = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    use BaseTrait;

    public function getRouteKeyName() { return 'uuid'; }

    #region Eloquent Relationships

    public function status() {
        return $this->belongsTo(Status::class);
    }

    #endregion

    #region Scopes

    public function scopeDefault($query, $exclude = []) {
        return $query
            ->where('is_default', true)->whereNotIn('id', $exclude);
    }

    #endregion
}
