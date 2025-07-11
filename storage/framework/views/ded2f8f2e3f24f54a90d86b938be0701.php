

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title-1">Show Category</h2>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Name:</strong> <?php echo e($category->category_name); ?></p>
                                <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('content/layouts/main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/categories/show.blade.php ENDPATH**/ ?>