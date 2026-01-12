

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 dark:bg-slate-900">
    <!-- Full Screen Chat Container -->
    <div class="h-screen flex flex-col">
        <!-- Compact Header -->
        <div class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 px-6 py-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                        <span class="text-white text-lg font-bold">Dr.C</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Dr. C Skincare Advisor</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">AI-powered skincare guidance</p>
                    </div>
                </div>
                <?php if(auth()->guard()->check()): ?>
                <div class="flex gap-2">
                    <?php if($session): ?>
                    <a href="<?php echo e(route('dr-c.viewReport', ['session' => $session->id])); ?>" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2 shadow-md">
                        <i class="ri-file-text-line"></i>
                        <span>View Report</span>
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('dr-c.chat', ['new' => 1])); ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center gap-2 shadow-md">
                        <i class="ri-add-line"></i>
                        <span>New Chat</span>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Chat Area - Full Height -->
        <div class="flex-1 flex overflow-hidden">
            <!-- Sidebar - Collapsible -->
            <?php if(auth()->guard()->check()): ?>
            <div class="w-64 bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 overflow-y-auto hidden lg:block">
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <i class="ri-history-line text-blue-600 dark:text-blue-400"></i>
                        Recent Conversations
                    </h3>
                    <?php if(isset($recentSessions) && $recentSessions->count()): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $recentSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('dr-c.chat', ['session' => $s->session_token])); ?>" 
                                   class="block p-3 rounded-lg transition border <?php echo e($session && $session->id === $s->id ? 'bg-blue-100 dark:bg-blue-900 border-blue-300 dark:border-blue-700' : 'bg-gray-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 border-gray-200 dark:border-slate-700'); ?>">
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                        <span>#<?php echo e($s->id); ?></span>
                                        <span><?php echo e($s->created_at->format('M d, H:i')); ?></span>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white truncate"><?php echo e($s->concerns ?? 'General'); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($s->messages_count); ?> msgs • <?php echo e($s->status); ?></p>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No conversations yet</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Main Chat Container - Full Width -->
            <div class="flex-1 flex flex-col bg-white dark:bg-slate-800 overflow-hidden">
                <!-- Chat History with Products Section -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Chat Messages -->
                    <div id="chatHistory" class="p-6 space-y-4 bg-gray-50 dark:bg-slate-900/50 min-h-[400px]">
                        <?php if($history && count($history) > 0): ?>
                            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($msg->message_type === 'user'): ?>
                                    <div class="flex justify-end">
                                        <div class="max-w-3xl bg-blue-600 text-white rounded-2xl px-5 py-3 shadow-md">
                                            <p class="text-sm leading-relaxed"><?php echo e($msg->message); ?></p>
                                            <span class="text-xs opacity-75 mt-1 block"><?php echo e($msg->created_at->format('H:i')); ?></span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="flex justify-start">
                                        <div class="max-w-3xl bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl px-5 py-3 shadow-md">
                                            <p class="text-sm leading-relaxed text-gray-800 dark:text-white"><?php echo e($msg->message); ?></p>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Dr. C • <?php echo e($msg->created_at->format('H:i')); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="h-full flex flex-col items-center justify-center py-20">
                                <i class="ri-message-3-line text-7xl mb-4 text-blue-400 dark:text-blue-600"></i>
                                <p class="text-center text-gray-600 dark:text-gray-400 text-lg mb-2">
                                    Welcome to Dr. C Skincare Advisor
                                </p>
                                <p class="text-center text-gray-500 dark:text-gray-500 text-sm">
                                    Share your skincare concerns and I'll provide personalized guidance
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Product Recommendations - Inside Scrollable Area -->
                    <div id="productRecommendations" class="hidden px-6 py-8 bg-gradient-to-b from-blue-50 to-white dark:from-slate-800 dark:to-slate-900 border-t-2 border-blue-200 dark:border-blue-700">
                        <div class="max-w-7xl mx-auto">
                            <div class="mb-6 flex items-center gap-3">
                                <div class="bg-blue-600 dark:bg-blue-500 p-2.5 rounded-xl shadow-lg">
                                    <i class="ri-shopping-bag-line text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-2xl text-gray-900 dark:text-white">Recommended Products</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Personalized for your skin concerns</p>
                                </div>
                            </div>
                            <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>
                        </div>
                    </div>
                </div>

                <!-- Fixed Bottom Section -->
                <div class="flex-shrink-0">
                    <!-- Quick Concerns -->
                    <div class="px-6 py-3 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 font-medium">Quick concerns:</p>
                        <div class="flex flex-wrap gap-2">
                            <button onclick="fillMessage('I have acne and breakouts')" class="px-3 py-1.5 bg-gray-200 dark:bg-slate-700 hover:bg-blue-200 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 rounded-full text-xs transition shadow-sm font-medium">
                                🔴 Acne
                            </button>
                            <button onclick="fillMessage('I have dry skin')" class="px-3 py-1.5 bg-gray-200 dark:bg-slate-700 hover:bg-blue-200 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 rounded-full text-xs transition shadow-sm font-medium">
                                🏜️ Dry Skin
                            </button>
                            <button onclick="fillMessage('I have oily skin')" class="px-3 py-1.5 bg-gray-200 dark:bg-slate-700 hover:bg-blue-200 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 rounded-full text-xs transition shadow-sm font-medium">
                                💧 Oily Skin
                            </button>
                            <button onclick="fillMessage('I have sensitive skin')" class="px-3 py-1.5 bg-gray-200 dark:bg-slate-700 hover:bg-blue-200 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 rounded-full text-xs transition shadow-sm font-medium">
                                😊 Sensitive
                            </button>
                            <button onclick="fillMessage('I want anti-aging products')" class="px-3 py-1.5 bg-gray-200 dark:bg-slate-700 hover:bg-blue-200 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 rounded-full text-xs transition shadow-sm font-medium">
                                ⏰ Anti-Aging
                            </button>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="px-6 py-4 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700">
                        <form id="chatForm" class="flex gap-3">
                            <?php echo csrf_field(); ?>
                            <?php if($session): ?>
                                <input type="hidden" name="session_token" value="<?php echo e($session->session_token); ?>">
                            <?php endif; ?>
                            <input type="text" 
                                   name="message" 
                                   id="messageInput" 
                                   placeholder="<?php echo e($session ? 'Continue your conversation...' : 'Tell Dr. C about your skin concerns...'); ?>"
                                   class="flex-1 px-4 py-3 border border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   minlength="5" 
                                   maxlength="1000" 
                                   required>
                            <button type="submit" id="sendBtn"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2 shadow-md">
                                <span>Send</span>
                                <i class="ri-send-plane-fill"></i>
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            <?php if(isset($rateLimitRemaining)): ?>
                                <?php echo e($rateLimitRemaining); ?> messages remaining this hour
                            <?php else: ?>
                                20 messages per hour
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatHistory = document.getElementById('chatHistory');
    const sendBtn = document.getElementById('sendBtn');

    console.log('Dr. C chat initialized');

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message || message.length < 5) {
            alert('Please enter at least 5 characters');
            return;
        }

        console.log('Sending message:', message);

        // Disable button
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<span>Sending...</span><i class="ri-loader-4-line animate-spin"></i>';

        // Add user message to UI
        addMessage(message, 'user');
        messageInput.value = '';

        try {
            const csrfToken = document.querySelector('input[name="_token"]').value;
            console.log('CSRF Token:', csrfToken);
            console.log('Sending to:', '<?php echo e(route("dr-c.send")); ?>');

            const sessionToken = document.querySelector('input[name="session_token"]')?.value;
            const requestBody = { message: message };
            if (sessionToken) {
                requestBody.session_token = sessionToken;
            }

            const response = await fetch('<?php echo e(route("dr-c.send")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(requestBody)
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server error:', errorText);
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }

            const data = await response.json();
            console.log('Response data:', data);

            if (data.status === 'ok' && data.data) {
                addMessage(data.data.dr_c_response, 'assistant');
                
                if (data.data.products && data.data.products.length > 0) {
                    displayProducts(data.data.products);
                }
            } else {
                throw new Error(data.message || 'Invalid response format');
            }

        } catch (error) {
            console.error('Error:', error);
            showError(error.message || 'Failed to send message. Please try again.');
        } finally {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<span>Send</span><i class="ri-send-plane-fill"></i>';
        }
    });

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex ' + (sender === 'user' ? 'justify-end' : 'justify-start');

        const bubble = document.createElement('div');
        bubble.className = sender === 'user'
            ? 'max-w-3xl bg-blue-600 text-white rounded-2xl px-5 py-3 shadow-md'
            : 'max-w-3xl bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl px-5 py-3 shadow-md';

        const paragraph = document.createElement('p');
        paragraph.className = sender === 'user' ? 'text-sm leading-relaxed' : 'text-sm leading-relaxed text-gray-800 dark:text-white';
        paragraph.textContent = text;

        bubble.appendChild(paragraph);

        const timestamp = document.createElement('span');
        timestamp.className = sender === 'user'
            ? 'text-xs opacity-75 mt-1 block'
            : 'text-xs text-gray-500 dark:text-gray-400 mt-1 block';
        timestamp.textContent = sender === 'user' ? new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'Dr. C • ' + new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

        bubble.appendChild(timestamp);
        messageDiv.appendChild(bubble);
        chatHistory.appendChild(messageDiv);
        
        // Scroll the parent container smoothly
        const scrollContainer = chatHistory.parentElement;
        scrollContainer.scrollTop = scrollContainer.scrollHeight;
    }

    function displayProducts(products) {
        const grid = document.getElementById('productGrid');
        grid.innerHTML = '';

        products.forEach(product => {
            // Create card with professional design
            const card = document.createElement('div');
            card.className = 'group bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 dark:bg-gradient-to-br dark:from-indigo-900 dark:to-indigo-800 dark:border-2 dark:border-indigo-700';
            
            // Get primary image or use placeholder
            const productImage = product.image || product.image_url || '/images/placeholder.jpg';
            
            // Build rating stars
            const rating = Math.round(product.rating || 4.5);
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    stars += '<i class="ri-star-fill text-yellow-400 text-xs"></i>';
                } else {
                    stars += '<i class="ri-star-line text-yellow-400 text-xs"></i>';
                }
            }
            
            // Truncate description
            const description = product.description ? 
                (product.description.length > 80 ? product.description.substring(0, 80) + '...' : product.description) : 
                'Recommended for your skin concerns';
            
            card.innerHTML = `
                <a href="/products/${product.id}" class="block cursor-pointer h-full flex flex-col">
                    <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-slate-700 dark:to-slate-800">
                        <img src="${productImage}" alt="${product.name}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500" 
                             onerror="this.parentElement.innerHTML='<div class=\\'flex flex-col items-center justify-center h-full text-gray-400\\'><svg class=\\'w-20 h-20 mb-3\\' fill=\\'none\\' stroke=\\'currentColor\\' viewBox=\\'0 0 24 24\\'><path stroke-linecap=\\'round\\' stroke-linejoin=\\'round\\' stroke-width=\\'1.5\\' d=\\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\\'></path></svg><span class=\\'text-sm font-medium\\'>No image available</span></div>'">
                        <div class="absolute top-3 right-3 bg-white dark:bg-slate-800 px-2.5 py-1 rounded-full shadow-lg">
                            <div class="flex gap-0.5">${stars}</div>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1.5 rounded-full font-bold uppercase tracking-wide dark:bg-blue-900 dark:text-blue-200">${product.category || 'Featured'}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 dark:text-white leading-tight line-clamp-2 min-h-[3.5rem]">${product.name}</h3>
                        <p class="text-gray-600 text-sm mb-4 dark:text-blue-200 line-clamp-2 flex-1">${description}</p>
                        <div class="mt-auto pt-3 border-t border-gray-100 dark:border-indigo-700">
                            <div class="flex items-center justify-between">
                                <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">View Details</span>
                                <i class="ri-arrow-right-line text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>
                    </div>
                </a>
            `;
            grid.appendChild(card);
        });

        document.getElementById('productRecommendations').classList.remove('hidden');
        
        // Smooth scroll to show the products section
        setTimeout(() => {
            const scrollContainer = document.querySelector('.overflow-y-auto');
            const productsSection = document.getElementById('productRecommendations');
            if (scrollContainer && productsSection) {
                scrollContainer.scrollTo({
                    top: scrollContainer.scrollHeight,
                    behavior: 'smooth'
                });
            }
        }, 150);
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'fixed top-20 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3';
        errorDiv.innerHTML = `
            <i class="ri-error-warning-line text-xl"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(errorDiv);

        setTimeout(() => errorDiv.remove(), 5000);
    }

    window.fillMessage = function(text) {
        messageInput.value = text;
        messageInput.focus();
    };
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/dr-c/chat.blade.php ENDPATH**/ ?>