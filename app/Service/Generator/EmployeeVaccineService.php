<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\EmployeeVaccine;
use App\Repository\Generator\EmployeeVaccineRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class EmployeeVaccineService extends CoreService
{
    protected $employeevaccineRepository;

    public function __construct(EmployeeVaccineRepository $employeevaccineRepository)
    {
        $this->employeevaccineRepository = $employeevaccineRepository;
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
        return $this->employeevaccineRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->employeevaccineRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = EmployeeVaccine::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
