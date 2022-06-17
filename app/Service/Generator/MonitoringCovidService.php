<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\MonitoringCovid;
use App\Repository\Generator\MonitoringCovidRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class MonitoringCovidService extends CoreService
{
    protected $monitoringcovidRepository;

    public function __construct(MonitoringCovidRepository $monitoringcovidRepository)
    {
        $this->monitoringcovidRepository = $monitoringcovidRepository;
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
        return $this->monitoringcovidRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->monitoringcovidRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = MonitoringCovid::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
