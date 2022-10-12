<?php

namespace App\Models\Employes;

use App\Models\User;
use App\Models\BaseModel;
use App\Traits\Esim\HasEsim;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Contracts\Esims\IHasEsim;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PhoneNum
 *
 * @package App\Models\Employes
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 * @property string $numero
 * @property string $hasphonenum_type
 * @property integer $hasphonenum_id
 * @property integer $posi
 * @property integer|null $esim_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $created_by user creator reference
 * @property int|null $updated_by user updator reference
 */
class PhoneNum extends BaseModel implements IHasEsim
{
    use HasEsim, SoftDeletes, HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    //protected $with = [];

    #region Validation Rules

    public static function defaultRules($numero,$hasphonenum_type) {
        return [
            'numero' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'min:8',
                Rule::unique('phone_nums', 'numero')
                    ->where(function ($query) use($numero,$hasphonenum_type) {
                        $query->where('numero', $numero) ->where('hasphonenum_type', $hasphonenum_type);
                    })->ignore($numero),
            ],
        ];
    }
    public static function createRules($numero,$hasphonenum_type) {
        return array_merge(self::defaultRules($numero,$hasphonenum_type), [

        ]);
    }
    public static function updateRules($model,$numero,$hasphonenum_type) {
        return array_merge(self::defaultRules($numero,$hasphonenum_type), [

        ]);
    }

    public static function messagesRules() {
        return [
            'numero.required' => 'Numéro de téléphone requis',
            'numero.regex' => 'Numéro de téléphone non valide',
            'numero.min' => 'Numéro de téléphone doit avoir 8 digits minimum',
            'numero.unique' => 'Numéro déjà attribué',
        ];
    }

    #endregion

    #region Eloquent Relationships

    /**
     * The Model which has this Attribute
     *
     * @return MorphTo
     */
    public function hasphonenum()
    {
        return $this->morphTo();
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    #endregion

    public function setCreator(User $creator) {
        $this->creator()->associate($creator);
        $this->save();

        return $creator;
    }

    public static function boot ()
    {
        parent::boot();

        // juste avant suppression
        self::deleting(function($model){
            $model->dettachEsim();
        });
    }
}
