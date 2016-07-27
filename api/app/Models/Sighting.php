<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sighting extends Model
{
    protected $fillable = [
        'user_id',
        'location'
    ];

    protected $appends = ['latitude', 'longitude'];

    private $longitudeLatitudeRegex = '/^POINT\((\-?\d+(\.\d+)?) \s*(\-?\d+(\.\d+)?)\)$/';

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

    public function getLatitudeAttribute()
    {
        preg_match($this->longitudeLatitudeRegex, $this->location, $matches);

        return $matches[3];
    }

    public function getLongitudeAttribute()
    {
        preg_match($this->longitudeLatitudeRegex, $this->location, $matches);

        return $matches[1];
    }
}