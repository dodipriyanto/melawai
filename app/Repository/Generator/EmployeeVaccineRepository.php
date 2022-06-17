<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\EmployeeVaccine;
use App\Service\Generator\EmployeeVaccineService;
use App\Repository\CoreRepository;

class EmployeeVaccineRepository extends CoreRepository
{
    protected $employeevaccine;

    public function __construct(EmployeeVaccine $employeevaccine)
    {
        $this->setModel($employeevaccine);
        $this->employeevaccine = $employeevaccine;
    }

    public function findWith($id, $relation)
    {
        return $this->employeevaccine->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->employeevaccine->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new EmployeeVaccineService($this);
        return $data->loadDataTable($access);
    }

}
