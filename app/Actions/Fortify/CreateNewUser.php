<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:segurity.users'],
            'cedula' => ['required', 'string', 'max:9', 'starts_with:V,E,P'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:segurity.users'],
            'password' =>  ['required', 'string', 'max:8'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {

            $user = User::create([
                'name' => $input['name'],
                'username'  => $input['username'],
                'cedula'  => $input['cedula'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            $user->permissions()->attach($input['permisos_seleccionados']);

            $user->roles()->attach($input['roles_seleccionados']);

            return $user;

        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true,
        ]));
    }
}
