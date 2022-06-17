<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Http\Controllers\Generator;

use App\Models\Generator\EmployeeCovid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\EmployeeCovidRepository;
use App\Service\Generator\EmployeeCovidService;
use App\Service\Generator\EmployeeService;



class EmployeeCovidController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $employeecovidRepository;
    protected $employeecovidService;
    protected $employeeService;

    public function __construct(EmployeeCovidRepository $employeecovidRepository, EmployeeCovidService $employeecovidService, EmployeeService $employeeService)
    {
        $this->menu = $this->get_menu();
        $this->employeecovidRepository = $employeecovidRepository;
        $this->employeecovidService = $employeecovidService;
        $this->employeeService = $employeeService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.employeecovid.index',[
            'employee' => $this->employeeService->all(),
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
        $validate = $this->employeecovidService->formValidate($request->all());
        if ($validate)
        {
            return response()->json(
                $validate
                ,200);
        }
        $input = $request->all();
        $employeecovid = $this->employeecovidRepository->save($input);

        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($employeecovid) == true ? 'added' : 'updated')
        ],200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $employeecovid = $this->employeecovidRepository->destroy($id);

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully deleted'
        ],200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->employeecovidRepository->find($id,'employee');

        return response()->json(['data'=> $data ],200);
    }

     public function __datatable()
     {
            return $this->load_data_table($this->employeecovidRepository);
     }

}