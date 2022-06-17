<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\EmployeeCovid;
use App\Repository\Generator\EmployeeCovidRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class EmployeeCovidService extends CoreService
{
    protected $employeecovidRepository;

    public function __construct(EmployeeCovidRepository $employeecovidRepository)
    {
        $this->employeecovidRepository = $employeecovidRepository;
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
        return $this->employeecovidRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->employeecovidRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = EmployeeCovid::withoutTrashed()->with('employee')->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
