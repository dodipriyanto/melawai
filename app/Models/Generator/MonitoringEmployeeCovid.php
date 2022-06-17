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


class MonitoringEmployeeCovid extends Model
{
    use HasFactory, SoftDeletes, Uuid, Blameable;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'tbl_monitoringemployeecovid';

    protected $fillable = [
        'id',
        'employe_covid_id', 
        'tanggal_pengecekan', 
        'metode_pengecekan_id', 
        'nilai', 
        
    ];


    function employee_covid()
    {
        return $this->belongsTo(EmployeeCovid::class,'employe_covid_id','id');
    }

    function monitoring()
    {
        return $this->belongsTo(MonitoringCovid::class,'metode_pengecekan_id','id');
    }


}