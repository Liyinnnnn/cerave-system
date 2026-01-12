

<?php $__env->startSection('content'); ?>

<!-- Product Section Navigation (combined navbar) -->
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40 dark:bg-slate-900 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-3 text-sm py-3 text-gray-800 dark:text-gray-200">
            <a href="<?php echo e(route('products.index')); ?>" class="text-gray-700 hover:text-blue-700 font-semibold dark:text-gray-200 dark:hover:text-blue-300">All Products</a>
            <span class="text-gray-500 dark:text-gray-400">&gt;</span>
            <span class="text-gray-900 font-semibold dark:text-gray-100"><?php echo e(Str::limit($product->name, 30)); ?></span>
            <span class="mx-3 text-gray-400">|</span>
            <a href="#overview" data-nav-section="overview" class="border-b-2 border-transparent text-gray-700 hover:text-gray-900 hover:border-gray-300 transition-colors duration-200 dark:text-gray-200 dark:hover:text-white dark:hover:border-blue-400">Overview</a>
            <a href="#reviews" data-nav-section="reviews" class="border-b-2 border-transparent text-gray-700 hover:text-gray-900 hover:border-gray-300 transition-colors duration-200 dark:text-gray-200 dark:hover:text-white dark:hover:border-blue-400">Reviews</a>
        </nav>
    </div>
</div>

