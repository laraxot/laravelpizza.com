//---
continuo di type_hinting
--//

//-------------
https://github.com/LaravelCollective/annotations
Scanning your event handlers, controllers, and models can be done manually by
using php artisan event:scan, php artisan route:scan,
or php artisan model:scan respectively.
In the local environment, you can scan them automatically by
setting protected $scanWhenLocal = true.
//-----------------
https://github.com/qsun/ModelAnnotation
-- mi sembra una annotation diversa

squizlabs/php_codesniffer
phpmd/phpmd
phpstan/phpstan


//------------------
https://github.com/barryvdh/laravel-ide-helper
php artisan ide-helper:models
questo e' quello che usiamo

php artisan ide-helper:eloquent
This will write /** @mixin \Eloquent */
into the vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php file.


//-----------------------------------
https://laravel-news.com/6-eloquent-secrets

directly on the model.
/**
* @var int
*/
protected $perPage = 30;

function getFullNameAttribute() {
    return sprintf('%s %s', $this->first_name, $this->last_name);
}

 /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['full_name'];


class Video extends Model
{
    public function setDurationInMinutesAttribute($value)
    {
        $this->attributes['duration_in_seconds'] = $value * 60;
    }

    public function setDurationInHoursAttribute($value)
    {
        $this->attributes['duration_in_seconds'] = $value * 60 * 60;
    }
}


User::all()->pluck('id')->toArray();
User::all()->modelKeys();

//---------------------------------------------------
https://tomgrohl.medium.com/using-php-traits-for-laravel-eloquent-relationships-7357901a01a4
//-- usa set e get





