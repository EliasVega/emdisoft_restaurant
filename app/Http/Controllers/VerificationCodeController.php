<?php

namespace App\Http\Controllers;

use App\Models\Verification_code;
use App\Http\Requests\StoreVerification_codeRequest;
use App\Http\Requests\UpdateVerification_codeRequest;
use App\Models\User;

class VerificationCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $verification_codes = Verification_code::from('verification_codes as vc')
            ->join('users as use', 'vc.user_id', 'use.id')
            ->select('vc.id', 'use.name', 'use.status', 'vc.code')
            ->where('use.status', '=', 'ACTIVO')
            ->get();

            return datatables()
            ->of($verification_codes)
            ->addColumn('btn', 'admin/verification_code/actions')
            ->addColumn('accesos', 'admin/verification_code/eliminar')
            ->rawcolumns(['btn', 'accesos'])
            ->toJson();
        }
        return view('admin.verification_code.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('id', '!=', 1)->get();
        return view('admin.verification_code.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVerification_codeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVerification_codeRequest $request)
    {
        $verification_codes = Verification_code::get();
        $id = $request->user_id;
        $cont = 0;
        foreach ($verification_codes as $key) {
            if($key->user_id == $id)
            $cont ++;
        }
        if ($cont > 0) {
            return redirect('verification_code')->with('warning', 'Este Usuario Ya tiene Asignado un Codigo');
        } else {
            $verification_code = new verification_code();
            $verification_code->user_id = $request->user_id;
            $verification_code->code = $request->code;
            $verification_code->save();
        }
        return redirect('verification_code')->with('success', 'Autorizacion creada Satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Verification_code  $verification_code
     * @return \Illuminate\Http\Response
     */
    public function show(Verification_code $verification_code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Verification_code  $verification_code
     * @return \Illuminate\Http\Response
     */
    public function edit(Verification_code $verification_code)
    {
        $user = User::where('id', '=', $verification_code->user_id)->first();
        return view('admin.verification_code.edit', compact('verification_code', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVerification_codeRequest  $request
     * @param  \App\Models\Verification_code  $verification_code
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVerification_codeRequest $request, Verification_code $verification_code)
    {
        $verification_code->code = $request->code;
        $verification_code->update();
        return redirect('verification_code');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Verification_code  $verification_code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Verification_code $verification_code)
    {
        $verification_code->delete();
        return redirect('verification_code');
    }
}
