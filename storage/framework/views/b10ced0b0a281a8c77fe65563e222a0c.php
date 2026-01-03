
<?php use Illuminate\Support\Str; ?>

<?php $__env->startSection('content'); ?>
<div class="py-16 bg-gray-50 min-h-screen dark:bg-indigo-900">
    <div class="container mx-auto px-4">
        <!-- Header with Admin Controls -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4 dark:text-white">Our Bestselling Products</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8 dark:text-blue-200">Discover our most loved formulations, designed to address various skin concerns while maintaining your skin's natural barrier.</p>
            
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('products.create')); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 font-semibold">
                        <i class="ri-add-line text-lg"></i> Add New Product
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Search & Filter -->
        <div class="mb-8 bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <form action="<?php echo e(route('products.index', [], false)); ?>" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <input type="text" name="search" placeholder="Search products..." value="<?php echo e($search ?? ''); ?>" onchange="this.form.submit()"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category" onchange="this.form.submit()" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat); ?>" <?php if(($category ?? '') === $cat): echo 'selected'; endif; ?>><?php echo e($cat); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Skin Type Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Skin Type</label>
                        <select name="skin_type" onchange="this.form.submit()" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                            <option value="">All Skin Types</option>
                            <?php $__currentLoopData = $skinTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type); ?>" <?php if(($skinType ?? '') === $type): echo 'selected'; endif; ?>><?php echo e(ucfirst($type)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Clear Button -->
                <div class="flex justify-center">
                    <a href="<?php echo e(route('products.index', [], false)); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 dark:bg-slate-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-all duration-200 font-semibold">
                        Clear All
                    </a>
                </div>

                <!-- Active Filters Display -->
                <?php if($search || $category || $skinType): ?>
                    <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Active Filters:</span>
                        <?php if($search): ?>
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm">
                                Search: "<?php echo e($search); ?>"
                            </span>
                        <?php endif; ?>
                        <?php if($category): ?>
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm">
                                Category: <?php echo e($category); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($skinType): ?>
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-sm">
                                Skin Type: <?php echo e(ucfirst($skinType)); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-4 text-gray-600 dark:text-blue-200">
            <p>Showing <span class="font-semibold"><?php echo e($products->firstItem() ?? 0); ?></span> to <span class="font-semibold"><?php echo e($products->lastItem() ?? 0); ?></span> of <span class="font-semibold"><?php echo e($products->total()); ?></span> products</p>
        </div>

        <!-- Products Grid - Matches Dashboard Styling -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-12">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-indigo-900 dark:to-indigo-800 dark:border dark:border-indigo-800">
                    <a href="<?php echo e(route('products.show', $product, false)); ?>" class="block cursor-pointer">
                        <div class="h-64 overflow-hidden bg-gray-200 flex items-center justify-center">
                            <?php
                                $primaryImage = $product->getPrimaryImage();
                            ?>
                            <?php if($primaryImage): ?>
                                <img src="<?php echo e($primaryImage); ?>" alt="<?php echo e($product->name); ?>"
                                    class="w-full h-full object-cover object-top">
                            <?php else: ?>
                                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <svg class="w-20 h-20 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm">No image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full font-semibold dark:bg-blue-900 dark:text-blue-200"><?php echo e($product->category ?? 'Featured'); ?></span>
                                <div class="flex">
                                    <?php $rating = round($product->rating ?? 4.5); ?>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= $rating): ?>
                                            <i class="ri-star-fill text-yellow-400"></i>
                                        <?php else: ?>
                                            <i class="ri-star-line text-yellow-400"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 dark:text-white"><?php echo e($product->name); ?></h3>
                            <p class="text-gray-600 text-sm mb-4 dark:text-blue-200"><?php echo e(Str::limit(strip_tags($product->description), 60)); ?></p>
                        </div>
                    </a>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <div class="px-6 pb-6 flex gap-2 border-t pt-4">
                                <a href="<?php echo e(route('products.edit', $product, false)); ?>" class="flex-1 px-3 py-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 text-center text-sm font-medium transition" onclick="event.stopPropagation();">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <form action="<?php echo e(route('products.destroy', $product, false)); ?>" method="POST" class="flex-1" onsubmit="event.stopPropagation(); return confirm('Delete this product?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 text-sm font-medium transition">
                                        <i class="ri-delete-bin-line"></i> Delete
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-16">
                    <i class="ri-inbox-line text-6xl text-gray-300 mb-4 dark:text-blue-300"></i>
                    <p class="text-gray-500 text-lg dark:text-blue-200">No products found. Please try another search.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if($products->count() > 0): ?>
            <div class="flex justify-center">
                <?php echo e($products->links('pagination::tailwind')); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/products/index.blade.php ENDPATH**/ ?>