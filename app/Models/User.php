<?php

namespace App\Models;

use GuzzleHttp\Client;
use App\Traits\Base\BaseTrait;
use Illuminate\Support\Carbon;
use App\Models\Ldap\LdapAccount;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $name
 * @property string $email
 * @property string $username
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $image
 * @property boolean $is_local
 * @property boolean $is_ldap
 * @property string|null $objectguid
 *
 * @property string $login_type
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasRoles, \OwenIt\Auditing\Auditable, BaseTrait, LaravelPermissionToVueJS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name',
        'email',
        'password',

        'username',
        'image',
        'is_local',
        'is_ldap',
        'objectguid',
        'ldap_account_id'
    ];*/
    protected $guarded = [];

    public function getRouteKeyName() { return 'uuid'; }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #region Validation Tools

    public static function defaultRules() {
        return [
            'name' => ['required','string',],
        ];
    }
    public static function createRules()  {
        return array_merge(self::defaultRules(), [
            'email' => ['required',
                'unique:users,email,NULL,id',
            ],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'email' => ['required',
                'unique:users,email,'.$model->id.',id',
            ]
        ]);
    }
    public static function validationMessages() {
        return [];
    }

    #region Eloquent Relationships

    public function status() {
        return $this->belongsTo(Status::class);
    }

    /**
     * Renvoie le Compte LDAP du User.
     */
    public function ldapaccount() {
        return $this->belongsTo(LdapAccount::class, 'ldap_account_id');
    }

    #endregion

    public function getAllPermissionsAttribute() {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }
        return $permissions;
    }

    public function jsPermissions()
    {
        return json_encode([
                'roles' => $this->getRoleNames(),
                'permissions' => $this->getAllPermissions()->pluck('name'),
            ]);
    }

    #region Custom Functions

    public function isActive() {
        //return $this->is_local || $this->is_ldap;
        return Status::active()->first() ? $this->status_id === Status::active()->first()->id : false;
    }

    public function sendMailAccountInfos() {
        $post_link = "http://192.168.5.174/users.sendmailaccountinfos";

        $client = new Client(['headers' => ['Authorization' => 'auth_trusted_header']]);
        $options = [
            'multipart' => [
                [
                    'Content-type' => 'multipart/form-data',
                    'name' => 'file',
                    'contents' => "",//base64_encode( file_get_contents($qrcode_img) ), // fopen('data:image/png;base64,' . $qrcode_img, 'r'), // data://text/plain;base64
                    'filename' => '',
                ],
                ['name' => 'name', 'contents' => $this->name],
                ['name' => 'email', 'contents' => $this->email,],
                ['name' => 'username', 'contents' => $this->username ,],
                ['name' => 'is_local', 'contents' => $this->is_local ,],
                ['name' => 'is_ldap', 'contents' => $this->is_ldap ,],
            ]
        ];

        return $client->post($post_link, $options);
    }

    #endregion
}
