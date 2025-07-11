

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Daftar Komentar</h2>
                        <a href="<?php echo e(route('comments.create')); ?>" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Komentar
                        </a>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                    <div class="table-responsive table--no-card m-b-25">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Teks Komentar</th>
                                    <th>Berita</th>
                                    <th>Pengguna</th>
                                    <th>Tanggal Komentar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($comment->comment_id); ?></td>
                                    <td><?php echo e(Str::limit($comment->comment_text, 100)); ?></td> 
                                    <td><?php echo e($comment->news->title ?? 'Berita Tidak Ditemukan'); ?></td> 
                                    <td><?php echo e($comment->user->name ?? 'Pengguna Tidak Dikenal'); ?></td> 
                                    <td><?php echo e(\Carbon\Carbon::parse($comment->commented_at)->format('d M Y, H:i')); ?></td> 
                                    <td>
                                        <a href="<?php echo e(route('comments.edit', $comment->comment_id)); ?>"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="<?php echo e(route('comments.destroy', $comment->comment_id)); ?>" method="POST"
                                            style="display: inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada komentar yang tersedia.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <?php echo e($comments->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('content.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/comments/index.blade.php ENDPATH**/ ?>