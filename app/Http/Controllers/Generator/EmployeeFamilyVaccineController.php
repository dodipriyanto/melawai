<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Http\Controllers\Generator;

use App\Models\Generator\EmployeeFamilyVaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\EmployeeFamilyVaccineRepository;
use App\Service\Generator\EmployeeFamilyVaccineService;
use App\Service\Generator\VaccineService;


class EmployeeFamilyVaccineController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $employeefamilyvaccineRepository;
    protected $employeefamilyvaccineService;
    protected $vaccineService;

    public function __construct(EmployeeFamilyVaccineRepository $employeefamilyvaccineRepository, EmployeeFamilyVaccineService $employeefamilyvaccineService,
    VaccineService $vaccineService)
    {
        $this->menu = $this->get_menu();
        $this->employeefamilyvaccineRepository = $employeefamilyvaccineRepository;
        $this->employeefamilyvaccineService = $employeefamilyvaccineService;
        $this->vaccineService = $vaccineService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
//        dd($this->vaccineService->all());
        return view('admin.contents.employeefamilyvaccine.index',[
            'vaccine' => $this->vaccineService->all(),
            'menu' => ($this->menu ? $this->menu : ''),
            'setting' => ( $this->settingVal ? $this->settingVal : '')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validate = $this->employeefamilyvaccineService->formValidate($request->all());
        if ($validate)
        {
            return response()->json(
                $validate
                ,200);
        }
        $input = $request->all();
        $employeefamilyvaccine = $this->employeefamilyvaccineRepository->save($input);

        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($employeefamilyvaccine) == true ? 'added' : 'updated')
        ],200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $employeefamilyvaccine = $this->employeefamilyvaccineRepository->destroy($id);

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully deleted'
        ],200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->employeefamilyvaccineRepository->find($id);

        return response()->json(['data'=> $data ],200);
    }

     public function __datatable()
     {
            return $this->load_data_table($this->employeefamilyvaccineRepository);
     }

}