

<?php $__env->startSection('content'); ?>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            
                            <h4 class="m-0 text-uppercase font-weight-bold">Category: <?php echo e($category->category_name ?? 'Unknown Category'); ?></h4>
                        </div>
                    </div>
                    <?php $__empty_1 = true; $__currentLoopData = $newsByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-lg-6">
                            <div class="position-relative mb-3">
                                <img class="img-fluid w-100" src="<?php echo e(Storage::url('uploads/' . $newsItem->gambar_berita)); ?>" style="object-fit: cover;">
                                <div class="overlay position-relative bg-white px-3 d-flex flex-column justify-content-center" style="height: 80px;">
                                    <div class="mb-2">
                                        
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                           href="<?php echo e(route('categories.show', $newsItem->category->category_id ?? '')); ?>">
                                           <?php echo e($newsItem->category->category_name ?? 'Uncategorized'); ?>

                                        </a>
                                        
                                        <a class="text-body" href="<?php echo e(route('news.show', $newsItem->news_id)); ?>">
                                            <small><?php echo e(\Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y')); ?></small>
                                        </a>
                                    </div>
                                    
                                    <a class="h6 m-0 text-uppercase font-weight-bold" href="<?php echo e(route('news.show', $newsItem->news_id)); ?>"><?php echo e(Str::limit($newsItem->title, 70)); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12">
                            <p>No news found for this category.</p>
                        </div>
                    <?php endif; ?>
                    <div class="col-12">
                        
                        <?php echo e($newsByCategory->links()); ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <?php echo $__env->make('frontend.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/frontend/category.blade.php ENDPATH**/ ?>