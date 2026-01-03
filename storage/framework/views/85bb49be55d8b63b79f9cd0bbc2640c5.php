

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white text-2xl font-bold">Dr.C</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dr. C Skincare Advisor</h1>
                        <p class="text-gray-600 dark:text-blue-200">AI-powered skincare guidance by CeraVe</p>
                        <?php if($session): ?>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Session: <?php echo e($session->concerns ?? 'General'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(auth()->guard()->check()): ?>
                <div class="flex gap-3">
                    <?php if($session): ?>
                    <a href="<?php echo e(route('dr-c.viewReport', ['session' => $session->id])); ?>" target="_blank" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition font-medium flex items-center gap-2 shadow-md">
                        <i class="ri-file-text-line"></i>
                        <span>View Report</span>
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('dr-c.chat', ['new' => 1])); ?>" class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition font-medium flex items-center gap-2 shadow-md">
                        <i class="ri-add-line"></i>
                        <span>New Chat</span>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <?php if(auth()->guard()->check()): ?>
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800 rounded-xl shadow-lg p-6">
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

            <!-- Main Chat -->
            <div class="<?php if(auth()->guard()->check()): ?> lg:col-span-3 <?php else: ?> lg:col-span-4 <?php endif; ?>">
                <div class="bg-white dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800 rounded-xl shadow-lg overflow-hidden">
                    <!-- Chat History -->
                    <div id="chatHistory" class="h-[500px] overflow-y-auto p-6 space-y-4 bg-gray-50 dark:bg-slate-800/50">
                        <?php if($history && count($history) > 0): ?>
                            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($msg->message_type === 'user'): ?>
                                    <div class="flex justify-end">
                                        <div class="max-w-md bg-blue-600 text-white rounded-lg p-4 shadow">
                                            <p class="text-sm"><?php echo e($msg->message); ?></p>
                                            <span class="text-xs opacity-75 mt-1 block"><?php echo e($msg->created_at->format('H:i')); ?></span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="flex justify-start">
                                        <div class="max-w-md bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg p-4 shadow">
                                            <p class="text-sm text-gray-800 dark:text-white"><?php echo e($msg->message); ?></p>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Dr. C</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="h-full flex flex-col items-center justify-center text-gray-400">
                                <i class="ri-message-3-line text-6xl mb-4 text-blue-300 dark:text-blue-600"></i>
                                <p class="text-center text-gray-600 dark:text-gray-400">
                                    Start a conversation with Dr. C<br>
                                    <span class="text-xs">Share your skincare concerns</span>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Concerns -->
                    <div class="px-6 py-4 bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 font-medium">Quick concerns:</p>
                        <div class="flex flex-wrap gap-2">
                            <button onclick="fillMessage('I have acne and breakouts')" class="px-3 py-1 bg-gray-100 dark:bg-slate-700 hover:bg-blue-100 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-full text-xs transition">
                                🔴 Acne
                            </button>
                            <button onclick="fillMessage('I have dry skin')" class="px-3 py-1 bg-gray-100 dark:bg-slate-700 hover:bg-blue-100 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-full text-xs transition">
                                🏜️ Dry Skin
                            </button>
                            <button onclick="fillMessage('I have oily skin')" class="px-3 py-1 bg-gray-100 dark:bg-slate-700 hover:bg-blue-100 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-full text-xs transition">
                                💧 Oily Skin
                            </button>
                            <button onclick="fillMessage('I have sensitive skin')" class="px-3 py-1 bg-gray-100 dark:bg-slate-700 hover:bg-blue-100 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 rounded-full text-xs transition">
                                😊 Sensitive
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
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition font-medium flex items-center gap-2">
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

                <!-- Product Recommendations -->
                <div id="productRecommendations" class="mt-6 hidden">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recommended Products</h3>
                    <div id="productGrid" class="grid grid-cols-1 md:grid-cols-4 gap-4"></div>
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
            ? 'max-w-md bg-blue-600 text-white rounded-lg p-4 shadow'
            : 'max-w-md bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg p-4 shadow';

        const paragraph = document.createElement('p');
        paragraph.className = sender === 'user' ? 'text-sm' : 'text-sm text-gray-800 dark:text-white';
        paragraph.textContent = text;

        bubble.appendChild(paragraph);

        const timestamp = document.createElement('span');
        timestamp.className = sender === 'user'
            ? 'text-xs opacity-75 mt-1 block'
            : 'text-xs text-gray-500 dark:text-gray-400 mt-1 block';
        timestamp.textContent = sender === 'user' ? new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'Dr. C';

        bubble.appendChild(timestamp);
        messageDiv.appendChild(bubble);
        chatHistory.appendChild(messageDiv);
        chatHistory.scrollTop = chatHistory.scrollHeight;
    }

    function displayProducts(products) {
        const grid = document.getElementById('productGrid');
        grid.innerHTML = '';

        products.forEach(product => {
            const card = document.createElement('div');
            card.className = 'bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg overflow-hidden hover:shadow-lg transition';
            card.innerHTML = `
                <img src="${product.image || '/images/placeholder.jpg'}" alt="${product.name}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-2">${product.name}</h4>
                    <a href="/products/${product.id}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-sm transition">
                        View Product
                    </a>
                </div>
            `;
            grid.appendChild(card);
        });

        document.getElementById('productRecommendations').classList.remove('hidden');
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