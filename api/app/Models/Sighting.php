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

    private $explodedLocation = null;

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
        return $this->getExplodeLocation()[3];
    }

    public function getLongitudeAttribute()
    {
        return $this->getExplodeLocation()[1];
    }
    
    public function getExplodeLocation()
    {
        if($this->explodedLocation === null) {
            preg_match($this->longitudeLatitudeRegex, $this->location, $this->explodedLocation);
        }

        return $this->explodedLocation;
    }
}