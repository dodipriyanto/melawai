<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\EmployeeCovid;
use App\Service\Generator\EmployeeCovidService;
use App\Repository\CoreRepository;

class EmployeeCovidRepository extends CoreRepository
{
    protected $employeecovid;

    public function __construct(EmployeeCovid $employeecovid)
    {
        $this->setModel($employeecovid);
        $this->employeecovid = $employeecovid;
    }

    public function findWith($id, $relation)
    {
        return $this->employeecovid->with("$relation")->find($id);
    }

    public function get_all($relation){
        return $this->employeecovid->withTrashed()->with($relation)->get();
    }

    public function dataTable($access)
    {
        $data = new EmployeeCovidService($this);
        return $data->loadDataTable($access);
    }

}
