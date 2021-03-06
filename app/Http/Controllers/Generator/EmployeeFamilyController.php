<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Http\Controllers\Generator;

use App\Models\Generator\EmployeeFamily;
use App\Service\Generator\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\EmployeeFamilyRepository;
use App\Service\Generator\EmployeeFamilyService;
use App\Service\Generator\EmployeeFamilyVaccineService;


class EmployeeFamilyController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $employeefamilyRepository;
    protected $employeefamilyService;
    protected $employeeFamilyVaccineService;

    protected $employeeService;

    public function __construct(EmployeeFamilyRepository $employeefamilyRepository, EmployeeFamilyService $employeeFamilyService,
                                EmployeeService $employeeService, EmployeeFamilyVaccineService $employeeFamilyVaccineService
                                //,EmployeeFamilyVaccineService $employeeFamilyVaccineService
                                )
    {
        $this->menu = $this->get_menu();
        $this->employeefamilyRepository = $employeefamilyRepository;
        $this->employeefamilyService = $employeeFamilyService;
        $this->employeeService = $employeeService;
        $this->employeeFamilyVaccineService = $employeeFamilyVaccineService;
//        $this->employeeFamilyVaccineService = $employeeFamilyVaccineService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
//        dd( $this->employeeService->all());
        return view('admin.contents.employeefamily.index',[
            'employee' => $this->employeeService->getEmployeHasFamily(),
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
        $validate = $this->employeefamilyService->formValidate($request->all());
        if ($validate)
        {
            return response()->json(
                $validate
                ,200);
        }
        $input = $request->all();
        $employeefamily = $this->employeefamilyRepository->save($input);
        //if new employee family , not update data
        if (is_object($employeefamily))
        {
            //Store Data Employee Family to Employee Family Vaccine
            $this->employeeFamilyVaccineService->saveEmployeFamilyVaccine($employeefamily);
        }

        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($employeefamily) == true ? 'added' : 'updated')
        ],200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $employeefamily = $this->employeefamilyRepository->destroy($id);

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully deleted'
        ],200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->employeefamilyRepository->find($id, 'employee');

        return response()->json(['data'=> $data ],200);
    }

     public function __datatable()
     {
            return $this->load_data_table($this->employeefamilyRepository);
     }

}