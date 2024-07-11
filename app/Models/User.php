<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use App\Notifications\MailResetPasswordNotification;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $table = "segurity.users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'cedula', 'last_login', 'last_ip_login', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url'
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token, $this->email));
    }

    public function scopeSearch($query, $search){

            // Comprobamos si es un correo electronico
            if(preg_match('/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/', $search) !== 0)
            {
                return $query->where('descripcion', 'ilike', '%' . $search . '%');

            // Comprobamos si es un numero telefonico
            }else if(preg_match('/^(V|v|E|e|P|p)\d{8}$/', $search) !== 0)
            {
                return $query->where('codigo', ucfirst($search));

            }else
            {
                return $query->where('codigo', 'ilike', '%'.$search.'%')
                ->orWhere('descripcion', 'ilike', '%'.$search.'%');

            }
    }

    // Funcion que devuelve los permisos que tiene un usuario por roles
    public function user_permisos_roles(){
        return $this->hasManyDeep(Permission::class, ['segurity.role_user', Role::class, 'segurity.permission_role']);
    }

    public function adjuntarRol(Role $role) {

        $permisos_roles = $role->permissions()->pluck('id');

        $this->permissions()->detach($permisos_roles);

        $this->syncRolesWithoutDetaching($role->id);
    }

    /* Funcion para adjuntar varios roles tomando en cuenta que no se dupliquen
    permisos
        El primer parametro es un array con el id de los roles.
        El segundo parametro es la columna en la que va a buscar, por defecto busca
        en el id.
    */
    public function adjuntarRoles(array $roles, $columna = 'id'){

        if($columna == 'id') {

            $permisos_roles = Role::whereIn('id', $roles)->with('permissions')->get()->map( function ($item, $key) {
                return $item['permissions']->map( fn ($item, $key) => $item['id'] );
            } )->flatten()->unique();

            $this->permissions()->detach($permisos_roles);
            $this->roles()->sync($roles);

        }else {

            $datos_roles_permisos = Role::whereIn($columna, $roles)->with('permissions')->get()->map( function ($item, $key) {
                return ['id_rol' => $item['id'],
                    'id_permisos' => $item['permissions']->map( fn ($item, $key) => $item['id'] )];
            } );

            $lista_id_roles = [];
            $lista_id_permisos = [];

            foreach($datos_roles_permisos as $dato){
                $lista_id_roles[] = $dato['id_rol'];
                $lista_id_permisos[] = $dato['id_permisos'];
            }

            $this->permissions()->detach(collect($lista_id_permisos)->flatten()->unique());
            $this->roles()->sync($lista_id_roles);
        }
    }

}
