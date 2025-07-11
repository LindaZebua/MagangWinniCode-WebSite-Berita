
<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
        <h1 class="h3 mb-2 text-gray-800" > From Tambah User</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="col-form-label">Nama</label>
                    <input value="<?php echo e($user->name); ?>" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label class="col-form-label">Email</label>
                    <input value="<?php echo e($user->email); ?>" class="form-control" readonly>
                </div>

                <a href="<?php echo e(route('dashboard.index')); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
        </div>
        </div>
        </div>
        
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('content/layouts/main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/profile.blade.php ENDPATH**/ ?>