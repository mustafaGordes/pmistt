@extends("wellow.layouts.app")
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="row">@include('panel.super_admin.system_setting')</div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-sm-6 portlets">
                    <div class="widget">
                        <div class="widget-header transparent">
                            <h2><strong>Rol</strong> Güncelle</h2>
                        </div>

                        <div class="widget-content padding">
                            <div id="basic-form">
                                <form role="form" action="{{route('panel.super_admin_role.update', $role->id)}}" method="POST">
                                    <input type="hidden" name="_method" value="patch">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Adı</label>
                                                <input type="text" class="form-control" name="name" value="{{$role->name}}"
                                                       placeholder="Adı">
                                            </div>
                                            @if ($errors->has('name'))
                                                <div class="alert alert-danger nomargin">
                                                    {{ $errors->first('name') }}
                                                </div><br>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" style="overflow-x: unset;">
                                                <table class="table product_tree_table">
                                                    <thead>
                                                    <tr>
                                                        <th>İzin</th>
                                                        <th width="100">Oku</th>
                                                        <th width="100">Oluştur</th>
                                                        <th width="100">Güncelle</th>
                                                        <th width="100">Sil</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($permissions->get_permissions() as $key => $permission)
                                                        <tr>
                                                            <td>
                                                                <label class="control-label">{{$permission}}</label>
                                                            </td>
                                                            <td><input type="checkbox" name="permissions[]" value="read {{$key}}" {{ $role->hasPermissionTo('read '.$key) ? " checked" : ''}}></td>
                                                            <td><input type="checkbox" name="permissions[]" value="create {{$key}}" {{ $role->hasPermissionTo('create '.$key) ? " checked" : ''}}></td>
                                                            <td><input type="checkbox" name="permissions[]" value="update {{$key}}" {{ $role->hasPermissionTo('update '.$key) ? " checked" : ''}}></td>
                                                            <td><input type="checkbox" name="permissions[]" value="delete {{$key}}" {{ $role->hasPermissionTo('delete '.$key) ? " checked" : ''}}></td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-block btn-secondary btn-lg">Kaydet</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
@endsection
