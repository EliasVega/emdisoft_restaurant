<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resolution extends Model
{
    public $table = 'resolutions';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $dates = [
        'resolution_date',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'consecutive',
        'prefix',
        'resolution',
        'resolution_date',
        'technical_key',
        'start_number',
        'end_number',
        'start_date',
        'end_date',
        'status',
        'company_id',
        'type_document_id'
    ];

    protected $guarded = [
        'id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function type_document()
    {
        return $this->belongsTo(Type_document::class);
    }
}
