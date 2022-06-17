<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Service\Generator;


use App\Models\Generator\Vaccine;
use App\Repository\Generator\VaccineRepository;
use Illuminate\Support\Facades\Validator;
use App\Service\CoreService;

class VaccineService extends CoreService
{
    protected $vaccineRepository;

    public function __construct(VaccineRepository $vaccineRepository)
    {
        $this->vaccineRepository = $vaccineRepository;
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
        return $this->vaccineRepository->all();
    }

    public function find($id, $relation = null)
    {
        return $this->vaccineRepository->find($id, $relation);
    }

    public function loadDataTable($access){
        $model = Vaccine::withoutTrashed()->get();
        return $this->privilageBtnDatatable($model, $access);
    }
}
