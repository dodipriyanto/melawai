<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Http\Controllers\Generator;

use App\Models\Generator\MonitoringEmployeeCovid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;
use App\Service\Generator\EmployeeCovidService;


use App\Repository\Generator\MonitoringEmployeeCovidRepository;
use App\Service\Generator\MonitoringEmployeeCovidService;
use App\Service\Generator\MonitoringCovidService;


class MonitoringEmployeeCovidController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $monitoringemployeecovidRepository;
    protected $monitoringemployeecovidService;
    protected $employeeCovidService;
    protected $monitoringCovidService;

    public function __construct(MonitoringEmployeeCovidRepository $monitoringemployeecovidRepository, MonitoringEmployeeCovidService $monitoringemployeecovidService,
                                EmployeeCovidService $employeeCovidService, MonitoringCovidService $monitoringCovidService)
    {
        $this->menu = $this->get_menu();
        $this->monitoringemployeecovidRepository = $monitoringemployeecovidRepository;
        $this->monitoringemployeecovidService = $monitoringemployeecovidService;
        $this->employeeCovidService = $employeeCovidService;
        $this->monitoringCovidService = $monitoringCovidService;
        $this->settingVal = $this->get_all_setting();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contents.monitoringemployeecovid.index',[
            'employee_covid' => $this->employeeCovidService->all('employee'),
            'monitoring' => $this->monitoringCovidService->all(),
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
        $validate = $this->monitoringemployeecovidService->formValidate($request->all());
        if ($validate)
        {
            return response()->json(
                $validate
                ,200);
        }
        $input = $request->all();
        $monitoringemployeecovid = $this->monitoringemployeecovidRepository->save($input);

        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($monitoringemployeecovid) == true ? 'added' : 'updated')
        ],200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $monitoringemployeecovid = $this->monitoringemployeecovidRepository->destroy($id);

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully deleted'
        ],200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->monitoringemployeecovidRepository->findWith($id,['employee_covid','monitoring']);

        return response()->json(['data'=> $data ],200);
    }

     public function __datatable()
     {
            return $this->load_data_table($this->monitoringemployeecovidRepository);
     }

}