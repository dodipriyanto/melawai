<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Front\News;
use App\Models\Generator\Employee;
use App\Models\Ticket;
use App\Repository\Generator\EmployeeRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;
use Symfony\Component\HttpFoundation\Request;

class EmployeeService extends CoreService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
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
        return $this->employeeRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->employeeRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = Employee::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }


    public function insertFiles(
        $uploadHandler,
        Employee $employee,
        Request $request,
        $directory = null,
        $employeeId = null
    )
    {
        if ($employeeId){

        }else{

        }

        if ($request->hasFile('file_upload')) {
            $file = $request['file_upload'];
            $filename = $directory.'/'.$this->random_string(20).'.'.$file->extension();
            $file->storeAs("public/images/",$filename);
            return $filename;
        };
        return $employee;

    }

    public function deleteFile($path)
    {
        if (\File::exists("storage/images/$path")) {
            \File::delete("storage/images/$path");
        } else {
            dd('File does not exists.');
        }
    }
}
