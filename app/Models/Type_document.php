<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type_document extends Model
{
    public $table = 'type_documents';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'code',
        'name',
        'prefix',
        'cufe_algorithm',
    ];

    protected $guarded = [
        'id'
    ];

    public function resolutions()
    {
        return $this->hasMany(Resolution::class);
    }
}
