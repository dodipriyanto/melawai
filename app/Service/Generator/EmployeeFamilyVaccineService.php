<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\EmployeeFamilyVaccine;
use App\Repository\Generator\EmployeeFamilyVaccineRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class EmployeeFamilyVaccineService extends CoreService
{
    protected $employeeFamilyvaccineRepository;

    public function __construct(EmployeeFamilyVaccineRepository $employeeFamilyvaccineRepository)
    {
        $this->employeeFamilyvaccineRepository = $employeeFamilyvaccineRepository;
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

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => $messages
            ];
        }
        return 0;
    }

    public function all()
    {
        return $this->employeefamilyvaccineRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->employeefamilyvaccineRepository->find($id, $relation);
    }

    public function loadDataTable($access)
    {
        $model = EmployeeFamilyVaccine::withoutTrashed()->with(['employee','family'])->get();
        return $this->privilageBtnDatatable($model, $access);
    }

    public function saveEmployeFamilyVaccine($employeeFamily)
    {
        $arrData = [
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'pegawai_id' => $employeeFamily->pegawai_id,
            'keluarga_id' => $employeeFamily->id,
            'dosis' => null,
            'tanggal_vaksin' => null
        ];
//        dd($arrData);


        $employeeVaccine = $this->employeeFamilyvaccineRepository->save($arrData, false, true);

    }
}
