<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Repository\Generator;

use App\Models\Generator\MonitoringCovid;
use App\Service\Generator\MonitoringCovidService;
use App\Repository\CoreRepository;

class MonitoringCovidRepository extends CoreRepository
{
    protected $monitoringcovid;

    public function __construct(MonitoringCovid $monitoringcovid)
    {
        $this->setModel($monitoringcovid);
        $this->monitoringcovid = $monitoringcovid;
    }

    public function findWith($id, $relation)
    {
        return $this->monitoringcovid->with("$relation")->find($id);
    }

    public function get_all(){
        return $this->monitoringcovid->withTrashed()->get();
    }

    public function dataTable($access)
    {
        $data = new MonitoringCovidService($this);
        return $data->loadDataTable($access);
    }

}
