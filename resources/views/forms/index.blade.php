<!DOCTYPE html>
<html>
<head>
    <title>Forum</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .question {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h1>Forum</h1>

    <!-- Forum Oluşturma Formu -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createForumModal">
        Yeni Forum Oluştur
    </button>

    <!-- Forum Soruları -->
    <div class="list-group">

        @forelse ($forumQuestions as $question)
            <div class="list-group-item question" data-id="{{ $question->id }}">
                <h5 class="mb-1">{{ $question->title }}</h5>
                <p class="mb-1">{{ $question->body }}</p>
            </div>
        @empty
            <p>Henüz forum sorusu bulunmamaktadır.</p>
        @endforelse

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="answerModalLabel">Soru ve Cevaplar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Soru ve Cevap İçeriği Burada Gösterilecek -->
            </div>
        </div>
    </div>
</div>

<!-- Modal - Forum Oluşturma -->
<div class="modal fade" id="createForumModal" tabindex="-1" role="dialog" aria-labelledby="createForumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createForumModalLabel">Yeni Forum Oluştur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForumForm" action="{{ route('forum.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Başlık</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Resim</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <label for="question">Soru</label>
                        <textarea class="form-control" id="question" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Oluştur</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Cevap Ekleme -->
<div class="modal fade" id="createAnswerModal" tabindex="-1" role="dialog" aria-labelledby="createAnswerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAnswerModalLabel">Cevap Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createAnswerForm" action="{{ route('forum.answer', ['questionId' => ':questionId']) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="answer">Cevap</label>
                        <textarea class="form-control" id="answer" name="answer" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Cevap Düzenleme -->
<div class="modal fade" id="updateAnswerModal" tabindex="-1" role="dialog" aria-labelledby="updateAnswerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAnswerModalLabel">Cevap Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateAnswerForm" action="{{ route('forum.updateAnswer', ['answerId' => ':answerId']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="updatedAnswer">Düzenlenmiş Cevap</label>
                        <textarea class="form-control" id="updatedAnswer" name="updatedAnswer" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Düzenle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Soru Düzenleme -->
<div class="modal fade" id="updateQuestionModal" tabindex="-1" role="dialog" aria-labelledby="updateQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateQuestionModalLabel">Soru Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateQuestionForm" action="{{ route('forum.update', ['id' => ':questionId']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="updatedTitle">Düzenlenmiş Başlık</label>
                        <input type="text" class="form-control" id="updatedTitle" name="updatedTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="updatedBody">Düzenlenmiş Soru</label>
                        <textarea class="form-control" id="updatedBody" name="updatedBody" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Düzenle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Soru Silme -->
<div class="modal fade" id="deleteQuestionModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteQuestionModalLabel">Soru Sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Emin misiniz? Bu işlem geri alınamaz.</p>
                <form id="deleteQuestionForm" action="{{ route('forum.delete', ['id' => ':questionId']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Cevap Silme -->
<div class="modal fade" id="deleteAnswerModal" tabindex="-1" role="dialog" aria-labelledby="deleteAnswerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAnswerModalLabel">Cevap Sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Emin misiniz? Bu işlem geri alınamaz.</p>
                <form id="deleteAnswerForm" action="{{ route('forum.deleteAnswer', ['answerId' => ':answerId']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Soru ve Cevapların Modalda Gösterilmesi
        $(document).on('click', '.question', function() {
            var questionId = $(this).data('id');
            $.ajax({
                url: '/forum/' + questionId,
                type: 'GET',
                success: function(response) {
                    $('#answerModal .modal-body').html(response);
                    $('#answerModal').modal('show');
                }
            });
        });

        // Forum Oluşturma Formunun Ajax ile Gönderilmesi
        $('#createForumForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('#createForumModal').modal('hide');
                    form.trigger('reset');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        // Cevap Ekleme Formunun Ajax ile Gönderilmesi
        $(document).on('submit', '#createAnswerForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var questionId = form.data('question-id');
            var url = form.attr('action').replace(':questionId', questionId);
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('#createAnswerModal').modal('hide');
                    form.trigger('reset');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        // Cevap Düzenleme Formunun Ajax ile Gönderilmesi
        $(document).on('submit', '#updateAnswerForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var answerId = form.data('answer-id');
            var url = form.attr('action').replace(':answerId', answerId);
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('#updateAnswerModal').modal('hide');
                    form.trigger('reset');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        // Soru Düzenleme Formunun Ajax ile Gönderilmesi
        $(document).on('submit', '#updateQuestionForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var questionId = form.data('question-id');
            var url = form.attr('action').replace(':questionId', questionId);
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('#updateQuestionModal').modal('hide');
                    form.trigger('reset');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        // Soru Silme Formunun Ajax ile Gönderilmesi
        $(document).on('submit', '#deleteQuestionForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var questionId = form.data('question-id');
            var url = form.attr('action').replace(':questionId', questionId);
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('#deleteQuestionModal').modal('hide');
                    form.trigger('reset');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        // Cevap Silme Formunun Ajax ile Gönderilmesi
        $(document).on('submit', '#deleteAnswerForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var answerId = form.data('answer-id');
            var url = form.attr('action').replace(':answerId', answerId);
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('#deleteAnswerModal').modal('hide');
                    form.trigger('reset');
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });
    });
</script>
</body>
</html>
