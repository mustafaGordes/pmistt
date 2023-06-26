@extends("wellow.layouts.app")
@section('content')
    <div class="content-page">
        <div class="content">
            <div class="row">@include('super_admin.system_setting')</div>
            <div class="container-fluid pt-5">
                <!-- TO DO List -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title justify-content-center">
                            <i class="fas fa-newspaper mr-1"></i>
                            Roller
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="role-table" class="display nowrap dataTable cell-border" style="width:100%">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Adı</th>
                                <th>Oluşturulma Tarihi</th>
                                <th>Güncellenme Tarihi</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>id</th>
                                <th>Adı</th>
                                <th>Oluşturulma Tarihi</th>
                                <th>Güncellenme Tarihi</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="{{route('super_admin_role.create')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i>Yeni Rol Ekle</a><br><br>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>


    <script type="text/javascript">

        function remove(id,name) {

            Swal.fire({
                icon: "warning",
                dangerMode: true,
                title:"Emin misiniz?",
                html: '"' + name + '"' + ", isimli rol bilgisini silmek istediğinizden emin misiniz?",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Onayla",
                cancelButtonText: "İptal",
                cancelButtonColor: "#e30d0d"
              }).then((result)=>{
                    if (result.isConfirmed){
                        $.ajax({
                            url: "{{ route('super_admin_role.destroy', 0) }}"+id  ,
                            method: 'delete',
                            headers: {'X-CSRF-TOKEN': "{{csrf_token()}} "},

                            success: function (){
                                Swal.fire({
                                    icon: "success",
                                    title:"Başarılı",
                                    showConfirmButton: true,
                                    confirmButtonText: "Tamam"
                                });
                                table.ajax.reload();
                            },
                            error: function (){
                                Swal.fire({
                                    icon: "error",
                                    title:"Hata!",
                                    html: "<div id=\"validation-errors\"></div>",
                                    showConfirmButton: true,
                                    confirmButtonText: "Tamam"
                                });
                                $.each(data.responseJSON.errors, function(key,value) {
                                    $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div>');
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Uyarı!",
                            text: "Silme işleminden vazgeçildi.",
                            icon: "info",
                            button: false,
                        });
                    }
                });
        }



        var table = $('#role-table').DataTable( {
            order: [
                [0,'DESC']
            ],
            processing: true,
            serverSide: true,
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Turkish.json"
            },
            ajax: '{!!route('super_admin_role.fetch')!!}',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'created_at'},
                {data: 'updated_at'},
                {data: 'update'},
                {data: 'delete'}
            ]
        } );

    </script>

@endsection

