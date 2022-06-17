<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\EmployeeFamily;
use App\Service\Generator\EmployeeFamilyService;
use App\Repository\CoreRepository;

class EmployeeFamilyRepository extends CoreRepository
{
    protected $employeefamily;

    public function __construct(EmployeeFamily $employeefamily)
    {
        $this->setModel($employeefamily);
        $this->employeefamily = $employeefamily;
    }

    public function findWith($id, $relation)
    {
        return $this->employeefamily->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->employeefamily->withoutTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new EmployeeFamilyService($this);
        return $data->loadDataTable($access);
    }

}
