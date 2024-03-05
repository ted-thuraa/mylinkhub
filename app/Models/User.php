<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LemonSqueezy\Laravel\Billable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
<<<<<<< HEAD
    use HasApiTokens, HasFactory, Notifiable,  Billable;
=======
    use HasUuids, HasApiTokens, HasFactory, Notifiable,  Billable;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id'; // Name of the primary key column
    public $incrementing = false; // Set to false for non-incrementing primary key
    protected $fillable = [
        'username',
<<<<<<< HEAD
=======
        'fullname',
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        'image',
        'bio',
        'email',
        'emailverification_code',
        'is_email_verified',
        'email',
        'authprovider',
        'authprovider_id',
        'authprovider_emailverified',
        'location',
        'password',
        'currentplan',
<<<<<<< HEAD
=======
        'mailchimpaccess_token',
        'mailchimp_dc',
        'googleaccess_token',
        'googlerefresh_token',
        'tokenexpires_in',
        'isgooglesheetsauthorized',
        'isMailchimpAuthorized',
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        'creator_category',
        'isAdmin',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

<<<<<<< HEAD
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->uuid = Str::uuid()->toString();
        });
    }
=======
    //protected static function boot()
    //{
    //    parent::boot();
//
    //    static::creating(function ($user) {
    //        $user->uuid = Str::uuid()->toString();
    //    });
    //}
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
}
