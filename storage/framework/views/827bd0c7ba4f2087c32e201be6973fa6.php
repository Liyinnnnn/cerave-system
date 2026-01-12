

<?php $__env->startSection('content'); ?>
<!-- Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="py-10 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
                <p class="text-gray-600 mt-2">Update <?php echo e($product->name); ?> product information</p>
            </div>

            <?php if(session('error')): ?>
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <form id="productForm" action="<?php echo e(route('products.update', $product)); ?>" method="POST" enctype="multipart/form-data" class="space-y-8" onsubmit="return prepareFormSubmission()">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                
                <!-- Basic Information -->
                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-2xl font-bold text-blue-900 mb-6">ℹ️ Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-800 mb-2 uppercase tracking-wide">📝 Product Name *</label>
                            <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required placeholder="e.g. Moisturising Cream">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                            <input type="text" name="category" value="<?php echo e(old('category', $product->category)); ?>" list="categoryList" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required placeholder="Select existing or type new category">
                            <datalist id="categoryList">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                            <p class="text-xs text-gray-500 mt-1 italic">✨ Select from existing categories or type a new one to add it to the system</p>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Skin Types (Select all that apply)</label>
                            <div class="space-y-2 bg-gray-50 p-4 rounded-lg border border-gray-300">
                                <?php
                                    $selectedTypes = old('skin_types', is_string($product->skin_type) && $product->skin_type ? explode(',', $product->skin_type) : []);
                                ?>
                                <?php $__currentLoopData = ['dry','oily','combination','sensitive','normal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-100 p-2 rounded transition">
                                        <input type="checkbox" name="skin_types[]" value="<?php echo e($type); ?>" 
                                            <?php if(in_array($type, $selectedTypes)): echo 'checked'; endif; ?>
                                            class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                        <span class="text-gray-800 font-medium"><?php echo e(ucfirst($type)); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 italic">✨ Leave all unchecked if suitable for all skin types</p>
                            <?php $__errorArgs = ['skin_types'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Product Images from Public Folder (up to 10) -->
                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Product Images</h2>
                    <p class="text-sm text-gray-600 mb-4">Select up to 10 images from the public/images folder</p>
                    
                    <?php
                        $imageFiles = [];
                        $imagePath = public_path('images');
                        if (is_dir($imagePath)) {
                            $files = scandir($imagePath);
                            $imageFiles = array_filter($files, function($file) {
                                return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            });
                            sort($imageFiles);
                        }
                        $productImages = $product->images ?? [];
                    ?>

                    <div id="imageInputs" class="space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="image-input-group flex gap-2">
                                <select name="images[]" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition image-select">
                                    <option value="">-- Select Image <?php echo e($index + 1); ?> --</option>
                                    <?php $__currentLoopData = $imageFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="/images/<?php echo e($file); ?>" <?php if($image === "/images/{$file}"): echo 'selected'; endif; ?>/images/<?php echo e($file); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <button type="button" onclick="removeImageInput(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="image-input-group flex gap-2">
                                <select name="images[]" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition image-select">
                                    <option value="">-- Select Image 1 --</option>
                                    <?php $__currentLoopData = $imageFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="/images/<?php echo e($file); ?>">/images/<?php echo e($file); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <button type="button" onclick="removeImageInput(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition hidden">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="addImageBtn" onclick="addImageInput()" class="mt-3 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition font-semibold text-sm">
                        + Add Another Image
                    </button>
                    <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- External Purchase Links (Multiple) -->
                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">External Purchase Links</h2>
                    <p class="text-sm text-gray-600 mb-4">Add links where customers can purchase this product with brand logos</p>
                    
                    <?php
                        $externalUrls = $product->getAllExternalUrls();
                        $retailerNames = $product->retailer_names ?? [];
                        $retailerLogos = $product->retailer_logos ?? [];
                    ?>

                    <div id="externalLinksInputs" class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $externalUrls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="external-link-group bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-3">
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <label class="text-xs font-semibold text-gray-600 uppercase">Retailer Name</label>
                                            <input type="text" name="retailer_names[]" value="<?php echo e(old('retailer_names.' . $index, $retailerNames[$index] ?? '')); ?>" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="e.g., Shopee">
                                        </div>
                                        <div class="flex-1">
                                            <label class="text-xs font-semibold text-gray-600 uppercase">Purchase URL</label>
                                            <input type="url" name="external_urls[]" value="<?php echo e(old('external_urls.' . $index, $url)); ?>" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="https://store.com/product">
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" onclick="removeExternalLink(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-600 uppercase">Brand Logo</label>
                                        <div class="mt-1 flex gap-2">
                                            <input type="file" name="retailer_logos[]" accept="image/*" onchange="previewRetailerLogo(this, <?php echo e($index); ?>)" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                                            <?php if(isset($retailerLogos[$index]) && $retailerLogos[$index]): ?>
                                                <div class="flex items-center gap-2">
                                                    <img src="<?php echo e($retailerLogos[$index]); ?>" alt="Logo" class="h-10 object-contain border border-gray-200 rounded px-1">
                                                    <button type="button" onclick="removeRetailerLogo(this, <?php echo e($index); ?>)" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div id="logoPreview<?php echo e($index); ?>" class="mt-2"></div>
                                        <input type="hidden" name="retailer_logos_existing[]" value="<?php echo e($retailerLogos[$index] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="external-link-group bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-3">
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <label class="text-xs font-semibold text-gray-600 uppercase">Retailer Name</label>
                                            <input type="text" name="retailer_names[]" value="" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="e.g., Shopee">
                                        </div>
                                        <div class="flex-1">
                                            <label class="text-xs font-semibold text-gray-600 uppercase">Purchase URL</label>
                                            <input type="url" name="external_urls[]" value="" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="https://store.com/product">
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" onclick="removeExternalLink(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition hidden">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-600 uppercase">Brand Logo</label>
                                        <div class="mt-1 flex gap-2">
                                            <input type="file" name="retailer_logos[]" accept="image/*" onchange="previewRetailerLogo(this, 0)" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                                        </div>
                                        <div id="logoPreview0" class="mt-2"></div>
                                        <input type="hidden" name="retailer_logos_existing[]" value="">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="addExternalLinkBtn" onclick="addExternalLink()" class="mt-4 px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition font-semibold text-sm">
                        + Add Another Retailer Link
                    </button>
                    <?php $__errorArgs = ['external_urls'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Rich Text Content -->
                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Product Description *</h2>
                    <div id="descriptionEditor" style="height: 200px;" class="bg-white"></div>
                    <textarea name="description" id="descriptionInput" class="hidden"><?php echo e(old('description', $product->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Benefits</h2>
                    <div id="benefitsEditor" style="height: 200px;" class="bg-white"></div>
                    <textarea name="benefits" id="benefitsInput" class="hidden"><?php echo e(old('benefits', $product->benefits)); ?></textarea>
                    <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Visual Feature Cards (Image + Text) -->
                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">🎨 Visual Feature Cards</h2>
                    <p class="text-sm text-gray-600 mb-4">Add visual feature cards with images and text descriptions to highlight key benefits</p>
                    
                    <div id="featureCardsInputs" class="space-y-4">
                        <?php
                            $existingFeatures = old('features', $product->features ?? []);
                            $featureIndex = 0;
                        ?>
                        
                        <?php if(!empty($existingFeatures) && is_array($existingFeatures)): ?>
                            <?php $__currentLoopData = $existingFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="feature-card-group bg-gradient-to-br from-gray-50 to-gray-100 p-5 rounded-lg border-2 border-purple-200">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-800 mb-2 uppercase tracking-wide">📸 Feature Image</label>
                                            <select name="features[<?php echo e($index); ?>][image]" class="feature-image-select w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white cursor-pointer transition">
                                                <option value="">-- Select Image from Folder --</option>
                                            </select>
                                            <p class="text-xs text-gray-500 mt-2 italic">Images from public/images folder</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-800 mb-2 uppercase tracking-wide">✏️ Feature Description</label>
                                            <div id="featureTextEditor<?php echo e($index); ?>" style="height: 120px;" class="bg-white border-2 border-gray-300 rounded-lg feature-text-editor"></div>
                                            <textarea name="features[<?php echo e($index); ?>][text]" id="featureTextInput<?php echo e($index); ?>" class="hidden"><?php echo e($feature['text'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeFeatureCard(this)" class="mt-3 text-sm text-red-600 hover:text-red-800 font-semibold <?php echo e(count($existingFeatures) === 1 ? 'hidden' : ''); ?>">✕ Remove Card</button>
                                </div>
                                <?php $featureIndex = $index + 1; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="feature-card-group bg-gradient-to-br from-gray-50 to-gray-100 p-5 rounded-lg border-2 border-purple-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-800 mb-2 uppercase tracking-wide">📸 Feature Image</label>
                                        <select name="features[0][image]" class="feature-image-select w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white cursor-pointer transition">
                                            <option value="">-- Select Image from Folder --</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-2 italic">Images from public/images folder</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-800 mb-2 uppercase tracking-wide">✏️ Feature Description</label>
                                        <div id="featureTextEditor0" style="height: 120px;" class="bg-white border-2 border-gray-300 rounded-lg feature-text-editor"></div>
                                        <textarea name="features[0][text]" id="featureTextInput0" class="hidden"></textarea>
                                    </div>
                                </div>
                                <button type="button" onclick="removeFeatureCard(this)" class="mt-3 text-sm text-red-600 hover:text-red-800 font-semibold hidden">✕ Remove Card</button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="addFeatureCardBtn" onclick="addFeatureCard()" class="mt-3 px-4 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition font-semibold text-sm">
                        + Add Feature Card
                    </button>
                    <?php $__errorArgs = ['features'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ingredients</h2>
                    <div id="ingredientsEditor" style="height: 200px;" class="bg-white"></div>
                    <textarea name="ingredients" id="ingredientsInput" class="hidden"><?php echo e(old('ingredients', $product->ingredients)); ?></textarea>
                    <?php $__errorArgs = ['ingredients'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="pb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">How to Use</h2>
                    <div id="directionsEditor" style="height: 200px;" class="bg-white"></div>
                    <textarea name="directions" id="directionsInput" class="hidden"><?php echo e(old('directions', $product->directions)); ?></textarea>
                    <?php $__errorArgs = ['directions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="<?php echo e(route('products.show', $product)); ?>" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quill.js Script -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// Initialize Quill editors
const toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
    [{ 'color': [] }, { 'background': [] }],
    [{ 'align': [] }],
    ['clean']
];

const descriptionQuill = new Quill('#descriptionEditor', {
    modules: { toolbar: toolbarOptions },
    theme: 'snow',
    placeholder: 'Enter product description...'
});

const benefitsQuill = new Quill('#benefitsEditor', {
    modules: { toolbar: toolbarOptions },
    theme: 'snow',
    placeholder: 'Enter product benefits...'
});

const ingredientsQuill = new Quill('#ingredientsEditor', {
    modules: { toolbar: toolbarOptions },
    theme: 'snow',
    placeholder: 'Enter ingredients list...'
});

const directionsQuill = new Quill('#directionsEditor', {
    modules: { toolbar: toolbarOptions },
    theme: 'snow',
    placeholder: 'Enter usage directions...'
});

// Load old values if validation failed
<?php if(old('description')): ?>
    descriptionQuill.root.innerHTML = <?php echo json_encode(old('description')); ?>;
<?php else: ?>
    descriptionQuill.root.innerHTML = <?php echo json_encode($product->description); ?>;
<?php endif; ?>
<?php if(old('benefits')): ?>
    benefitsQuill.root.innerHTML = <?php echo json_encode(old('benefits')); ?>;
<?php else: ?>
    benefitsQuill.root.innerHTML = <?php echo json_encode($product->benefits); ?>;
<?php endif; ?>
<?php if(old('ingredients')): ?>
    ingredientsQuill.root.innerHTML = <?php echo json_encode(old('ingredients')); ?>;
<?php else: ?>
    ingredientsQuill.root.innerHTML = <?php echo json_encode($product->ingredients); ?>;
<?php endif; ?>
<?php if(old('directions')): ?>
    directionsQuill.root.innerHTML = <?php echo json_encode(old('directions')); ?>;
<?php else: ?>
    directionsQuill.root.innerHTML = <?php echo json_encode($product->directions); ?>;
<?php endif; ?>

// Prepare form before submission
function prepareFormSubmission() {
    // Populate hidden textareas with Quill content
    document.getElementById('descriptionInput').value = descriptionQuill.root.innerHTML;
    document.getElementById('benefitsInput').value = benefitsQuill.root.innerHTML;
    document.getElementById('ingredientsInput').value = ingredientsQuill.root.innerHTML;
    document.getElementById('directionsInput').value = directionsQuill.root.innerHTML;
    
    // Validate description is not empty
    const descText = descriptionQuill.getText().trim();
    if (descText.length === 0 || descText === '') {
        alert('Please enter a product description');
        return false;
    }
    
    return true;
}

// Image input management
let imageCount = <?php echo e(count($productImages ?? [])); ?>;

function addImageInput() {
    if (imageCount >= 10) {
        alert('Maximum 10 images allowed');
        return;
    }
    
    imageCount++;
    const container = document.getElementById('imageInputs');
    const imageFiles = <?php echo json_encode($imageFiles); ?>;
    
    let selectOptions = '<option value="">-- Select Image ' + imageCount + ' --</option>';
    imageFiles.forEach(file => {
        selectOptions += '<option value="/images/' + file + '">/images/' + file + '</option>';
    });
    
    const newInput = document.createElement('div');
    newInput.className = 'image-input-group flex gap-2';
    newInput.innerHTML = `
        <select name="images[]" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition image-select">
            ${selectOptions}
        </select>
        <button type="button" onclick="removeImageInput(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    `;
    container.appendChild(newInput);
    
    if (imageCount >= 10) {
        document.getElementById('addImageBtn').disabled = true;
        document.getElementById('addImageBtn').classList.add('opacity-50', 'cursor-not-allowed');
    }
    
    updateImageRemoveButtons();
}

function removeImageInput(button) {
    button.closest('.image-input-group').remove();
    imageCount--;
    
    document.getElementById('addImageBtn').disabled = false;
    document.getElementById('addImageBtn').classList.remove('opacity-50', 'cursor-not-allowed');
    
    updateImageRemoveButtons();
}

function updateImageRemoveButtons() {
    const groups = document.querySelectorAll('.image-input-group');
    groups.forEach((group) => {
        const removeBtn = group.querySelector('button');
        if (groups.length === 1) {
            removeBtn.classList.add('hidden');
        } else {
            removeBtn.classList.remove('hidden');
        }
    });
}

// External links management
let externalLinkCount = <?php echo e(count($externalUrls ?? [])); ?>;

function addExternalLink() {
    externalLinkCount++;
    const container = document.getElementById('externalLinksInputs');
    
    const newLink = document.createElement('div');
    newLink.className = 'external-link-group';
    newLink.innerHTML = `
        <div class="flex gap-2">
            <input type="text" name="retailer_names[]" class="w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Retailer Name (e.g., Watsons)">
            <input type="url" name="external_urls[]" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="https://store.com/product">
            <button type="button" onclick="removeExternalLink(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    `;
    container.appendChild(newLink);
    
    updateExternalLinkRemoveButtons();
}

function removeExternalLink(button) {
    button.closest('.external-link-group').remove();
    externalLinkCount--;
    updateExternalLinkRemoveButtons();
}

function updateExternalLinkRemoveButtons() {
    const groups = document.querySelectorAll('.external-link-group');
    groups.forEach((group) => {
        const removeBtn = group.querySelector('button[type="button"]');
        if (removeBtn) {
            if (groups.length === 1) {
                removeBtn.classList.add('hidden');
            } else {
                removeBtn.classList.remove('hidden');
            }
        }
    });
}

// Retailer logo preview
function previewRetailerLogo(input, index) {
    const file = input.files[0];
    const previewDiv = document.getElementById('logoPreview' + index);
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewDiv.innerHTML = `
                <div class="flex items-center gap-2 bg-white p-2 rounded border border-gray-200">
                    <img src="${e.target.result}" alt="Logo preview" class="h-8 object-contain">
                    <span class="text-sm text-gray-600">Ready to upload</span>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

// Initialize
updateImageRemoveButtons();
updateExternalLinkRemoveButtons();

// Feature cards management
let featureCardCount = <?php echo e(count($product->features ?? [])); ?>;
const imageFiles = <?php echo json_encode($imageFiles); ?>;
const featureEditors = {};

// Initialize feature card image selects and editors
function initializeFeatureCards() {
    const selects = document.querySelectorAll('.feature-image-select');
    const editors = document.querySelectorAll('.feature-text-editor');
    
    selects.forEach(select => {
        populateImageSelect(select);
        // Set current value if it exists
        const currentValue = select.dataset.current;
        if (currentValue) select.value = currentValue;
    });
    
    editors.forEach((editor, idx) => {
        const quill = new Quill(editor, {
            modules: { toolbar: [['bold', 'italic', 'underline']] },
            theme: 'snow',
            placeholder: 'Describe this key feature...'
        });
        const input = document.getElementById(`featureTextInput${idx}`);
        if (input && input.value) {
            quill.root.innerHTML = input.value;
        }
        featureEditors[idx] = quill;
    });
}

function populateImageSelect(selectElement) {
    selectElement.innerHTML = '<option value="">-- Select Image from Folder --</option>';
    imageFiles.forEach(file => {
        const option = document.createElement('option');
        option.value = '/images/' + file;
        option.textContent = file;
        selectElement.appendChild(option);
    });
}

function addFeatureCard() {
    const container = document.getElementById('featureCardsInputs');
    
    const newCard = document.createElement('div');
    newCard.className = 'feature-card-group bg-gradient-to-br from-gray-50 to-gray-100 p-5 rounded-lg border-2 border-purple-200';
    newCard.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2 uppercase tracking-wide">📸 Feature Image</label>
                <select name="features[${featureCardCount}][image]" class="feature-image-select w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white cursor-pointer transition">
                    <option value="">-- Select Image from Folder --</option>
                </select>
                <p class="text-xs text-gray-500 mt-2 italic">Images from public/images folder</p>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-2 uppercase tracking-wide">✏️ Feature Description</label>
                <div id="featureTextEditor${featureCardCount}" style="height: 120px;" class="bg-white border-2 border-gray-300 rounded-lg feature-text-editor"></div>
                <textarea name="features[${featureCardCount}][text]" id="featureTextInput${featureCardCount}" class="hidden"></textarea>
            </div>
        </div>
        <button type="button" onclick="removeFeatureCard(this)" class="mt-3 text-sm text-red-600 hover:text-red-800 font-semibold">✕ Remove Card</button>
    `;
    container.appendChild(newCard);
    
    // Initialize editor for new card
    const newEditor = new Quill(`#featureTextEditor${featureCardCount}`, {
        modules: { toolbar: [['bold', 'italic', 'underline']] },
        theme: 'snow',
        placeholder: 'Describe this key feature...'
    });
    featureEditors[featureCardCount] = newEditor;
    
    // Populate image select
    const newSelect = newCard.querySelector('.feature-image-select');
    populateImageSelect(newSelect);
    
    featureCardCount++;
    updateFeatureCardRemoveButtons();
}

function removeFeatureCard(button) {
    button.closest('.feature-card-group').remove();
    updateFeatureCardRemoveButtons();
}

function updateFeatureCardRemoveButtons() {
    const cards = document.querySelectorAll('.feature-card-group');
    cards.forEach((card) => {
        const removeBtn = card.querySelector('button[onclick^="removeFeatureCard"]');
        if (removeBtn) {
            if (cards.length === 1) {
                removeBtn.classList.add('hidden');
            } else {
                removeBtn.classList.remove('hidden');
            }
        }
    });
}

// Initialize on page load
initializeFeatureCards();
updateFeatureCardRemoveButtons();

// Form submission: Sync all Quill editors
const productForm = document.getElementById('productForm');
if (productForm) {
    productForm.addEventListener('submit', function() {
        for (const [index, editor] of Object.entries(featureEditors)) {
            const textarea = document.getElementById(`featureTextInput${index}`);
            if (textarea && editor) {
                textarea.value = editor.root.innerHTML;
            }
        }
        
        document.getElementById('descriptionInput').value = descriptionQuill.root.innerHTML;
        document.getElementById('benefitsInput').value = benefitsQuill.root.innerHTML;
        document.getElementById('ingredientsInput').value = ingredientsQuill.root.innerHTML;
        document.getElementById('directionsInput').value = directionsQuill.root.innerHTML;
    });
}

// Initialize feature cards
updateFeatureCardRemoveButtons();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/products/edit.blade.php ENDPATH**/ ?>