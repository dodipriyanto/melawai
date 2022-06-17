<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\Vaccine;
use App\Service\Generator\VaccineService;
use App\Repository\CoreRepository;

class VaccineRepository extends CoreRepository
{
    protected $vaccine;

    public function __construct(Vaccine $vaccine)
    {
        $this->setModel($vaccine);
        $this->vaccine = $vaccine;
    }

    public function findWith($id, $relation)
    {
        return $this->vaccine->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->vaccine->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new VaccineService($this);
        return $data->loadDataTable($access);
    }

}
