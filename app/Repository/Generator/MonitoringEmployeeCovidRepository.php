<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\MonitoringEmployeeCovid;
use App\Service\Generator\MonitoringEmployeeCovidService;
use App\Repository\CoreRepository;

class MonitoringEmployeeCovidRepository extends CoreRepository
{
    protected $monitoringemployeecovid;

    public function __construct(MonitoringEmployeeCovid $monitoringemployeecovid)
    {
        $this->setModel($monitoringemployeecovid);
        $this->monitoringemployeecovid = $monitoringemployeecovid;
    }

    public function findWith($id, $relation)
    {
        return $this->monitoringemployeecovid->with($relation)->find($id);
    }

    public function get_all(){
        return $this->monitoringemployeecovid->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new MonitoringEmployeeCovidService($this);
        return $data->loadDataTable($access);
    }

}