<div id="overview" class="py-12 bg-gradient-to-b from-blue-50 via-blue-100 to-blue-200 dark:from-indigo-900 dark:via-indigo-900 dark:to-indigo-900" data-section="overview">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Product Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Image Gallery -->
            <div class="flex flex-col justify-start">
                <?php
                    $images = $product->getAllImages();
                ?>
                
                <?php if(count($images) > 0): ?>
                    <div class="space-y-4">
                        <div id="mainImage" class="aspect-square bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                            <img src="<?php echo e($images[0]); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-contain">
                        </div>
                        
                        <?php if(count($images) > 1): ?>
                            <div class="grid grid-cols-6 gap-2">
                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button onclick="changeImage('<?php echo e($image); ?>')" class="aspect-square overflow-hidden rounded-lg border-2 border-gray-200 hover:border-blue-400 transition bg-white p-2">
                                        <img src="<?php echo e($image); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-contain">
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center rounded-2xl border border-gray-200">
                        <span class="text-gray-400">No image available</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div class="space-y-6 bg-white rounded-2xl shadow-lg p-8 border border-gray-100 dark:bg-indigo-900 dark:border-indigo-800 dark:text-blue-50">
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 text-xs font-bold uppercase tracking-wide rounded-full dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <?php echo e($product->category); ?>

                    </span>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mt-4 leading-tight dark:text-blue-50"><?php echo e($product->name); ?></h1>
                    
                    <?php if($averageRating): ?>
                        <div class="flex items-center gap-3 mt-4">
                            <div class="flex text-amber-400 gap-1">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <svg class="w-5 h-5 <?php echo e($i <= $averageRating ? 'fill-current' : 'fill-gray-300'); ?>" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-lg font-semibold text-gray-900 dark:text-blue-50"><?php echo e(number_format($averageRating, 1)); ?>/5</span>
                            <span class="text-sm text-gray-600 dark:text-blue-200">(<?php echo e($reviewCount); ?> <?php echo e($reviewCount === 1 ? 'review' : 'reviews'); ?>)</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if($product->skin_type): ?>
                    <div class="pt-4 border-t border-gray-200 dark:border-blue-800">
                        <p class="text-gray-600 dark:text-blue-200">Best for <span class="font-semibold text-gray-900 dark:text-blue-50"><?php echo e(ucfirst($product->skin_type)); ?> Skin</span></p>
                    </div>
                <?php endif; ?>
                
                <?php if($product->description): ?>
                    <div class="prose prose-sm max-w-none text-gray-700 dark:text-slate-200">
                        <?php echo $product->description; ?>

                    </div>
                <?php endif; ?>
                
                <!-- Buy Online Section -->
                <?php
                    $externalUrls = $product->getAllExternalUrls();
                    $retailerNames = $product->retailer_names ?? [];
                ?>
                
                <?php if($externalUrls): ?>
                    <div class="pt-6 border-t border-gray-200 dark:border-blue-800">
                        <p class="text-sm font-semibold text-gray-700 mb-4 dark:text-gray-200">Buy Online at:</p>
                        <div class="flex flex-wrap gap-4">
                            <?php $__currentLoopData = $externalUrls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $retailer = strtolower($retailerNames[$index] ?? '');
                                    $retailerLogos = $product->getRetailerLogos();
                                    $logo = $retailerLogos[$index] ?? '';
                                ?>
                                <a href="<?php echo e($url); ?>" target="_blank" rel="noopener noreferrer" 
                                   class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-gray-300 hover:shadow-md transition-all group dark:bg-indigo-900 dark:border-blue-800 dark:hover:border-blue-600 dark:text-blue-100">
                                    <?php if($logo): ?>
                                        <img src="<?php echo e($logo); ?>" alt="<?php echo e(ucfirst($retailer)); ?>" class="h-6 object-contain group-hover:scale-105 transition">
                                    <?php else: ?>
                                        <span class="font-semibold text-gray-700 dark:text-gray-200"><?php echo e(ucfirst($retailer)); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Admin Controls -->
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <div class="pt-6 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-3">Admin Actions:</p>
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('products.edit', $product)); ?>" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-100 transition text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="<?php echo e(route('products.destroy', $product)); ?>" method="POST" onsubmit="return confirm('Delete this product?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Details Accordion -->
        <div class="space-y-3 mb-16">
            <?php if($product->ingredients): ?>
                <details class="group bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow dark:bg-indigo-900 dark:border-indigo-800">
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-bold text-gray-900 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent transition-all dark:text-blue-50 dark:hover:from-blue-800/40">
                        <span class="tracking-wide">INGREDIENTS</span>
                        <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 text-gray-700 prose prose-sm max-w-none dark:text-blue-200">
                        <?php echo $product->ingredients; ?>

                    </div>
                </details>
            <?php endif; ?>
            
            <?php if($product->benefits || ($product->features && count($product->features) > 0)): ?>
                <details class="group bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow dark:bg-indigo-900 dark:border-indigo-800" open>
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-bold text-gray-900 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent transition-all dark:text-blue-50 dark:hover:from-blue-800/40">
                        <span class="tracking-wide">BENEFITS & FEATURES</span>
                        <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 space-y-6">
                        <?php if($product->benefits): ?>
                            <div class="prose prose-sm max-w-none text-gray-700 dark:text-blue-200">
                                <?php echo $product->benefits; ?>

                            </div>
                        <?php endif; ?>
                        
                        <!-- Admin-Added Feature Cards with Images -->
                        <?php if($product->features && is_array($product->features) && count($product->features) > 0): ?>
                            <div class="mt-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-6 dark:text-blue-50">Key Features</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <?php $__currentLoopData = $product->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($feature['image']) || isset($feature['text'])): ?>
                                            <div class="bg-gradient-to-br from-blue-50/30 to-indigo-50/30 border border-blue-200/50 rounded-2xl overflow-hidden hover:shadow-xl hover:border-blue-300 transition-all duration-300 group dark:from-blue-900/60 dark:to-indigo-900/60 dark:border-blue-800">
                                                <?php if(isset($feature['image']) && !empty($feature['image'])): ?>
                                                    <?php
                                                        $imagePath = $feature['image'];
                                                        if (!str_starts_with($imagePath, 'http') && !str_starts_with($imagePath, '/')) {
                                                            $imagePath = '/images/' . $imagePath;
                                                        }
                                                    ?>
                                                    <div class="aspect-video bg-white overflow-hidden flex items-center justify-center dark:bg-indigo-900">
                                                        <img src="<?php echo e($imagePath); ?>" alt="Feature" class="w-full h-full object-contain p-6 group-hover:scale-110 transition-transform duration-300">
                                                    </div>
                                                <?php endif; ?>
                                                <?php if(isset($feature['text']) && !empty($feature['text'])): ?>
                                                    <div class="p-5 bg-white/60 backdrop-blur-sm dark:bg-transparent">
                                                        <div class="text-gray-800 font-medium text-sm leading-relaxed dark:text-blue-50"><?php echo $feature['text']; ?></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Fallback: Auto-generated feature boxes from benefits text -->
                            <?php
                                $benefitsList = array_filter(
                                    array_map(fn($item) => trim(strip_tags($item)), 
                                    preg_split('/<\/?li[^>]*>|•|[\r\n]+/', $product->benefits ?? '')),
                                    fn($item) => !empty($item) && strlen($item) > 10
                                );
                                $benefitsToShow = array_slice($benefitsList, 0, 3);
                            ?>
                            
                            <?php if(count($benefitsToShow) > 0): ?>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                                    <?php $__currentLoopData = $benefitsToShow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6 text-center hover:shadow-md transition dark:from-indigo-900 dark:to-indigo-800 dark:border-indigo-800">
                                            <p class="text-gray-900 font-semibold text-sm leading-relaxed dark:text-blue-50"><?php echo e($benefit); ?></p>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </details>
            <?php endif; ?>
            
            <?php if($product->directions): ?>
                <details class="group bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow dark:bg-indigo-900 dark:border-indigo-800">
                    <summary class="flex items-center justify-between cursor-pointer p-6 font-bold text-gray-900 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent transition-all dark:text-blue-50 dark:hover:from-blue-800/40">
                        <span class="tracking-wide">HOW TO USE</span>
                        <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 text-gray-700 prose prose-sm max-w-none dark:text-blue-200">
                        <?php echo $product->directions; ?>

                    </div>
                </details>
            <?php endif; ?>
        </div>

        <!-- Reviews Section -->
        <div id="reviews" data-section="reviews" class="border-t border-gray-200 pt-16">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white">Customer Reviews</h2>
                    <?php if($averageRating): ?>
                        <div class="flex items-center gap-3 mt-3">
                            <div class="flex text-amber-400 gap-1">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <svg class="w-6 h-6 <?php echo e($i <= $averageRating ? 'fill-current' : 'fill-gray-300'); ?>" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($averageRating, 1)); ?></span>
                            <span class="text-gray-600 dark:text-gray-300">out of 5 based on <?php echo e($reviewCount); ?> review<?php echo e($reviewCount === 1 ? '' : 's'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <!-- Write Review Form -->
            <?php if(auth()->guard()->check()): ?>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 mb-12 dark:bg-gradient-to-br dark:from-indigo-900 dark:to-indigo-800 dark:border-indigo-800">
                <h3 class="text-xl font-bold text-gray-900 mb-6 dark:text-white">Write a Review</h3>
                <form action="<?php echo e(route('reviews.store', $product)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-blue-200 mb-3">Your Rating *</label>
                            <div class="flex items-center gap-2" id="starRating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <button type="button" data-value="<?php echo e($i); ?>" class="p-1">
                                        <svg class="w-10 h-10 text-gray-300 hover:text-amber-400 transition cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </button>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="<?php echo e(old('rating')); ?>" required>
                            <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-blue-200 mb-3">Review Title *</label>
                            <input type="text" name="title" value="<?php echo e(old('title')); ?>" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-white dark:border-gray-300 dark:text-gray-800" required maxlength="100" placeholder="Sum up your experience">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-blue-200 mb-3">Your Review *</label>
                        <textarea name="content" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-white dark:border-gray-300 dark:text-gray-800" required maxlength="2000" placeholder="Tell us what you think about this product"><?php echo e(old('content')); ?></textarea>
                        <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-blue-200 mb-3">Attachments (Images/Videos)</label>
                        <input type="file" name="attachments[]" multiple accept="image/*,video/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-white dark:border-gray-300 dark:text-gray-800">
                        <p class="text-xs text-gray-500 dark:text-blue-300 mt-2">Upload images or videos to support your review (Max 50MB per file)</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 mb-12 text-center">
                <p class="text-gray-600">Please <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:underline font-semibold">sign in</a> to write a review</p>
            </div>
            <?php endif; ?>

            <!-- Reviews List -->
            <div class="space-y-6">
                <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white border-2 border-gray-100 rounded-2xl p-8 hover:border-blue-200 hover:shadow-xl transition-all duration-300 dark:bg-gradient-to-br dark:from-indigo-900 dark:to-indigo-800 dark:border-indigo-800 dark:hover:border-indigo-700" id="review-<?php echo e($review->id); ?>">
                        <!-- Review Header -->
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-start gap-4 flex-1">
                                <!-- User Avatar -->
                                <div class="flex-shrink-0">
                                    <?php
                                        $avatar = $review->user->profile_image_url ?? null;
                                    ?>
                                    <?php if($avatar): ?>
                                        <img src="<?php echo e($avatar); ?>" alt="avatar" class="w-12 h-12 rounded-full object-cover shadow-lg">
                                    <?php else: ?>
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                            <?php echo e(strtoupper(substr($review->user->nickname ?? $review->user->name ?? 'A', 0, 1))); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="flex gap-1">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <svg class="w-5 h-5 <?php echo e($i <= $review->rating ? 'text-amber-400' : 'text-gray-300'); ?> fill-current drop-shadow" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-500 dark:text-blue-200"><?php echo e($review->rating); ?>.0</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-1 dark:text-white"><?php echo e($review->title); ?></h3>
                                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-blue-200">
                                        <span class="font-semibold text-gray-900 dark:text-white"><?php echo e($review->user->nickname ?? $review->user->name ?? 'Anonymous'); ?></span>
                                        <span class="text-gray-400">•</span>
                                        <span class="dark:text-blue-300"><?php echo e($review->created_at->format('M d, Y')); ?></span>
                                        <?php if($review->verified_purchase): ?>
                                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-semibold">✓ Verified Purchase</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->isAdmin() || auth()->id() === $review->user_id): ?>
                                    <div class="flex gap-2 ml-4">
                                        <button onclick="toggleEditReview(<?php echo e($review->id); ?>)" class="flex items-center gap-1 text-sm px-3 py-1.5 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-200 font-semibold shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <form action="<?php echo e(route('reviews.destroy', $review)); ?>" method="POST" onsubmit="return confirm('Delete this review permanently?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="flex items-center gap-1 text-sm px-3 py-1.5 bg-gradient-to-r from-red-50 to-red-100 text-red-700 rounded-lg hover:from-red-100 hover:to-red-200 transition-all duration-200 font-semibold shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Review Content (View Mode) -->
                        <div id="review-content-<?php echo e($review->id); ?>">
                            <p class="text-gray-700 leading-relaxed mb-6 text-base dark:text-blue-200"><?php echo e($review->content); ?></p>

                            <!-- Review Attachments -->
                            <?php if($review->media && is_array($review->media) && count($review->media) > 0): ?>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    <?php $__currentLoopData = $review->media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $isVideo = \Illuminate\Support\Str::endsWith($media, ['.mp4', '.webm', '.mov', '.avi', '.m4v']);
                                        ?>
                                        <div class="rounded-xl overflow-hidden bg-gray-100 shadow-md hover:shadow-xl transition-shadow duration-300 group">
                                            <?php if($isVideo): ?>
                                                <video controls class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                                    <source src="<?php echo e($media); ?>" type="video/mp4">
                                                </video>
                                            <?php else: ?>
                                                <img src="<?php echo e($media); ?>" alt="review attachment" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300 cursor-pointer" onclick="openImageModal(this.src)">
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Review Edit Form (Initially Hidden) -->
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isAdmin() || auth()->id() === $review->user_id): ?>
                                <div id="review-edit-<?php echo e($review->id); ?>" class="hidden">
                                    <form action="<?php echo e(route('reviews.update', $review)); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                                                <div class="flex items-center gap-2" id="editStarRating-<?php echo e($review->id); ?>">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <button type="button" data-value="<?php echo e($i); ?>" class="p-1 edit-star-btn">
                                                            <svg class="w-8 h-8 <?php echo e($i <= $review->rating ? 'text-amber-400' : 'text-gray-300'); ?> hover:text-amber-400 transition cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                            </svg>
                                                        </button>
                                                    <?php endfor; ?>
                                                </div>
                                                <input type="hidden" name="rating" id="editRatingInput-<?php echo e($review->id); ?>" value="<?php echo e($review->rating); ?>" required>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Review Title</label>
                                                <input type="text" name="title" value="<?php echo e($review->title); ?>" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required maxlength="100">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Your Review</label>
                                            <textarea name="content" rows="4" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required maxlength="2000"><?php echo e($review->content); ?></textarea>
                                        </div>

                                        <div class="flex justify-end gap-3">
                                            <button type="button" onclick="toggleEditReview(<?php echo e($review->id); ?>)" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg">
                                                Update Review
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- Comments Section -->
                        <div id="comments" data-section="comments" class="mt-8 pt-6">
                            <div class="flex items-center gap-2 mb-6">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <h4 class="text-sm font-bold text-gray-700 dark:text-white">Comments (<?php echo e($review->comments->count()); ?>)</h4>
                            </div>
                            
                            <!-- Display Comments -->
                            <div class="space-y-4">
                                <?php $__currentLoopData = $review->comments()->whereNull('parent_id')->with(['children.user'])->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="comment-thread">
                                        <!-- Parent Comment -->
                                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-indigo-900 dark:to-indigo-800 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200 dark:border dark:border-indigo-800 <?php if(is_null($comment->user_id)): ?> opacity-75 <?php endif; ?>">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex items-center gap-3">
                                                    <?php
                                                        $cAvatar = $comment->user->profile_image_url ?? null;
                                                    ?>
                                                    <?php if($cAvatar): ?>
                                                        <img src="<?php echo e($cAvatar); ?>" alt="avatar" class="w-8 h-8 rounded-full object-cover shadow">
                                                    <?php else: ?>
                                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold text-xs shadow">
                                                            <?php echo e(strtoupper(substr($comment->user->nickname ?? $comment->user->name ?? 'A', 0, 1))); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="flex items-center gap-2">
                                                            <p class="text-sm font-bold text-gray-900 dark:text-white"><?php echo e($comment->user->nickname ?? $comment->user->name ?? 'Anonymous'); ?></p>
                                                            <?php if(is_null($comment->user_id)): ?>
                                                                <span class="text-xs px-2 py-0.5 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-full font-semibold">Deleted User</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="text-xs text-gray-500 dark:text-blue-300"><?php echo e($comment->created_at->diffForHumans()); ?></p>
                                                    </div>
                                                </div>
                                                <?php if(auth()->guard()->check()): ?>
                                                    <?php if(auth()->user()->isAdmin() || (!is_null($comment->user_id) && auth()->id() === $comment->user_id)): ?>
                                                        <form action="<?php echo e(route('comments.destroy', $comment)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this comment?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 hover:bg-red-50 dark:hover:bg-red-950 px-2 py-1 rounded transition">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-sm text-gray-700 dark:text-blue-200 leading-relaxed mb-3 pl-11"><?php echo e($comment->content); ?></p>
                                            <?php if(auth()->guard()->check()): ?>
                                                <button onclick="toggleReplyForm(<?php echo e($comment->id); ?>)" class="ml-11 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-bold flex items-center gap-1 hover:gap-2 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                    </svg>
                                                    Reply
                                                </button>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Reply Form (Initially Hidden) -->
                                        <?php if(auth()->guard()->check()): ?>
                                            <div id="reply-form-<?php echo e($comment->id); ?>" class="hidden mt-3 ml-12 animate-fadeIn">
                                                <form action="<?php echo e(route('comments.store', $review)); ?>" method="POST" class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-indigo-900 dark:to-indigo-800 rounded-xl p-4 shadow-sm border-2 border-blue-100 dark:border-indigo-800">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="parent_id" value="<?php echo e($comment->id); ?>">
                                                    <textarea name="content" rows="2" class="w-full px-3 py-2 text-sm border-2 border-blue-200 dark:border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white dark:bg-white dark:text-gray-800" placeholder="Write a reply..." required maxlength="1000"></textarea>
                                                    <div class="flex justify-end gap-2 mt-3">
                                                        <button type="button" onclick="toggleReplyForm(<?php echo e($comment->id); ?>)" class="text-xs px-4 py-2 bg-white dark:bg-white text-gray-700 dark:text-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-100 transition font-semibold border border-gray-200 dark:border-gray-300">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg text-sm">
                                                            Post Reply
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Child Comments (Replies) -->
                                        <?php if($comment->children->count() > 0): ?>
                                            <div class="ml-12 mt-3 space-y-3">
                                                <?php $__currentLoopData = $comment->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-indigo-900 dark:to-indigo-800 rounded-xl p-4 shadow-sm border-l-4 border-blue-400 dark:border-l-indigo-600 <?php if(is_null($reply->user_id)): ?> opacity-75 <?php endif; ?>">
                                                        <div class="flex items-start justify-between mb-2">
                                                            <div class="flex items-center gap-3">
                                                                <?php
                                                                    $rAvatar = $reply->user->profile_image_url ?? null;
                                                                ?>
                                                                <?php if($rAvatar): ?>
                                                                    <img src="<?php echo e($rAvatar); ?>" alt="avatar" class="w-7 h-7 rounded-full object-cover shadow">
                                                                <?php else: ?>
                                                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold text-xs shadow">
                                                                        <?php echo e(strtoupper(substr($reply->user->nickname ?? $reply->user->name ?? 'A', 0, 1))); ?>

                                                                    </div>
                                                                <?php endif; ?>
                                                                <div>
                                                                    <div class="flex items-center gap-2">
                                                                        <p class="text-sm font-bold text-gray-900 dark:text-white"><?php echo e($reply->user->nickname ?? $reply->user->name ?? 'Anonymous'); ?></p>
                                                                        <?php if(is_null($reply->user_id)): ?>
                                                                            <span class="text-xs px-2 py-0.5 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-full font-semibold">Deleted User</span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <p class="text-xs text-gray-500 dark:text-blue-300"><?php echo e($reply->created_at->diffForHumans()); ?></p>
                                                                </div>
                                                            </div>
                                                            <?php if(auth()->guard()->check()): ?>
                                                                <?php if(auth()->user()->isAdmin() || (!is_null($reply->user_id) && auth()->id() === $reply->user_id)): ?>
                                                                    <form action="<?php echo e(route('comments.destroy', $reply)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this reply?');">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('DELETE'); ?>
                                                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 hover:bg-red-100 dark:hover:bg-red-950 px-2 py-1 rounded transition">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="text-sm text-gray-700 dark:text-blue-200 leading-relaxed pl-10"><?php echo e($reply->content); ?></p>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Add Comment Form -->
                            <?php if(auth()->guard()->check()): ?>
                                <div class="mt-6">
                                    <form action="<?php echo e(route('comments.store', $review)); ?>" method="POST" class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-indigo-900 dark:to-indigo-800 rounded-xl p-5 shadow-sm border-2 border-gray-200 dark:border-indigo-800">
                                        <?php echo csrf_field(); ?>
                                        <div class="flex items-start gap-3">
                                            <?php
                                                $meAvatar = auth()->user()->profile_image_url ?? null;
                                            ?>
                                            <?php if($meAvatar): ?>
                                                <img src="<?php echo e($meAvatar); ?>" alt="avatar" class="w-10 h-10 rounded-full object-cover shadow-lg flex-shrink-0">
                                            <?php else: ?>
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-lg flex-shrink-0">
                                                    <?php echo e(strtoupper(substr(auth()->user()->nickname ?? auth()->user()->name, 0, 1))); ?>

                                                </div>
                                            <?php endif; ?>
                                            <div class="flex-1">
                                                <textarea name="content" rows="2" class="w-full px-4 py-3 text-sm border-2 border-gray-200 dark:border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white dark:bg-white dark:text-gray-800" placeholder="Add a comment..." required maxlength="1000"></textarea>
                                                <div class="flex justify-end mt-3">
                                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg text-sm">
                                                        Post Comment
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="mt-6 text-center p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-indigo-900 dark:to-indigo-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-indigo-800">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-blue-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 dark:text-blue-200">
                                        <a href="<?php echo e(route('login')); ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-bold hover:underline">Sign in</a> to join the conversation
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12 text-gray-500 dark:text-blue-300">
                        <p class="text-lg font-semibold">No reviews yet</p>
                        <p class="text-sm mt-1">Be the first to share your experience!</p>
                    </div>
                <?php endif; ?>

                <?php if($reviews->hasPages()): ?>
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <?php echo e($reviews->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Image gallery
function changeImage(imageUrl) {
    document.querySelector('#mainImage img').src = imageUrl;
}

// Star Rating System - Simple version that works
const starRating = document.getElementById('starRating');
const ratingInput = document.getElementById('ratingInput');

if (starRating && ratingInput) {
    const stars = starRating.querySelectorAll('button');
    
    function renderStars(val) {
        stars.forEach((btn, idx) => {
            const svg = btn.querySelector('svg');
            if (idx < val) {
                svg.classList.remove('text-gray-300');
                svg.classList.add('text-amber-400');
            } else {
                svg.classList.add('text-gray-300');
                svg.classList.remove('text-amber-400');
            }
        });
    }
    
    stars.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent form submission
            ratingInput.value = this.dataset.value;
            renderStars(parseInt(ratingInput.value));
            console.log('Rating set to:', ratingInput.value);
        });
    });
    
    // Initialize with old value if exists
    if (ratingInput.value) {
        renderStars(parseInt(ratingInput.value));
    }
}

