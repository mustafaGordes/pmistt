<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\model_has_roles;
use App\Models\User;
use App\Models\UserDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class userContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('super_admin.user.index');
    }

    public function indexMezun()

    {
        return view('super_admin.user.indexMezun');
    }



    public function fetch(){
        $users = User::all();

        return DataTables::of($users)->editColumn('content', function ($data){
        })->addColumn('userRole', function ($data){
            $role = 'Yetkisiz Kullanıcı';

            if ($data->getRoleNames()->first()){
                $role= $data->getRoleNames()->first();
            }
            return $role;

        })->addColumn('detail', function ($data){
            return "<a data-toggle='modal' onclick='detail(".$data->id.")' data-target='#detail_modal' class='btn btn-primary'>Detay</a>";
        })->addColumn('update', function ($data){
            return '<a href="'.route('super_admin_user.edit', $data->id).'" class="btn btn-warning">Güncelle</a>';
        })->addColumn('delete', function ($data){
            return '<a data-toggle="tooltip" onclick="remove('.$data->id.',\''.$data->name.'\')" data-target="#detail_modal" class="btn btn-danger">Sil</a>';
        })->rawColumns(['delete','update','detail','userRole','content'])->make();
    }

    public function fetchMezun(){
        $users = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('role_id','=',7);


        return DataTables::of($users)->editColumn('content', function ($data){
        })->addColumn('userRole', function ($data){
            $role = 'Yetkisiz Kullanıcı';

            if ($data->getRoleNames()->first()){
                $role= $data->getRoleNames()->first();
            }
            return $role;
        })->addColumn('namee', function ($data){
            if (!is_null($data->department_id)){
                return Department::find($data->department_id)->title;

            }else{
                return 'Bulunamadı';
            }
        })->addColumn('department_name',function ($data){
            $departments = UserDepartment::where('user_id',$data->id)->get();
            $department_name = '';
            $sayac = 1;
            foreach($departments as $department){
                $url = 'http://'.Department::find($department->department_id)->subdomain.'firat.edu.tr/tr';
                $department_name .= "<a href='$url'>".Department::find($department->department_id)->subdomain.'firat.edu.tr'."</a>";
                if($sayac++ != $departments->count()){
                    $department_name .= ' / ';
                }
            }
            return $department_name;
        })->addColumn('detail', function ($data){
            return "<a data-toggle='modal' onclick='detail(".$data->id.")' data-target='#detail_modal' class='btn btn-primary'>Detay</a>";
        })->addColumn('update', function ($data){
            return '<a href="'.route('super_admin_user.edit', $data->id).'" class="btn btn-warning">Güncelle</a>';
        })->addColumn('delete', function ($data){
            return '<a data-toggle="tooltip" onclick="remove('.$data->id.',\''.$data->userFirstName.'\')" data-target="#detail_modal" class="btn btn-danger">Sil</a>';
        })->rawColumns(['delete','update','detail','userRole','content','department_name'])->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('super_admin.user.create', compact('roles'));
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
            'email' => 'required',
        ]);
        foreach ($request->all() as $key=>$value){
            $request->$key = Helper::scriptStripper($value);
        }

        $user = User::create([
            'email' => $request->email,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('super_admin_user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return $user;
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
            'id' => 'distinct'
        ]);
        $user = User::find($id);
        $roles = Role::all();


        return view('super_admin.user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){
        if(!is_numeric($id) || $id < 0 || $id > User::orderByDesc('id')->first()->id){
            return 'Hata!';
        }

        $user = User::find($id);

        if($user){
            $request->validate([
                'email' => 'required',
            ]);

           if (is_null($user->roles)){
               if($user->roles[0]->id == 7){//Mezunsa
                   $data['email'] = $request->email;
               }
               else{
                   $data['email'] = $request->email;
               }
           }
           else{
               $data['email'] = $request->email;
           }

            $user->update($data);

            $user->syncRoles($request->role);
            if ($request->role2 != null){
                $user->syncRoles($request->role,$request->role2);
            }

            return redirect()->route('super_admin_user.index');
        }else{
            return 'HATA!';
        }


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
            'id' => 'distinct'
        ]);
        $result = $message = '';
        $user = User::find($id);
        if ($user) {

            if ($user->delete()) {


                DB::table('model_has_roles')->where('model_id',$id)->delete();

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
