<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\Helper;
use App\Helpers\Permission\Permission as HelperPermission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class roleContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {

        return view('super_admin.role.index');
    }

    public function fetch(){

        $roles = Role::all();

        return DataTables::of($roles)->editColumn('content', function ($data){
        })->addColumn('update', function ($data){
            return '<a href="'.route('super_admin_role.edit', $data->id).'" class="btn btn-warning">Güncelle</a>';
        })->addColumn('delete', function ($data){
            return '<a data-toggle="tooltip" onclick="remove('.$data->id.',\''.$data->name.'\')" data-target="#detail_modal" class="btn btn-danger">Sil</a>';
        })->rawColumns(['delete','update','content'])->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = new HelperPermission();

        return view('super_admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'id' => 'distinct',
            'name' => 'required|string|max:255',
            'permissions.*' => 'exists:permissions,name',
        ]);
        foreach ($request->all() as $key=>$value){
            if ($key != "permissions")
                $request->$key = Helper::scriptStripper($value);
        }


        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('super_admin_role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $request->validate([
            'id' => 'distinct',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request,$id)
    {
        $request->validate([
            'id' => 'distinct',
        ]);
        $role = Role::findById($id);
        $permissions = new HelperPermission();

        return view('super_admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'distinct',
            'name' => 'required|string|max:255',
            'permissions.*' => 'exists:permissions,name',
        ]);
        foreach ($request->all() as $key=>$value){
            if ($key != "permissions")
                $request->$key = Helper::scriptStripper($value);
        }

        $permissions = Helper::scriptStripper(implode(',',$request->permissions));
        $request->permissions = explode(',',$permissions);


        $role = Role::findById($id);
        $role->name=$request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        return redirect()->route('super_admin_role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request,$id)
    {
        $request->validate([
            'id' => 'distinct',
        ]);
        $result = $message = '';
        $role = Role::findById($id);

        if ($role) {
            if ($role->delete()) {
                $result = 'ok';
                $message = 'Silme İşlemi Başarılı';
            } else {
                $result = 'hata';
                $message = 'Silme İşlemi Başarısız Oldu';
            }
        } else {
            $result = 'hata';
            $message = 'Silme İşlemi Başarısız, Böyle Bir Kayıt Yok';
        }

        return response()->json([
            'result' => $result,
            'message' => $message
        ]);
    }

}
