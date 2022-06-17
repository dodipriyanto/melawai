<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\MonitoringEmployeeCovid;
use App\Repository\Generator\MonitoringEmployeeCovidRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class MonitoringEmployeeCovidService extends CoreService
{
    protected $monitoringemployeecovidRepository;

    public function __construct(MonitoringEmployeeCovidRepository $monitoringemployeecovidRepository)
    {
        $this->monitoringemployeecovidRepository = $monitoringemployeecovidRepository;
    }

    public function formValidate($request)
    {
        $rules = [
//            'email' => 'required|min:1|unique:conf_users,email,NULL,id,deleted_at,NULL'
        ];
        $messages = [
            'email.unique' => 'Email sudah terdaftar.',
        ];
        $validator = Validator::make($request, $rules, $messages);

        if($validator->fails()){
            return [
                'status'=> 'error',
                'message' => $messages
            ];
        }
        return 0;
    }

    public function all()
    {
        return $this->monitoringemployeecovidRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->monitoringemployeecovidRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = MonitoringEmployeeCovid::withoutTrashed()->with(['employee_covid.employee','monitoring'])->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
