  <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

<div class="header-top bg-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-6 col-lg-3">
            <a href="index.php" style="all: unset;">
              <img src="images/plane.svg" alt="Image" class="img-fluid">
              <strong style="all: unset;">WeFly</strong>
            </a>
          </div>
          <div class="col-lg-3 d-none d-lg-block">

 
          </div>
          <div class="col-lg-3 d-none d-lg-block">
            <div class="quick-contact-icons d-flex">
              <div class="icon align-self-start">
                <span class="icon-phone text-primary"></span>
              </div>
              <div class="text mt-1">
                <span class="h4 d-block">+212 666666666</span>
                <!-- <span class="caption-text">Toll free</span> -->
              </div>
            </div>
          </div>

          <div class="col-lg-3 d-none d-lg-block">
            <div class="quick-contact-icons d-flex">
              <div class="icon align-self-start">
                <span class="icon-envelope text-primary "></span>
              </div>
              <div class="text mt-1">
                <span class="h4 d-block">Wefly@gmail.com</span>
               
              </div>
            </div>
          </div>

          <div class="col-6 d-block d-lg-none text-right">
              <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span
                class="icon-menu h3"></span></a>
          </div>
        </div>
      </div>
      


      
      <div class="site-navbar py-2 js-sticky-header site-navbar-target d-none pl-0 d-lg-block" role="banner">

      <div class="container">
        <div class="d-flex align-items-center">
          
          <div class="mx-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
            <?php
              $currentPage = basename($_SERVER['PHP_SELF']);
            ?>
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none pl-0 d-lg-block">
                <li class="<?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
                  <a href="index.php" class="nav-link text-left">Home</a>
                </li>
                <li class="<?php echo $currentPage == 'about.php' ? 'active' : ''; ?>">
                  <a href="about.php" class="nav-link text-left">About Us</a>
                </li>
                <li class="<?php echo $currentPage == 'services.php' ? 'active' : ''; ?>">
                  <a href="services.php" class="nav-link text-left">Services</a>
                </li>
                <li class="<?php echo $currentPage == 'status.php' ? 'active' : ''; ?>">
                  <a href="status.php" class="nav-link text-left">Booking Status</a>
                </li>
                <li class="<?php echo $currentPage == 'contact.php' ? 'active' : ''; ?>">
                  <a href="contact.php" class="nav-link text-left">Contact</a>
                </li>
                <li >
                  
                </li>
              </ul>                                                                                                                                                                                                                                                                                         </ul>
            </nav>

          </div>
         
        </div>
      </div>

    </div>
    
    </div>