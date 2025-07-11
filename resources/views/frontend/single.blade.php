{{-- resources/views/frontend/single.blade.php --}}

@extends('frontend.app') {{-- Pastikan ini mengarah ke layout utama frontend Anda --}}

@section('content')

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="position-relative mb-3">
                {{-- Gambar Berita Utama --}}
                @if ($news->media)
                    {{-- Menggunakan relasi Media untuk gambar utama berita --}}
                    <img class="img-fluid w-100" src="{{ Storage::url($news->media->file_path) }}" style="object-fit: cover; max-height: 450px;">
                @elseif($news->gambar_berita)
                    {{-- Fallback jika ada kolom gambar_berita langsung di model News --}}
                    {{-- Asumsi gambar_berita disimpan di 'storage/app/public/uploads/' --}}
                    <img class="img-fluid w-100" src="{{ Storage::url('uploads/' . $news->gambar_berita) }}" style="object-fit: cover; max-height: 450px;">
                @else
                    {{-- Gambar placeholder jika tidak ada gambar berita --}}
                    <img class="img-fluid w-100" src="{{ asset('img/default-news.jpg') }}" style="object-fit: cover; max-height: 450px;">
                @endif

                <div class="overlay position-relative bg-white px-3 pt-2">
                    <div class="mb-3">
                        {{-- Kategori Berita --}}
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                            href="{{ route('category.news', $news->category->category_id ?? '#') }}">
                            {{ $news->category->category_name ?? 'Uncategorized' }}
                        </a>
                        {{-- Tanggal Publikasi --}}
                        <a class="text-body" href="{{ route('news.single', $news->slug ?? $news->news_id) }}">
                            <small>{{ \Carbon\Carbon::parse($news->published_at)->format('M d, Y') }}</small>
                        </a>
                    </div>
                    {{-- Judul Berita --}}
                    <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">{{ $news->title }}</h1>
                    {{-- Konten Berita (menggunakan {!! !!} karena mungkin berisi HTML) --}}
                    <p>{!! $news->content !!}</p>

                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                        {{-- Penulis Berita --}}
                        <div class="d-flex align-items-center">
                            @if($news->user && $news->user->profile_photo_path)
                                {{-- Asumsi profile_photo_path disimpan di 'storage/app/public/uploads/' --}}
                                <img class="rounded-circle mr-2" src="{{ Storage::url('uploads/' . $news->user->profile_photo_path) }}" width="25" height="25" alt="Author Photo">
                            @else
                                {{-- Placeholder jika tidak ada foto profil penulis --}}
                                <img class="rounded-circle mr-2" src="{{ asset('img/user.jpg') }}" width="25" height="25" alt="Default User Photo">
                            @endif
                            <span>{{ $news->user->name ?? 'Unknown' }}</span>
                        </div>
                        {{-- Views dan Jumlah Komentar --}}
                        <div class="d-flex align-items-center">
                            <span class="ml-3"><i class="far fa-eye mr-2"></i>{{ $news->views ?? 0 }}</span>
                            {{-- Icon Komentar yang BISA DIKLIK --}}
                            <a href="#comments-section" class="ml-3 text-decoration-none text-muted">
                                <i class="far fa-comments mr-2"></i><span id="comments-count">{{ $comments->count() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Daftar Komentar (Target untuk anchor link) --}}
            <div id="comments-section" class="mb-3">
                <div class="section-title mb-0">
                    {{-- Header komentar yang akan diperbarui oleh JavaScript --}}
                    <h4 class="m-0 text-uppercase font-weight-bold"><span id="comments-total-count">{{ $comments->count() }}</span> Comments</h4>
                </div>
                <div class="bg-white border border-top-0 p-4">
                    <div id="comments-list"> {{-- ID ini penting untuk AJAX: tempat komentar baru ditambahkan --}}
                        @forelse ($comments as $comment)
                            <div class="media mb-4">
                                {{-- Foto profil komentator --}}
                                <img src="{{ $comment->user && $comment->user->profile_photo_path ? Storage::url('uploads/' . $comment->user->profile_photo_path) : asset('img/user.jpg') }}" alt="User Photo" class="img-fluid rounded-circle mr-3 mt-1" style="width: 45px; height: 45px;">
                                <div class="media-body">
                                    <h6>
                                        <a class="text-secondary font-weight-bold" href="#">{{ $comment->user->name ?? 'Anonymous' }}</a>
                                        <small><i>{{ $comment->commented_at->diffForHumans() }}</i></small>
                                    </h6>
                                    <p>{{ $comment->comment_text }}</p>
                                </div>
                            </div>
                        @empty
                            <p id="no-comments-message" class="text-center">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Bagian Form Komentar --}}
            <div class="mb-3">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold">Leave a Comment</h4>
                </div>
                <div class="bg-white border border-top-0 p-4">
                    {{-- Feedback umum dari controller (jika tidak via AJAX) --}}
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Mohon perbaiki kesalahan berikut:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    {{-- Kontainer untuk pesan feedback AJAX (sukses/error) --}}
                    <div id="ajax-feedback-message" class="mt-3"></div>

                    @auth {{-- Tampilkan form jika user sudah login --}}
                    <form id="comment-form" action="{{ route('comment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="news_id" value="{{ $news->news_id }}">

                        <div class="form-group">
                            <label for="comment_text">Komentar *</label>
                            <textarea id="comment_text" name="comment_text" cols="30" rows="5"
                                class="form-control" required>{{ old('comment_text') }}</textarea>
                            <div id="comment-text-error" class="text-danger mt-1"></div> {{-- Untuk pesan error validasi AJAX --}}
                        </div>
                        <div class="form-group mb-0">
                            <input type="submit" value="Kirim Komentar" class="btn btn-primary font-weight-semi-bold py-2 px-3">
                        </div>
                    </form>
                    @else {{-- Tampilkan pesan jika user belum login --}}
                    <p>Anda harus <a href="{{ route('login') }}">masuk</a> untuk meninggalkan komentar.</p>
                    @endauth
                </div>
            </div>

        </div> {{-- Penutup col-lg-8 --}}

        <div class="col-lg-4">
            {{-- Sidebar --}}
            {{-- Pastikan ini mengarah ke file sidebar yang benar, contoh: frontend.partials.sidebar --}}
            @include('frontend.partials.sidebar', [
                'categories' => $categories,
                'popularNews' => $popularNews,
                'flickrPhotos' => $flickrPhotos
            ])
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Sertakan jQuery jika belum di load di frontend.app (biasanya di bagian <head> atau sebelum </body>) --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
    $(document).ready(function() {
        // Scroll ke bagian komentar dan fokus pada textarea jika hash '#comments-section' ada di URL
        if (window.location.hash === '#comments-section') {
            const commentsSection = document.getElementById('comments-section');
            if (commentsSection) {
                const offset = 80; // Sesuaikan untuk tinggi header tetap Anda jika ada
                const elementPosition = commentsSection.getBoundingClientRect().top + window.pageYOffset;
                window.scrollTo({
                    top: elementPosition - offset,
                    behavior: 'smooth'
                });

                const commentTextarea = document.getElementById('comment_text');
                if (commentTextarea) {
                    commentTextarea.focus();
                }
            }
        }

        // Pengiriman Form Komentar dengan AJAX
        $('#comment-form').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form default

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize(); // Mengambil semua data form
            var commentTextarea = $('#comment_text');
            var commentTextError = $('#comment-text-error');
            var ajaxFeedbackMessage = $('#ajax-feedback-message'); // Untuk feedback AJAX (sukses/error)
            var commentsTotalCount = $('#comments-total-count'); // Untuk jumlah komentar di header
            var commentsCountIcon = $('#comments-count'); // Untuk jumlah komentar di ikon
            var noCommentsMessage = $('#no-comments-message'); // Pesan "No comments yet"

            // Reset pesan error dan feedback
            commentTextError.text('');
            ajaxFeedbackMessage.html('');
            commentTextarea.removeClass('is-invalid'); // Hapus class is-invalid

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Penting untuk Laravel
                },
                success: function(response) {
                    if (response.success) {
                        // Buat HTML untuk komentar baru
                        var newCommentHtml = `
                           
                        `;
                        $('#comments-list').prepend(newCommentHtml); // Tambahkan ke bagian paling atas daftar komentar

                        // Bersihkan textarea
                        commentTextarea.val('');

                        // Perbarui jumlah komentar
                        var currentCount = parseInt(commentsTotalCount.text());
                        commentsTotalCount.text(currentCount + 1);
                        commentsCountIcon.text(currentCount + 1);

                        // Hapus pesan "Belum ada komentar" jika ada
                        if (noCommentsMessage.length) {
                            noCommentsMessage.remove();
                        }

                        // Tampilkan pesan sukses
                        ajaxFeedbackMessage.html('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        // Tampilkan pesan error umum
                        ajaxFeedbackMessage.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON;
                    if (errors && errors.errors) {
                        // Tampilkan error validasi dari backend
                        if (errors.errors.comment_text) {
                            commentTextError.text(errors.errors.comment_text[0]);
                            commentTextarea.addClass('is-invalid'); // Tambah class is-invalid untuk styling
                        }
                        // Jika ada error lain, bisa ditampilkan juga di sini
                        // Misalnya: if (errors.errors.news_id) { ... }
                    } else if (errors && errors.message) {
                        // Tampilkan pesan error umum dari backend (misalnya, user belum login)
                        ajaxFeedbackMessage.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + errors.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        // Error tidak diketahui
                        ajaxFeedbackMessage.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Terjadi kesalahan tak terduga. Silakan coba lagi.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                }
            });
        });
    });
</script>
@endpush