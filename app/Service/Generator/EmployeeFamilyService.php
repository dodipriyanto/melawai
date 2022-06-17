<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\EmployeeFamily;
use App\Repository\Generator\EmployeeFamilyRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class EmployeeFamilyService extends CoreService
{
    protected $employeefamilyRepository;

    public function __construct(EmployeeFamilyRepository $employeefamilyRepository)
    {
        $this->employeefamilyRepository = $employeefamilyRepository;
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
        return $this->employeefamilyRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->employeefamilyRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = EmployeeFamily::withoutTrashed()->with('employee')->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
