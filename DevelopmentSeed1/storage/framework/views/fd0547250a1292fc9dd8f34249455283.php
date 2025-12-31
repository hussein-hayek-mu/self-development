<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Contact - Level Up</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased bg-[#0a0a0f] text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#0a0a0f]/90 backdrop-blur-sm border-b border-purple-500/20">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="<?php echo e(route('home')); ?>" class="logo text-2xl">LEVEL UP</a>
            <div class="flex items-center gap-6">
                <a href="<?php echo e(route('home')); ?>#features" class="text-gray-400 hover:text-white transition-colors">Features</a>
                <a href="<?php echo e(route('about')); ?>" class="text-gray-400 hover:text-white transition-colors">About</a>
                <a href="<?php echo e(route('contact')); ?>" class="text-white font-semibold">Contact</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-primary btn-small">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-400 hover:text-white transition-colors">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn-primary btn-small">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Contact Hero Section -->
    <section class="min-h-screen flex items-center justify-center px-6 pt-32 pb-20">
        <div class="max-w-4xl w-full">
            <div class="text-center mb-16">
                <h1 class="text-5xl md:text-6xl font-black mb-6" style="font-family: 'Orbitron', sans-serif;">
                    <span class="bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">Get In Touch</span>
                </h1>
                <p class="text-xl text-gray-400">
                    Have questions? We're here to help you on your journey
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="game-card">
                    <h2 class="text-2xl font-bold mb-6" style="font-family: 'Orbitron', sans-serif;">Send a Message</h2>
                    <form action="#" method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Your Name</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required
                                   class="w-full px-4 py-3 bg-[#1a1a2e] border border-purple-500/30 rounded-lg text-white placeholder-gray-500 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400/20 transition-colors"
                                   placeholder="Hero Name">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-4 py-3 bg-[#1a1a2e] border border-purple-500/30 rounded-lg text-white placeholder-gray-500 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400/20 transition-colors"
                                   placeholder="hero@email.com">
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                            <select id="subject" 
                                    name="subject"
                                    class="w-full px-4 py-3 bg-[#1a1a2e] border border-purple-500/30 rounded-lg text-white focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400/20 transition-colors">
                                <option>General Inquiry</option>
                                <option>Technical Support</option>
                                <option>Feature Request</option>
                                <option>Bug Report</option>
                                <option>Partnership</option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required
                                      class="w-full px-4 py-3 bg-[#1a1a2e] border border-purple-500/30 rounded-lg text-white placeholder-gray-500 focus:border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400/20 transition-colors resize-none"
                                      placeholder="Tell us about your quest..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary w-full py-3">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <!-- Email -->
                    <div class="game-card">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl">📧</div>
                            <div>
                                <h3 class="text-lg font-bold mb-2">Email Us</h3>
                                <p class="text-gray-400 mb-2">For general inquiries and support</p>
                                <a href="mailto:support@levelup.com" class="text-purple-400 hover:text-purple-300 transition-colors">
                                    support@levelup.com
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Discord -->
                    <div class="game-card">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl">💬</div>
                            <div>
                                <h3 class="text-lg font-bold mb-2">Join Our Discord</h3>
                                <p class="text-gray-400 mb-2">Connect with our community</p>
                                <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">
                                    Join our community
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Twitter -->
                    <div class="game-card">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl">🐦</div>
                            <div>
                                <h3 class="text-lg font-bold mb-2">Follow Us</h3>
                                <p class="text-gray-400 mb-2">Get the latest updates and tips</p>
                                <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">
                                    @LevelUpApp
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Link -->
                    <div class="game-card bg-gradient-to-br from-purple-500/10 to-pink-500/10 border-purple-400/30">
                        <div class="flex items-start gap-4">
                            <div class="text-4xl">❓</div>
                            <div>
                                <h3 class="text-lg font-bold mb-2">FAQ</h3>
                                <p class="text-gray-400 mb-3">Find answers to common questions</p>
                                <a href="#" class="btn-secondary btn-small inline-block">
                                    View FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Time Notice -->
            <div class="mt-12 text-center">
                <div class="inline-flex items-center gap-2 px-6 py-3 bg-purple-500/10 border border-purple-400/30 rounded-lg">
                    <span class="text-2xl">⚡</span>
                    <p class="text-gray-400">
                        <span class="text-purple-400 font-semibold">Average response time:</span> 24 hours
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-6 border-t border-purple-500/20">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="logo text-xl">LEVEL UP</div>
            <div class="text-gray-400 text-sm">
                © <?php echo e(date('Y')); ?> Level Up. All rights reserved.
            </div>
            <div class="flex gap-6">
                <a href="<?php echo e(route('home')); ?>" class="text-gray-400 hover:text-purple-400 transition-colors">Home</a>
                <a href="<?php echo e(route('about')); ?>" class="text-gray-400 hover:text-purple-400 transition-colors">About</a>
                <a href="<?php echo e(route('contact')); ?>" class="text-gray-400 hover:text-purple-400 transition-colors">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/contact.blade.php ENDPATH**/ ?>