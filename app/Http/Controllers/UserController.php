<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Document;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('status', 'activo')->where('id', '!=', 1)->get();

            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('document', function (User $user) {
                return $user->document->initial;
            })
            ->addColumn('role', function (User $user) {
                return $user->role->name;
            })
            ->addColumn('branch', function (User $user) {
                return $user->branch->name;
            })
            ->addColumn('edit', 'admin/user/actions')
            ->rawcolumns(['edit'])
            ->make(true);
        }

        return view('admin.user.index');
        /*
            $users = User::from('users AS use')
            ->join('branches AS bra', 'use.branch_id', 'bra.id')
            ->join('documents AS doc', 'use.document_id', 'doc.id')
            ->join('roles AS rol', 'use.role_id', 'rol.id')
            ->select('use.id', 'use.name', 'doc.initial', 'use.number', 'use.address', 'use.phone', 'use.email', 'use.position', 'rol.role', 'bra.name as nameB', 'use.status')
            ->where('use.status', '=', 'activo')
            ->get();

            return datatables()
            ->of($users)
            ->addColumn('edit', 'admin/user/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.user.index');*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::select('id', 'name')->get();
        $branches = Branch::select('id', 'name')->get();
        $documents = Document::get();
        $roles = Role::where('id', '!=', 1)->get();
        return view('admin.user.create', compact('companies', 'branches', 'documents', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->company_id = 1;
        $user->branch_id = $request->branch_id;
        $user->document_id = $request->document_id;
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->position = $request->position;
        $user->transfer = $request->transfer;
        $user->status = 1;
        $user->save();

        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.show', compact('user'));
    }

    public function show_code($id)
    {
        $user = User::findOrFail($id);
        \Session::put('user', $user->id, 60 * 24 * 365);
        \Session::put('name', $user->name, 60 * 24 * 365);

        return redirect('verification_code');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $companies = Company::get();
        $branches = Branch::get();
        $documents = Document::get();
        $roles = Role::where('id', '!=', 1)->get();
        return view('admin.user.edit', compact('user', 'companies', 'branches', 'documents', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->company_id = 1;
        $user->branch_id = $request->branch_id;
        $user->document_id = $request->document_id;
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->position = $request->position;
        $user->transfer = $request->transfer;
        $user->status = 1;
        $user->update();

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status($id)
    {
        $user = User::findOrFail($id);

        if ($user->status == 'activo') {
            $user->status = 'inactivo';
        } else {
            $user->status = 'activo';
        }
        $user->update();

        return redirect('user');
    }

    public function inactive()
    {
        if (request()->ajax()) {
            $users = User::where('status', 'inactivo')->where('id', '!=', 1)->get();

            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('document', function (User $user) {
                return $user->document->initial;
            })
            ->addColumn('role', function (User $user) {
                return $user->role->role;
            })
            ->addColumn('branch', function (User $user) {
                return $user->branch->name;
            })
            ->addColumn('btn', 'admin/user/active')
            ->rawcolumns(['btn'])
            ->make(true);
        }

        return view('admin.user.inactive');
        /*
        if (request()->ajax()) {
            $users = User::get();
            $users = User::from('users AS use')
            ->join('branches AS bra', 'use.branch_id', 'bra.id')
            ->join('documents AS doc', 'use.document_id', 'doc.id')
            ->join('roles AS rol', 'use.role_id', 'rol.id')
            ->select('use.id', 'use.name', 'doc.initial', 'use.number', 'use.address', 'use.phone', 'use.email', 'use.position', 'rol.role', 'bra.name as nameB', 'use.status')
            ->where('use.status', '=', 'inactivo')
            ->get();

            return datatables()
            ->of($users)
            ->addColumn('btn', 'admin/user/active')
            ->rawcolumns(['btn'])
            ->toJson();
        }
        return view('admin.user.inactive');*/
    }

    public function logout(Request $request)
    {
        if(session()->has('user'))
        {
            $request->session()->forget('user');
        }
        return redirect('login');
    }
}
