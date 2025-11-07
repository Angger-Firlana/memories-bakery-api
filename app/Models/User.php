<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ penting ini!
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ✅ Sanctum token
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable // ✅ ubah ini dari Model ke Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // ✅ tambahkan trait ini

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role_id' => 'int'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'username',
        'email',
        'email_verified_at',
        'password',
        'role_id',
        'remember_token'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function couriers()
    {
        return $this->hasMany(Courier::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }
}
