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


class EmployeeFamilyVaccine extends Model
{
    use HasFactory, SoftDeletes, Uuid, Blameable;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'tbl_employeefamilyvaccine';

    protected $fillable = [
        'id',
        'pegawai_id', 
        'keluarga_id',
        'vaksin_id', 
        'dosis', 
        'tanggal_vaksin', 
        
    ];


    function employee()
    {
        return $this->belongsTo(Employee::class,'pegawai_id','id');
    }

    function vaccine()
    {
        return $this->belongsTo(Vaccine::class,'vaksin_id','id');

    }

    function family()
    {
        return $this->hasOne(EmployeeFamily::class, 'id','keluarga_id');
    }
}