<?php

namespace App\Http\Controllers;

use App\AirData;
use App\AirType;
use App\Http\Requests;
use App\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $data['airDatas'] = AirType::with('airData')->whereHas('airData', function ($query) {
            $query->whereBetween('date_time', array(Carbon::now()->subDays(7)->toDateString(), Carbon::now()->toDateString()))
                ->whereLocationId(3);
        })->get();
//        dd($data['airDatas']->toArray());

        return view('index', $data);
    }

    public function colorChooser($value)
    {
        if ($value >= 0 && $value <= 50)
            return '#009966';

        elseif ($value >= 51 && $value <= 100)
            return '#FFDE33';

        elseif ($value >= 101 && $value <= 150)
            return '#FF9933';

        elseif ($value >= 151 && $value <= 200)
            return '#CC0033';

        elseif ($value >= 251 && $value <= 300)
            return '#660099';

        else
            return '#7E0023';
    }
}
