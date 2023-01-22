<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * To use Uuid in primery key
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'image',
        'value',
        'cost'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function productInformations()
    {
        return $this->hasMany(ProductInformation::class);
    }

    public function stock()
    {
        return $this->hasOne(ProductStock::class);
    }

    public function delete()
    {
        DB::beginTransaction();

        try {
            $this->productInformations()->delete();
            $this->stock()->delete();

            $delete = parent::delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return $delete;
    }
}
