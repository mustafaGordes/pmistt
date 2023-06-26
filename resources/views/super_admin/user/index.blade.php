@extends("wellow.layouts.app")
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Modal -->
            <div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="detail_modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Kullanıcı Detay</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">@include('super_admin.system_setting')</div>
            <div class="row">
                <div class="col-md-12">
                    <div class="widget">
                        <div class="widget-header">
                            <h2><strong>Kullanıcı</strong> Listesi</h2>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title justify-content-center">
                                    <i class="fas fa-newspaper mr-1"></i>
                                    Kullanıcılar
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="user-table" class="display nowrap dataTable cell-border" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kullanıcı Rolü</th>
                                        <th>Kullanıcı Adı</th>
                                        <th>Detay</th>
                                        <th>Güncelle</th>
                                        <th>Sil</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kullanıcı Rolü</th>
                                        <th>Kullanıcı Adı</th>
                                        <th>Detay</th>
                                        <th>Güncelle</th>
                                        <th>Sil</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="{{route('super_admin_user.create')}}" class="btn btn-info float-right"><i class="fas fa-plus"></i>Yeni Kullanıcı Ekle</a><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">

        function remove(id,name) {
            Swal.fire({
                icon: "warning",
                dangerMode: true,
                title:"Emin misiniz?",
                html: '"' + name + '"' + ", isimli kullancıyı silmek istediğinizden emin misiniz?",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Onayla",
                cancelButtonText: "İptal",
                cancelButtonColor: "#e30d0d"
            }).then((result)=>{
                if (result.isConfirmed){
                    $.ajax({
                        url: "{{ route('super_admin_user.destroy', 0) }}"+id  ,
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

        function detail(id) {
            $.ajax({
                url: "{{ route('super_admin_user.show', 0) }}"+id  ,
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    $('#detail_modal').find('.modal-body').empty();
                    Object.keys(result).map(function(key, index) {
                        $('#detail_modal').find('.modal-body').append('<strong>'+key+':</strong> '+result[key]+'<br>');

                    });
                },
                error: function (xhr, status, error) {
                    swal({
                        title: "Uyarı!",
                        text: "Silme işlemi başarısız.",
                        icon: "error",
                        button: false,
                    });
                }
            });
        }

        var table = $('#user-table').DataTable( {
            order: [
                [0,'DESC']
            ],
            scrollY:    true,
            scrollX:    true,
            processing: true,
            serverSide: true,
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Turkish.json"
            },
            ajax: '{!!route('super_admin_user.fetch')!!}',
            columns: [
                {data: 'id'},
                {data: 'userRole'},
                {data: 'name'},
                {data: 'detail'},
                {data: 'update'},
                {data: 'delete'}
            ]
        } );

    </script>
@endsection


