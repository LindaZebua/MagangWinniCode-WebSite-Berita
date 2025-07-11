

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Show News</strong>
                        </div>
                        <div class="card-body">
                            <h2><?php echo e($news->title); ?></h2>
                            <?php if($news->gambar_berita): ?>
                                <div class="mb-3">
                                    <img src="<?php echo e(asset('storage/uploads/' . $news->gambar_berita)); ?>" alt="<?php echo e($news->title); ?>" class="img-fluid">
                                </div>
                            <?php endif; ?>
                            <p><?php echo e($news->content); ?></p>
                            <p>Published At: <?php echo e($news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('Y-m-d H:i:s') : '-'); ?></p>
                            <p>Category: <?php echo e($news->category->category_name); ?></p>
                            <p>Author: <?php echo e($news->user->name); ?></p>
                            <div class="mt-3">
                                <a href="<?php echo e(route('news.edit', $news->news_id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form action="<?php echo e(route('news.destroy', $news->news_id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this news?')">Delete</button>
                                </form>
                                <a href="<?php echo e(route('news.index')); ?>" class="btn btn-secondary btn-sm ml-2">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('content/layouts/main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/news/show.blade.php ENDPATH**/ ?>