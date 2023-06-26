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
                            <h2><strong>Kullanıcı</strong> Oluştur</h2>
                        </div>
                        <div class="widget-content padding">
                            <div id="basic-form">
                                <form role="form" action="{{route('panel.super_admin_user.store')}}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Kullanıcı Email</label>
                                                <input type="email" class="form-control" name="email" value="{{old('email')}}"
                                                       placeholder="Kullanıcı Email">
                                            </div>
                                            @if ($errors->has('email'))
                                                <div class="alert alert-danger nomargin">
                                                    {{ $errors->first('email') }}
                                                </div><br>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Kullanıcı Rolü</label>
                                                <select class="form-control" name="role" id="role">
                                                    <option value="">Rol Seçiniz</option>
                                                    @foreach($roles as $key => $role)
                                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('role'))
                                                <div class="alert alert-danger nomargin">
                                                    {{ $errors->first('role') }}
                                                </div><br>
                                            @endif
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
