<?php
/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/

namespace App\Http\Controllers\Generator;

use App\Models\Generator\Employee;
use App\Service\UploadHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CoreController;


use App\Repository\Generator\EmployeeRepository;
use App\Service\Generator\EmployeeService;


class EmployeeController extends CoreController
{
    protected $menu;
    private $settingVal;
    protected $employeeRepository;
    protected $employeeService;

    public function __construct(EmployeeRepository $employeeRepository, EmployeeService $employeeService)
    {
        $this->menu = $this->get_menu();
        $this->employeeRepository = $employeeRepository;
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
        return view('admin.contents.employee.index',[
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
    public function store(Request $request, UploadHandler $uploadHandler)
    {
        $input = $request->all();
        $id = $request->get('id');

        if ($request->hasFile('file_upload')) {
            $file_upload = $this->employeeService->insertFiles($uploadHandler , $this->employeeRepository->getModel() , $request, 'employee', $id);
        }else{
            $file_upload = $this->employeeRepository->find($id)->file_upload;
        }

        $input['file_upload'] = $file_upload;
        $news = $this->employeeRepository->save($input);

        return response()->json([
            'status'=> 'success',
            'message' => "Data is successfully  " . (is_object($news) == true ? 'added' : 'updated')
        ],200);
    }

    public function destroy(Request $request)
    {
        $id  = $request->only('id');
        $employee = $this->employeeRepository->destroy($id);

        return response()->json([
            'status'=> 'success',
            'message' => 'Data is successfully deleted'
        ],200);
    }

    public function get(Request $request)
    {
        $id = $request->get('id');
        $data = $this->employeeRepository->find($id);

        return response()->json(['data'=> $data ],200);
    }

     public function __datatable()
     {
            return $this->load_data_table($this->employeeRepository);
     }

}