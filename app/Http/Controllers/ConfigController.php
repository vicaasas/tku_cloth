<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function update_location(Request $request)
    {
        $this->validateLocation($request);

        $this->saveLocation($request);

        $request->session()->flash('success', '歸還地點更新成功！');
        return redirect()->route('home');
    }

    private function validateLocation(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
        ]);
    }

    private function saveLocation(Request $request)
    {
        $location = Config::where('key', '歸還地點')->first();
        $location->value = $request->input('location');
        $location->save();
    }
}
