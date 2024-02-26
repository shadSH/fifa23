<?php

namespace App\Models;

use App\Http\Requests\City\StoreCityRequest;
use App\Http\Requests\City\UpdateCityRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;

    public $guarded = ['id'];

    public string $storeFormRequest = StoreCityRequest::class;

    public string $updateFormRequest = UpdateCityRequest::class;

    public function User()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
