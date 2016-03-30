<?php

namespace App\Http\Controllers;

use App\AirData;
use App\AirType;
use Illuminate\Http\Request;
use App\Location;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $data['allLocation'] = Location::all();
        $data['menu'] = 'Air Quality';
        $data['current'] = Location::find(2);
        $data['todayAirDatas'] = $this->getAirDataByDate(false, false, 1);
        $data['airDatas'] = $this->getAirTypeWithDataByDate(false, false, $data['current']->id);
        $data['airDatasAllType'] = $this->getAllTypeAirDataByDate(false, false, $data['current']->id);
        $data['allAirType'] = AirType::all();
        $data['params']['start'] = Carbon::now()->subDays(30)->toDateString();
        $data['params']['end'] = Carbon::now()->toDateString();

        return view('front-end.index', $data);
    }

    public function getByAddress($name)
    {
        $data['allLocation'] = Location::all();
        $data['current'] = Location::whereName($name)->first();
        $data['todayAirDatas'] = $this->getAirDataByDate(false, false, 1);
        $data['airDatas'] = $this->getAirTypeWithDataByDate(false, false, $data['current']->id);
        $data['airDatasAllType'] = $this->getAllTypeAirDataByDate(false, false, $data['current']->id);
        $data['allAirType'] = AirType::all();
        $data['params']['start'] = Carbon::now()->subDays(30)->toDateString();
        $data['params']['end'] = Carbon::now()->toDateString();

        return view('index', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $data['allLocation'] = Location::all();
        $data['current'] = Location::find($request->location_id);
        $data['todayAirDatas'] = $this->getAirDataByDate(false, false, 1);

        if ($request->has('air_type_id'))
            $data['airDatas'] = $this->getAirTypeWithDataByDate($request->start, $request->end, $request->location_id, $request->air_type_id);
        else
            $data['airDatas'] = $this->getAirTypeWithDataByDate($request->start, $request->end, $request->location_id);

        $data['allAirType'] = AirType::all();
        $data['params'] = $request->all();

        return view('index', $data);
    }

    protected function getAllTypeAirDataByDate($start = false, $end = false, $location = false)
    {
        if (!$start)
            $start = Carbon::createFromDate()->hour(00)->minute(00)->second(00);

        if (!$end)
            $end = Carbon::createFromDate()->hour(23)->minute(59)->second(59);


        $airData = AirData::with(['location', 'airType'])
            ->whereBetween('date_time', array($start, $end));

        if ($location)
            $airData = $airData->whereLocationId($location);

        return $airData->groupBy('air_type_id')
            ->get();
    }

    /**
     * @param bool $start
     * @param bool $end
     * @param $airId
     * @return mixed
     */
    protected function getAirDataByDate($start = false, $end = false, $airId)
    {
        if (!$start)
            $start = Carbon::createFromDate()->hour(00)->minute(00)->second(00);

        if (!$end)
            $end = Carbon::createFromDate()->hour(23)->minute(59)->second(59);


        $airData = AirData::with(['location', 'airType'])
            ->whereBetween('date_time', array($start, $end));

        if ($airId)
            $airData = $airData->whereAirTypeId($airId);

        return $airData->groupBy('location_id')
            ->get();
    }

    /**
     * @param bool $start
     * @param bool $end
     * @param $location
     * @param bool $airType
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getAirTypeWithDataByDate($start = false, $end = false, $location, $airType = false)
    {
        if (!$start)
            $start = Carbon::now()->subDays(30)->hour(00)->minute(00)->second(00)->toDateTimeString();

        if (!$end)
            $end = Carbon::now()->hour(23)->minute(59)->second(59)->toDateTimeString();

        $airData = new AirType();

        if ($airType) {
            $airData = $airData->with(['airData' => function ($query) use ($start, $end, $location, $airType) {
                $query->whereBetween('date_time', array($start, $end))
                    ->where('location_id', $location)
                    ->whereAirTypeId($airType)
                    ->orderBy('date_time', 'desc');
//                ->groupBy(\DB::raw('DATE(date_time)'));
            }])->whereHas('airData', function ($query) use ($start, $end, $location, $airType) {
                $query->whereBetween('date_time', array($start, $end))
                    ->whereAirTypeId($airType)
                    ->where('location_id', $location);
            });
        } else {
            $airData = $airData->with(['airData' => function ($query) use ($start, $end, $location, $airType) {
                $query->whereBetween('date_time', array($start, $end))
                    ->where('location_id', $location)
                    ->orderBy('date_time', 'desc');
//                ->groupBy(\DB::raw('DATE(date_time)'));
            }])->whereHas('airData', function ($query) use ($start, $end, $location, $airType) {
                $query->whereBetween('date_time', array($start, $end))
                    ->where('location_id', $location);
            });
        }

        return $airData->get();
    }

    /**
     * @param $value
     * @return string
     */
    public function colorChooser($value)
    {
        if ($value >= 0 && $value <= 50)
            return ['#009966', 'Good'];

        elseif ($value >= 51 && $value <= 100)
            return ['#FFDE33', 'Moderate'];

        elseif ($value >= 101 && $value <= 150)
            return ['#FF9933', 'Unhealthy for Sensitive Groups'];

        elseif ($value >= 151 && $value <= 200)
            return ['#CC0033', 'Unhealthy'];

        elseif ($value >= 251 && $value <= 300)
            return ['#660099', 'Very Unhealthy'];

        else
            return ['#7E0023', 'Hazardous'];
    }

    public function urbanRegeneration()
    {
        $data['menu'] = 'Urban Regeneration';
        return view('front-end.urban-regeneration', $data);
    }

    public function environmentalHealth()
    {
        $data['menu'] = 'Environmental Health';
        return view('front-end.environmental-health', $data);
    }

    public function digitalDhaka()
    {
        $data['menu'] = 'Digital Dhaka';
        return view('front-end.digital-dhaka', $data);
    }
}
