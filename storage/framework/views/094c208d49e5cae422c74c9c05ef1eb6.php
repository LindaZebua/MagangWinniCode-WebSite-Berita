

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Data Berita</h2>
                        <a href="<?php echo e(route('news.create')); ?>" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Berita</a>
                    </div>
                </div>
            </div>
            
            <div class="row m-t-30">
                <div class="col-md-12">
                    <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                    <?php endif; ?>

                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Tanggal Publikasi</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Image</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($newsItem->title); ?></td>
                                    <td><?php echo e(Str::limit($newsItem->content, 100)); ?></td>
                                    <td><?php echo e($newsItem->published_at); ?></td>
                                    <td><?php echo e($newsItem->category->category_name); ?></td>
                                    <td><?php echo e($newsItem->user->name); ?></td>
                                    <td>
                                        <?php if($newsItem->gambar_berita): ?> 
                                        <img src="<?php echo e(asset('storage/uploads/' . $newsItem->gambar_berita)); ?>" alt="<?php echo e($newsItem->title); ?>" width="100"> 
                                        <?php else: ?>
                                        Tidak ada gambar
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="table-data-feature">
                                            <a href="<?php echo e(route('news.show', $newsItem->news_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Lihat">
                                                <i class="zmdi zmdi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('news.edit', $newsItem->news_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('news.destroy', $newsItem->news_id)); ?>" method="POST" style="display: inline-block;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Apakah Anda yakin?')">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data berita.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('content.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/news/index.blade.php ENDPATH**/ ?>