// Debug: Log when form submits
const reviewForm = document.querySelector('form[action*="reviews"]');
if (reviewForm) {
    reviewForm.addEventListener('submit', function(e) {
        console.log('Form is submitting!');
        console.log('Rating:', ratingInput ? ratingInput.value : 'not found');
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);
        // Let it submit naturally
    });
}

// Toggle reply form visibility
function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
        form.classList.toggle('hidden');
    }
}

// Toggle review edit mode
function toggleEditReview(reviewId) {
    const content = document.getElementById('review-content-' + reviewId);
    const editForm = document.getElementById('review-edit-' + reviewId);
    
    if (content && editForm) {
        content.classList.toggle('hidden');
        editForm.classList.toggle('hidden');
    }
}

// Initialize edit star ratings
document.addEventListener('DOMContentLoaded', function() {
    const editStarContainers = document.querySelectorAll('[id^="editStarRating-"]');
    
    editStarContainers.forEach(container => {
        const reviewId = container.id.split('-')[1];
        const ratingInput = document.getElementById('editRatingInput-' + reviewId);
        const stars = container.querySelectorAll('.edit-star-btn');
        
        function updateEditStars(rating) {
            stars.forEach((btn, idx) => {
                const svg = btn.querySelector('svg');
                if (idx < rating) {
                    svg.classList.remove('text-gray-300');
                    svg.classList.add('text-amber-400');
                } else {
                    svg.classList.add('text-gray-300');
                    svg.classList.remove('text-amber-400');
                }
            });
        }
        
        stars.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const rating = this.dataset.value;
                ratingInput.value = rating;
                updateEditStars(rating);
            });
        });
    });
});

// Image modal for full-size viewing
function openImageModal(src) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4 animate-fadeIn';
    modal.onclick = function() { document.body.removeChild(modal); };
    
    const img = document.createElement('img');
    img.src = src;
    img.className = 'max-w-full max-h-full rounded-lg shadow-2xl';
    img.onclick = function(e) { e.stopPropagation(); };
    
    modal.appendChild(img);
    document.body.appendChild(modal);
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/products/show.blade.php ENDPATH**/ ?>