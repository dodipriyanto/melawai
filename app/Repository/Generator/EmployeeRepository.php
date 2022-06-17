<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Employee;
use App\Service\Generator\EmployeeService;
use App\Repository\CoreRepository;

class EmployeeRepository extends CoreRepository
{
    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->setModel($employee);
        $this->employee = $employee;
    }

    public function findWith($id, $relation)
    {
        return $this->employee->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->employee->withoutTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new EmployeeService($this);
        return $data->loadDataTable($access);
    }

    public function get_employe_family()
    {
        return $this->employee->withoutTrashed()->where('is_have_family',1)->get();
    }

}
