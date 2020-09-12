<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageChangeController extends Controller
{
    public function change(Request $request)
    {
        // 限制只有管理員可以
        $this->authorize('admin');

        // 驗證格式是否正確
        $this->validateImage($request);

        // 儲存進資料庫
        $this->saveNewImage($request);
        // return '<img src="data:image/jpeg;base64,' . $base64_image . '" alt="未設定圖檔">';

        $request->session()->flash('success', '印鑑變更成功！');
        return redirect()->route('profile');
    }

    private function validateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ], 
        [
            'required' => '不能沒有圖檔',
            'image' => '不能為非圖檔類型',
        ]);
    }

    private function saveNewImage(Request $request)
    {
        $user = User::find(Auth::id());
        $user->base64Img = base64_encode(file_get_contents($request->file('image')));
        $user->save();
    }
}
