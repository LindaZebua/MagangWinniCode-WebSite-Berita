

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Data Pengguna</h2>
                        <a href="<?php echo e(route('users.create')); ?>" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Pengguna</a>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">

                    <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('Nama')); ?></th>
                                <th><?php echo e(__('Username')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Nama Lengkap')); ?></th>
                                <th><?php echo e(__('Role')); ?></th>
                                <th><?php echo e(__('Aksi')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->username); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->nama_lengkap); ?></td>
                                <td><?php echo e(ucfirst($user->role)); ?></td>
                                <td class="d-flex gap-1">
                                    
                                    <a href="<?php echo e(route('users.show', $user->id)); ?>" class="btn btn-sm btn-info"><?php echo e(__('Lihat')); ?></a>
                                    <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm btn-warning"><?php echo e(__('Edit')); ?></a>

                                    <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                            <?php echo e(__('Hapus')); ?>

                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center"><?php echo e(__('Tidak ada pengguna.')); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('content/layouts/main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/users/index.blade.php ENDPATH**/ ?>