<?php

namespace App\Models\Files;

use App\Models\BaseModel;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class File
 *
 * @package App\Models\Files
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property string $name
 * @property string $role
 * @property string|null $type
 * @property integer|null $size
 * @property string|null $extension
 * @property string|null $config_dir
 * @property boolean $rawfiledeleted
 * @property string|null $model_type
 * @property integer|null $model_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $status_id status reference
 * @property string|null $hasfile_type type of referenced model
 * @property int|null $hasfile_id model reference
 * @property int|null $created_by user creator reference
 * @property int|null $updated_by user updator reference
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read mixed $fullpath
 * @property-read mixed $relativepath
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel default($exclude = [])
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereConfigDir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereHasfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereHasfileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereRawfiledeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUuid($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Status|null $status
 */
class File extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['fullpath','relativepath'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [

        ];
    }

    #endregion

    #region Accessors

    public function getFullpathAttribute() {
        $separator = "/";
        return asset( config("app." . $this->config_dir) . $separator . $this->name);
    }

    public function getRelativepathAttribute() {
        $separator = "/";
        return config("app." . $this->config_dir) . $separator . $this->name;
    }

    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    public function deleteRawFile() {
        if (!$this->rawfiledeleted && !is_null($this->config_dir)) {
            $file_name = config('app.' . $this->config_dir) . $this->name;
            if (file_exists($this->relativepath)) {
                unlink($this->relativepath);
                $this->rawfiledeleted = true;
                $this->save();
            }
        }
    }

    #endregion

    public static function boot ()
    {
        parent::boot();

        // juste avant suppression
        self::deleting(function($model){
            //On supprime le fichier physique
            $model->deleteRawFile();
        });
    }
}
