<?php

namespace App\Http\Controllers;

use App\Cloth;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ClothController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(){
        $this->middleware('preventBackHistory'); 
    }
    public function index()
    {
        return view('admin.cloth', ['cloths' => Cloth::all(), 'orders' => Order::all(),]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validateCloth($request);

//        return $request;
        $cloth = new Cloth();
        $cloth->type = $request->type;
        $cloth->name = $request->name;
        $cloth->property = $request->property;
        $cloth->quantity = $request->quantity;
        $cloth->save();
        $request->session()->flash('success', '新增資料成功！');
        return $this->redirectAfterDone();
    }

    /**
     * Display the specified resource.
     *
     * @param Cloth $cloth
     * @return Response
     */
    public function show(Cloth $cloth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Cloth $cloth
     * @return Response
     */
    public function edit(Cloth $cloth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Cloth $cloth
     * @return Response
     */
    public function update(Request $request, Cloth $cloth)
    {
        $this->validateCloth($request);

        $cloth->quantity = $request->quantity;
        $cloth->save();
        $request->session()->flash('success', '資料變更成功！');
        return $this->redirectAfterDone();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cloth $cloth
     * @return Response
     */
    public function destroy(Request $request, Cloth $cloth)
    {
        $cloth->delete();
        $request->session()->flash('success', '資料刪除成功！');
        return $this->redirectAfterDone();
    }

    private function redirectAfterDone()
    {
        return Redirect::route('cloth.index');
    }

    private function validateCloth(Request $request)
    {
        if ($request->has('type')) {
            $request->validate([
                'type' => [
                    'required',
                    Rule::in([User::DEPARTMENT_BACHELOR, User::DEPARTMENT_MASTER, User::DEPARTMENT_DOCTOR]),
                ],
                'name' => 'required|string',
                'property' => [
                    'required',
                    Rule::unique('cloths')
                        ->where('type', $request->type)
                        ->where('name', $request->name)
                        ->where('property', $request->property),
                ],
            ]);
        }
        $request->validate([
            'quantity' => 'required|numeric',
        ], [
            'numeric' => '不可為非數字',
        ]);
    }
}
