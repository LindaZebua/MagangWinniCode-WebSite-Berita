 

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Data Media</h2>
                        <a href="<?php echo e(route('media.create')); ?>" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Media
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="row m-t-30">
                <div class="col-md-12">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>File Path</th>
                                    <th>File Type</th>
                                    <th>Berita</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                                    <tr>
                                        <td><?php echo e($item->media_id); ?></td>
                                        <td><a href="<?php echo e(asset('storage/' . $item->file_path)); ?>" target="_blank"><?php echo e($item->file_path); ?></a></td>
                                        <td><?php echo e($item->file_type); ?></td>
                                        <td><?php echo e($item->news->title ?? '-'); ?></td>
                                        <td><?php echo e($item->created_at); ?></td>
                                        <td>
                                            <form action="<?php echo e(route('media.destroy', $item->media_id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus media ini?')">
                                                <a href="<?php echo e(route('media.show', $item->media_id)); ?>" class="btn btn-sm btn-info">Lihat</a>
                                                <a href="<?php echo e(route('media.edit', $item->media_id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data media.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php echo e($media->links()); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('content.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/media/index.blade.php ENDPATH**/ ?>