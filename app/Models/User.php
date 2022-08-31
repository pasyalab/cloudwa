<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// class User extends Authenticatable
class User extends MongoModel
{
    // use HasApiTokens, HasFactory, Notifiable;
    use Notifiable;
    
    protected $connection = 'mongodb';

    protected $table = 'os_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'api_key',
        'roles', // array
        'profile_photo', 
        'is_on_whatsapp', 
        'is_paid_user', 
        'is_google_oauth', 
        'user_status', 
        'affiliate_status', 
        'affiliate_codes', // array
        'meta', // array 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_google_oauth',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_id() {
        return $this->_id;
    }

    public static function getProps() {
        return (new static())->fillable;
    }
    

    public static function getDataRoles() {
        return ['customer', 'affiliate', 'administrator'];
    }

    public static function getDefaultMeta() {
        return [];
    }

    public static function getDefault() {
        $output = array_fill_keys(self::getProps(), null);

        $output['roles'] = ['customer']; // array
        $output['profile_photo'] = url('/assets/img/user.svg'); 
        $output['is_paid_user'] = false; 
        $output['is_google_oauth'] = false; 
        $output['user_status'] = 'pending'; 
        $output['affiliate_status'] = 'unregistered'; 
        $output['affiliate_codes'] = []; // array
        $output['meta'] = self::getDefaultMeta(); // array 

        return $output;
    }




}
