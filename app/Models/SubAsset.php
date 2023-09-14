<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SubAsset extends Model implements Auditable
{

    use HasFactory, \OwenIt\Auditing\Auditable;
    
     protected $fillable = [
                    'member_id',
                    'survey_no',
                    'parcel_no',
                    'asset_id',
                    'acres',
                    'area_id',
                    'created_at',
                    'updated_at'
                ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    /**
     * Get the land for member
     */
    public function asset(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the land for member
     */
    public function area(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    /**
     * Get the land for member
     */
    public function member(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

}
