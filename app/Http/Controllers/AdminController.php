<?php

namespace App\Http\Controllers;

use App\AirData;
use App\AirType;
use App\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Session;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['air_datas'] = AirData::with(['location', 'airType'])->paginate(10);
        return view('admin.list', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['locations'] = Location::all();
        $data['air_types'] = AirType::all();
        return view('admin.index', $data);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = $this->validation($request->all());
        if ($validator->fails()) {
            return redirect("admin/create")
                ->withInput($request->all())
                ->withErrors(
                    $validator->messages()
                );
        }

        $airData = new AirData();
        $airData->date_time = $request->date_time;
        $airData->location_id = $request->location_id;
        $airData->air_type_id = $request->air_type_id;
        $airData->value = $request->value;
        $airData->save();

        Session::flash('success', 'Air Data Save Successfully');
        return redirect('admin/create');
    }

    /**
     * @param AirData $airData
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AirData $airData)
    {
        $data['airData'] = $airData;
        $data['locations'] = Location::all();
        $data['air_types'] = AirType::all();

        return view('admin.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $validator = $this->validation($request->all());
        if ($validator->fails()) {
            return redirect("admin/$id/edit")
                ->withInput($request->all())
                ->withErrors(
                    $validator->messages()
                );
        }

        $airData = AirData::find($id);
        $airData->date_time = $request->date_time;
        $airData->location_id = $request->location_id;
        $airData->air_type_id = $request->air_type_id;
        $airData->value = $request->value;
        $airData->save();

        Session::flash('success', 'Air Data Updated Successfully');
        return redirect('admin');
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function validation($data)
    {
        return Validator::make($data, [
            'date_time' => 'required|date_format:Y-m-d H:i',
            'location_id' => 'required',
            'air_type_id' => 'required',
            'value' => 'required|integer',
        ]);
    }
}
