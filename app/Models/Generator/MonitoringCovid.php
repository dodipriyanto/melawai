<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Models\Generator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use DigitalCloud\Blameable\Traits\Blameable;


class MonitoringCovid extends Model
{
    use HasFactory, SoftDeletes, Uuid, Blameable;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'tbl_monitoringcovid';

    protected $fillable = [
        'id',
        'nama', 
        'deskripsi', 
        'satuan', 
        
    ];
}