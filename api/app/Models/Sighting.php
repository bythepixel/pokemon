<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sighting extends Model
{
    protected $fillable = [
        'user_id',
        'location'
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }

    public function setLocationAttribute($value) {
        $this->attributes['location'] = DB::raw("POINT($value)");
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw = ' astext(location) as location ';

        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }
}