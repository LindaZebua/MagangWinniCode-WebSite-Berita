

<?php $__env->startSection('content'); ?>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Overview Dashboard</h2> 
                        
                        <button class="au-btn au-btn-icon au-btn--blue">
                            <i class="zmdi zmdi-plus"></i>Add Item
                        </button>
                    </div>
                </div>
            </div>

            
            <div class="row m-t-25">
                
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-file-text"></i>
                                </div>
                                <div class="text">
                                    <h2><?php echo e($newsCount); ?></h2>
                                    <span>Total Berita</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-label"></i>
                                </div>
                                <div class="text">
                                    <h2><?php echo e($categoriesCount); ?></h2>
                                    <span>Total Kategori</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c3">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-accounts"></i>
                                </div>
                                <div class="text">
                                    <h2><?php echo e($usersCount); ?></h2>
                                    <span>Total Pengguna</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c4">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-comment-text"></i>
                                </div>
                                <div class="text">
                                    <h2><?php echo e($commentsCount); ?></h2>
                                    <span>Total Komentar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-6 col-lg-3 mt-4"> 
                    <div class="overview-item overview-item--c1"> 
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-image"></i>
                                </div>
                                <div class="text">
                                    <h2><?php echo e($mediaCount); ?></h2>
                                    <span>Total Media</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 


           <div class="row m-t-30">
    <div class="col-lg-12">
        <h2 class="title-1 m-b-25">Daftar Pengguna</h2>
        <div class="table-responsive table--no-card m-b-40">
            <table class="table table-borderless table-striped table-earning">
                <thead>
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
                        <td><?php echo e($user->role); ?></td>
                        <td>
                            <div class="table-data-feature">
                                
                                <a href="<?php echo e(route('users.show', $user->username)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="zmdi zmdi-eye"></i>
                                </a>
                                
                                <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                
                                <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data pengguna.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

            
            <div class="row m-t-30"> 
                
                <div class="col-lg-4"> 
                    <h2 class="title-1 m-b-25">Kategori</h2>
                    <div class="au-card au-card--bg-blue au-card-top-countries m-b-40">
                        <div class="au-card-inner">
                            <div class="table-responsive">
                                <table class="table table-top-countries">
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($category->category_name); ?></td>
                                            
                                            <td class="text-right">
                                                <?php if(isset($category->some_value_field) && $category->some_value_field != 0): ?>
                                                    <?php echo e(number_format($category->some_value_field, 2)); ?>

                                                <?php else: ?>
                                                    0.00 
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="2">Tidak ada kategori ditemukan.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 

                
                <div class="col-lg-4"> 
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                        <div class="au-card-title" style="background-image:url"> 
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-image"></i>Data Media
                            </h3>
                            
                            <a href="<?php echo e(route('media.create')); ?>" class="au-btn-plus">
                                <i class="zmdi zmdi-plus"></i>
                            </a>
                        </div>
                        <div class="au-task js-list-load">
                            <div class="au-task__title">
                                <p>Total Media: <?php echo e($mediaCount ?? 0); ?></p>
                            </div>
                            <div class="au-task-list js-scrollbar3">
                                <?php $__empty_1 = true; $__currentLoopData = $media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="au-task__item au-task__item--primary">
                                        <div class="au-task__item-inner">
                                            <h5 class="task">
                                                <a href="<?php echo e(Storage::url($item->file_path)); ?>" target="_blank">
                                                    <?php echo e(basename($item->file_path)); ?>

                                                </a>
                                            </h5>
                                            <span class="time">
                                                Tipe: <?php echo e($item->file_type); ?>

                                                <?php if($item->news): ?>
                                                    <br> Berita: <?php echo e($item->news->title); ?>

                                                <?php endif; ?>
                                                <br> Diunggah: <?php echo e($item->created_at->format('d M Y, H:i')); ?>

                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="au-task__item">
                                        <div class="au-task__item-inner">
                                            <h5 class="task">Tidak ada data media yang ditemukan.</h5>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            
                        </div>
                    </div>
                </div> 

                
                <div class="col-lg-4"> 
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                        <div class="au-card-title" style="background-image:url"> 
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-rss"></i>Berita Terbaru
                            </h3>
                            <a href="<?php echo e(route('news.create')); ?>" class="au-btn-plus">
                                <i class="zmdi zmdi-plus"></i>
                            </a>
                        </div>
                        <div class="au-inbox-wrap js-inbox-wrap">
                            <div class="au-message js-list-load">
                                <div class="au-message__noti">
                                    <p>Anda memiliki
                                        <span><?php echo e($newsCount); ?></span>
                                        artikel berita total
                                    </p>
                                </div>
                                <div class="au-message-list">
                                    <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="au-message__item <?php echo e($item->created_at->diffInDays(now()) < 1 ? 'unread' : ''); ?>">
                                            <div class="au-message__item-inner">
                                                <div class="au-message__item-text">
                                                    <div class="avatar-wrap">
                                                        <div class="avatar">
                                                            <?php if($item->gambar_berita): ?>
                                                                <img src="<?php echo e(asset('storage/uploads/' . $item->gambar_berita)); ?>" alt="<?php echo e($item->title); ?>">
                                                            <?php else: ?>
                                                                <img src="<?php echo e(asset('images/default-news-avatar.jpg')); ?>" alt="Default News Image">
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="text">
                                                        <h5 class="name"><?php echo e($item->title); ?></h5>
                                                        <p><?php echo e(\Illuminate\Support\Str::limit(strip_tags($item->content), 80, '...')); ?></p>
                                                    </div>
                                                </div>
                                                <div class="au-message__item-time">
                                                    <span><?php echo e($item->published_at ? $item->published_at->diffForHumans() : 'Belum dipublikasikan'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="au-message__item">
                                            <div class="au-message__item-inner">
                                                <div class="text">
                                                    <p>Tidak ada berita tersedia.</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="au-message__footer">
                                    <?php echo e($news->links('pagination::bootstrap-4')); ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

            </div> 

        </div> 
    </div> 
</div> 

<?php $__env->stopSection(); ?>
<?php echo $__env->make('content.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Berita02\resources\views/content/dashboard/index.blade.php ENDPATH**/ ?>