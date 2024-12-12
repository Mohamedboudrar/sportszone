<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div>
                    <a href="index.php">
                        <img src="images/sportfacility.png" alt="Sport Facility Logo" style="width: 100px; height: auto; margin-right: 10px;">
                    </a>
                    
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-6">
                    <?php 
                    $currentPage = basename($_SERVER['PHP_SELF']);
                    $navItems = [
                        'index.php' => 'Home',
                        'about.php' => 'About Us', 
                        'services.php' => 'Facilities',
                        'status.php' => 'Booking Status', 
                        'contact.php' => 'Contact Us'
                    ];

                    foreach ($navItems as $url => $name):
                        $activeClass = ($currentPage == $url) ? 'text-blue-600 font-bold' : 'text-gray-700';
                    ?>
                        <a href="<?= $url ?>" class="<?= $activeClass ?> hover:text-blue-500 transition duration-300">
                            <?= $name ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Contact Info -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-blue-500 mr-2"></i>
                        <span>+212 666666666</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-blue-500 mr-2"></i>
                        <span>contact@sportszone.com</span>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="md:hidden">
                    <button id="mobile-menu-toggle" class="text-gray-500 hover:text-blue-500">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu (Hidden by Default) -->
            <div id="mobile-menu" class="md:hidden hidden">
                <?php foreach ($navItems as $url => $name): ?>
                    <a href="<?= $url ?>" class="block py-2 px-4 hover:bg-blue-100">
                        <?= $name ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>