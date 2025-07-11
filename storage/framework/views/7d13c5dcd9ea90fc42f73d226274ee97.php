



<div class="mb-3">
    <h5 class="mb-4 text-uppercase font-weight-bold">Popular News</h5>
    <?php if(isset($popularNews) && $popularNews->count() > 0): ?> 
        <?php $__currentLoopData = $popularNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-3">
                <div class="mb-2">
                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                       href="<?php echo e(route('category.news', $newsItem->category->category_id ?? '')); ?>">
                       <?php echo e($newsItem->category->category_name ?? 'Uncategorized'); ?>

                    </a>
                    <a class="text-body" href="<?php echo e(route('news.single', $newsItem->news_id)); ?>">
                       <small><?php echo e(\Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y')); ?></small>
                    </a>
                </div>
                <a class="small text-body text-uppercase font-weight-medium" href="<?php echo e(route('news.single', $newsItem->news_id)); ?>">
                    <?php echo e(Str::limit($newsItem->title, 50)); ?>

                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <p>No popular news available.</p>
    <?php endif; ?>
</div>

<div class="mb-3">
    <h5 class="mb-4 text-uppercase font-weight-bold">Categories</h5>
    <div class="m-n1">
        <?php if(isset($categories) && $categories->count() > 0): ?> 
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <a href="<?php echo e(route('category.news', $category->category_id)); ?>" class="btn btn-sm btn-secondary m-1">
                    <?php echo e($category->category_name); ?> (<?php echo e($category->news_count); ?>)
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p>No categories available.</p>
        <?php endif; ?>
    </div>
</div>

<div class="mb-3">
    <h5 class="mb-4 text-uppercase font-weight-bold">Flickr Photos</h5>
    <div class="row">
        <?php if(isset($flickrPhotos) && $flickrPhotos->count() > 0): ?> 
            <?php $__currentLoopData = $flickrPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-4 mb-3">
                    
                    <a href="<?php echo e(Storage::url($media->file_path)); ?>" target="_blank">
                        <img class="w-100" src="<?php echo e(Storage::url($media->file_path)); ?>" alt="<?php echo e($media->news->title ?? 'Media'); ?>">
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p>No flickr photos available.</p>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\laragon\www\Berita02\resources\views/frontend/sidebar.blade.php ENDPATH**/ ?>