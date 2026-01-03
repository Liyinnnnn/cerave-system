<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CeraVe</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">
</head>

<body class="font-[Poppins] bg-white min-h-screen">
    <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <main class="pt-20"><?php echo $__env->yieldContent('content'); ?></main>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\cerave-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>