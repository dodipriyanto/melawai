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
        $model = EmployeeVaccine::withoutTrashed()->with(['employee','vaccine'])->get();
        return $this->privilageBtnDatatable($model, $access);
    }

    public function saveEmployeVaccine($employee)
    {
        $arrData = [
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'pegawai_id' => $employee->id,
            'vaksin_id' => null,
            'dosis' => null,
            'tanggal_vaksin' => null
        ];
        //2 dosis vaccine for every employee data
        for ($i=0; $i <= 1; $i ++)
        {
            $ep = $this->employeevaccineRepository->save(
               [
                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'pegawai_id' => $employee->id,
                    'vaksin_id' => null,
                    'dosis' => null,
                    'tanggal_vaksin' => null
               ], false, true);
//            dump($ep);
        }
    }
}
