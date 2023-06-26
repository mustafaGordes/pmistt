<div class="col-sm-12 portlets">
    <div class="widget">
        <div class="widget-header transparent">
            <h2><strong>Sistem Ayarları</strong></h2>
        </div>
        <div class="widget-content padding">
            <div class="row top-summary">
                @if(auth()->user()->can('read super_admin_role'))
                    <div class="col-lg-1 col-md-1">
                        <a class="btn btn-app bg-success" href="{{route('super_admin_role.index')}}">
                            <span class="badge bg-red">{{\Spatie\Permission\Models\Role::count()}}</span>
                            <i class="fas fa-users"></i> Roller
                        </a>
                    </div>
                @endif
                @if(auth()->user()->can('read super_admin_user'))
                        <div class="col-lg-1 col-md-1">
                            <a class="btn btn-app bg-danger" href="{{route('super_admin_user.index')}}">
                                <span class="badge bg-green">{{\App\Models\User::where('name',null)->count()}}</span>
                                <i class="fas fa-users"></i> Kullanıcılar
                            </a>
                        </div>
                @endif



            </div>
        </div>
    </div>
</div>
