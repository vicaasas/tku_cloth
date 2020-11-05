<?php

namespace App\Http\Controllers\SubSystem;

use App\SubModel\Cloth;
use App\SubModel\Config;
use App\SubModel\Order;
use App\SubModel\Time;
use App\SubModel\GetClothTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexController extends Controller
{
    public function __construct(){
        $this->middleware('preventBackHistory'); 
    }
    public function index(Request $request)
    {

        //return $request->session()->all();
        $cloths = Cloth::all();

        $cloth_table = '<tr>';

        if (Gate::allows('admin')) {
            foreach ($cloths->groupBy('type') as $key => $value) {
                $cloth_table .= '<td class="text-center table-light align-middle" rowspan="' . count($value) . '"><strong>' . $key . '</strong></td>';
                foreach ($value->groupBy('name') as $name_key => $name_value) {
                    $cloth_table .= '<td class="text-center table-light align-middle" rowspan="' . count($name_value) . '">' . $name_key . '</td>';
                    foreach ($name_value as $item) {
                        $cloth_table .= '<td class="text-center align-middle">' . $item->property . '</td>';
                        $cloth_table .= '<td class="text-center align-middle">' . $item->quantity . '</td>';

                        $o = Order::all();
                        $lent = count($o->where('cloth', $item->id)->where('state', !Order::STATE_RETURNED));
                        if ($lent == 0) {
                            $lent = count($o->where('accessory', $item->id)->where('state', !Order::STATE_RETURNED));
                        }

                        $left = $item->quantity - $lent;

                        $cloth_table .= '<td class="text-center align-middle">' . $left . '</td>';

                        $cloth_table .= '</tr>';
                    }
                }
            }
        }

        if (Gate::denies('admin')) {
            foreach ($cloths->where('type', Auth::user()->department) as $data) {
                $cloth_table .= '<td class="text-center align-middle">' . $data->type . $data->name . '</td>';
                $cloth_table .= '<td class="text-center align-middle">' . $data->property . '</td>';

                $o = Order::all();
                $lent = count($o->where('cloth', $data->id)->where('state', !Order::STATE_RETURNED));
                if ($lent == 0) {
                    $lent = count($o->where('accessory', $data->id)->where('state', !Order::STATE_RETURNED));
                }
                $left = $data->quantity - $lent;
                $cloth_table .= '<td class="text-center align-middle">' . $left . '</td>';

                $cloth_table .= '</tr>';
            }
        }

        return view('sub_system.index',
            [
                'location' => Config::where('key', '歸還地點')->first()->value,
                'time_list' => Time::all(),
                'get_cloth_time_list' => GetClothTime::all(),
                'cloth_table' => $cloth_table,
            ]);
    }
}