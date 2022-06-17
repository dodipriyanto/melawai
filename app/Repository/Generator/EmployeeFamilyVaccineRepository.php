<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\EmployeeFamilyVaccine;
use App\Service\Generator\EmployeeFamilyVaccineService;
use App\Repository\CoreRepository;

class EmployeeFamilyVaccineRepository extends CoreRepository
{
    protected $employeefamilyvaccine;

    public function __construct(EmployeeFamilyVaccine $employeefamilyvaccine)
    {
        $this->setModel($employeefamilyvaccine);
        $this->employeefamilyvaccine = $employeefamilyvaccine;
    }

    public function findWith($id, $relation)
    {
        return $this->employeefamilyvaccine->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->employeefamilyvaccine->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new EmployeeFamilyVaccineService($this);
        return $data->loadDataTable($access);
    }

}
