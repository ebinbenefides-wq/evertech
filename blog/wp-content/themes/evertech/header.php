<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>
    <?php 
    if ( is_single() ) {
        wp_title( '|', true, 'right' );
        bloginfo( 'name' );
    } else {
        bloginfo( 'name' );
        wp_title( '|', true, 'left' );
    }
    ?>
</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri();?>/assets/images/icon.png">

    <!-- CSS
	============================================ -->

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/plugins/all.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/plugins/flaticon.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/plugins/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/plugins/aos.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/plugins/magnific-popup.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/custom.css">


    <!--====== Use the minified version files listed below for better performance and remove the files listed above ======-->
    <!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/vendor/plugins.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/style.min.css"> -->

</head>

<body>

    <div class="main-wrapper">


        <!-- Preloader start -->
        
        <!-- Preloader End -->

        <!-- Header Start  -->
<div id="header" class="section header-section">

<div class="container">

    <!-- Header Wrap Start  -->
    <div class="header-wrap">

        <div class="header-logo">
            <a href="https://evertechme.com/"><img src="<?php echo get_template_directory_uri();?>/assets/images/logo-black.png" alt=""></a>
        </div>

        <div class="header-menu d-none d-lg-block">
            <ul class="main-menu">
                <li class="index">
                    <a href="https://evertechme.com/">Home</a>
                    
                </li>
                <li class="about">
                    <a href="https://evertechme.com/about.html">About Us</a>
                </li>
                <li class="products">
                    <a href="https://evertechme.com/index.html#products">Products</a>
                </li>

                <li class="service">
                    <a href="#">Services</a>
                    <ul class="sub-menu">
                        <li>
                            <a href="javascript:void(0);" class="master-link">IT Services</a>
                            <ul class="sub-menu">
                                <li><a href="https://evertechme.com/ainfrastructure-services.html">Network Infrastructure Service</a></li>
                                <li><a href="https://evertechme.com/avirtualization.html">Virtualization Services</a></li>
                                <li><a href="https://evertechme.com/adata-center.html">Data Center and Cloud Services</a></li>
                                <li><a href="https://evertechme.com/ainfrastructure-monitoring.html">IT Infrastructure Monitoring</a></li>
                                <li><a href="https://evertechme.com/amanaged-it.html">Managed IT Services</a></li>
                                <li><a href="https://evertechme.com/aamc.html">Annual Maintenance Contract</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="master-link">Cyber Security Services</a>
                            <ul class="sub-menu">
                                <li><a href="https://evertechme.com/asecurity-assurance.html">Security Assurance Solutions</a></li>
                                <li><a href="https://evertechme.com/asecurity-consultancy.html">Security Consultancy</a></li>
                                <li><a href="https://evertechme.com/awareness-trainings.html">Awareness Trainings</a></li>
                                <li><a href="https://evertechme.com/password-management.html">Password Management Solutions</a></li>
                                <li><a href="https://evertechme.com/security-solutions.html">Security Solutions</a></li>
                                <li><a href="https://evertechme.com/dfir.html">Digital Forensics and Incident Response</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="master-link">Other Services</a>
                            <ul class="sub-menu">
                                <li><a href="https://evertechme.com/cctv-installation.html">CCTV Installation & Security Risk Assessment</a></li>
                                <li><a href="https://evertechme.com/website-development.html">Website Designing and Development</a></li>
                                <li><a href="https://evertechme.com/software-solutions.html">Software Solutions</a></li>
                                <li><a href="https://evertechme.com/license-and-compliance.html">License and Compliance Solutions</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                
                
                <li class="blog active-menu"><a href="https://evertechme.com/blog">Blog</a></li>
                <li class="contact"><a href="https://evertechme.com/contact.html">Contact</a></li>
            </ul>
        </div>

        <!-- Header Meta Start -->
        <div class="header-meta">
            
            

            <div class="header-btn d-none d-xl-block">
                <a class="btn" href="https://evertechme.com/contact.html">Get Started</a>
            </div>
            <!-- Header Toggle Start -->
            <div class="header-toggle d-lg-none">
                <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <!-- Header Toggle End -->
        </div>
        <!-- Header Meta End  -->

    </div>
    <!-- Header Wrap End  -->

</div>
</div>
<!-- Header End -->

<!-- back to top start -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- back to top end -->

<!-- Offcanvas Start-->
<div class="offcanvas offcanvas-start" id="offcanvasExample">
    <div class="offcanvas-header">
        <!-- Offcanvas Logo Start -->
        <div class="offcanvas-logo">
            <a href="index.html"><img src="<?php echo get_template_directory_uri();?>/assets/images/logo-white.png" alt=""></a>
        </div>
        <!-- Offcanvas Logo End -->
        <button type="button" class="close-btn" data-bs-dismiss="offcanvas"><i class="flaticon-close"></i></button>
    </div>

    <!-- Offcanvas Body Start -->
    <div class="offcanvas-body">
        <div class="offcanvas-menu">
            <ul class="main-menu">
                <li class="active-menu">
                    <a href="https://evertechme.com/index.html">Home</a>
                    
                </li>
                <li>
                    <a href="https://evertechme.com/about.html">About Us</a>
                </li>
                
                <li class="service">
                    <a href="#">Services</a>
                    <ul class="sub-menu">
                        <li>
                            <a href="javascript:void(0);" class="master-link">IT Services</a>
                            <ul class="sub-menu">
                                <li><a href="https://evertechme.com/ainfrastructure-services.html">Network Infrastructure Service</a></li>
                                <li><a href="https://evertechme.com/avirtualization.html">Virtualization Services</a></li>
                                <li><a href="https://evertechme.com/adata-center.html">Data Center and Cloud Services</a></li>
                                <li><a href="https://evertechme.com/ainfrastructure-monitoring.html">IT Infrastructure Monitoring</a></li>
                                <li><a href="https://evertechme.com/amanaged-it.html">Managed IT Services</a></li>
                                <li><a href="https://evertechme.com/aamc.html">Annual Maintenance Contract</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="master-link">Cyber Security Services</a>
                            <ul class="sub-menu">
                                <li><a href="https://evertechme.com/asecurity-assurance.html">Security Assurance Solutions</a></li>
                                <li><a href="https://evertechme.com/asecurity-consultancy.html">Security Consultancy</a></li>
                                <li><a href="https://evertechme.com/awareness-trainings.html">Awareness Trainings</a></li>
                                <li><a href="https://evertechme.com/password-management.html">Password Management Solutions</a></li>
                                <li><a href="https://evertechme.com/security-solutions.html">Security Solutions</a></li>
                                <li><a href="https://evertechme.com/dfir.html">Digital Forensics and Incident Response</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="master-link">Other Services</a>
                            <ul class="sub-menu">
                                <li><a href="https://evertechme.com/cctv-installation.html">CCTV Installation & Security Risk Assessment</a></li>
                                <li><a href="https://evertechme.com/website-development.html">Website Designing and Development</a></li>
                                <li><a href="https://evertechme.com/software-solutions.html">Software Solutions</a></li>
                                <li><a href="https://evertechme.com/license-and-compliance.html">License and Compliance Solutions</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="https://evertechme.com/blog">Blog</a></li>
                <li><a href="https://evertechme.com/contact.html">Contact</a></li>
            </ul>
        </div>
    </div>
    <!-- Offcanvas Body End -->
</div>
<!-- Offcanvas End -->

<!-- Page Banner Start -->
<div class="section page-banner-section blog-header" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/images/blog-bg.jpg);">
            <div class="shape-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="944px" height="894px">
                    <defs>
                        <linearGradient id="PSgrad_0" x1="88.295%" x2="0%" y1="0%" y2="46.947%">
                            <stop offset="0%" stop-color="rgb(67,186,255)" stop-opacity="1" />
                            <stop offset="100%" stop-color="rgb(113,65,177)" stop-opacity="1" />
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(43, 142, 254)" d="M39.612,410.76 L467.344,29.824 C516.51,-13.476 590.638,-9.93 633.938,39.613 L914.192,317.344 C957.492,366.50 953.109,440.637 904.402,483.938 L476.671,864.191 C427.964,907.492 353.376,903.109 310.76,854.402 L29.823,576.670 C-13.477,527.963 -9.94,453.376 39.612,410.76 Z" />
                    <path fill="url(#PSgrad_0)" d="M39.612,410.76 L467.344,29.824 C516.51,-13.476 590.638,-9.93 633.938,39.613 L914.192,317.344 C957.492,366.50 953.109,440.637 904.402,483.938 L476.671,864.191 C427.964,907.492 353.376,903.109 310.76,854.402 L29.823,576.670 C-13.477,527.963 -9.94,453.376 39.612,410.76 Z" />
                </svg>
            </div>
            <div class="shape-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="726.5px" height="726.5px">
                    <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" opacity="0.302" fill="none" d="M28.14,285.269 L325.37,21.217 C358.860,-8.851 410.655,-5.808 440.723,28.14 L704.777,325.36 C734.846,358.859 731.802,410.654 697.979,440.722 L400.955,704.776 C367.132,734.844 315.338,731.802 285.269,697.978 L21.216,400.954 C-8.852,367.132 -5.808,315.337 28.14,285.269 Z" />
                </svg>
            </div>
            <div class="shape-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="515px" height="515px">
                    <defs>
                        <linearGradient id="PSgrad_0" x1="0%" x2="89.879%" y1="0%" y2="43.837%">
                            <stop offset="0%" stop-color="rgb(67,186,255)" stop-opacity="1" />
                            <stop offset="100%" stop-color="rgb(113,65,177)" stop-opacity="1" />
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(43, 142, 254)" d="M19.529,202.280 L230.531,14.698 C254.559,-6.661 291.353,-4.498 312.714,19.528 L500.295,230.531 C521.656,254.558 519.493,291.353 495.466,312.713 L284.463,500.295 C260.436,521.655 223.641,519.492 202.281,495.465 L14.699,284.462 C-6.660,260.435 -4.498,223.640 19.529,202.280 Z" />
                    <path fill="url(#PSgrad_0)" d="M19.529,202.280 L230.531,14.698 C254.559,-6.661 291.353,-4.498 312.714,19.528 L500.295,230.531 C521.656,254.558 519.493,291.353 495.466,312.713 L284.463,500.295 C260.436,521.655 223.641,519.492 202.281,495.465 L14.699,284.462 C-6.660,260.435 -4.498,223.640 19.529,202.280 Z" />
                </svg>
            </div>
            <div class="shape-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="972.5px" height="970.5px">
                    <path fill-rule="evenodd" stroke="rgb(255, 255, 255)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" fill="none" d="M38.245,381.102 L435.258,28.158 C480.467,-12.32 549.697,-7.964 589.888,37.244 L942.832,434.257 C983.23,479.466 978.955,548.697 933.746,588.888 L536.733,941.832 C491.524,982.23 422.293,977.955 382.103,932.745 L29.158,535.732 C-11.32,490.523 -6.963,421.293 38.245,381.102 Z" />
                </svg>
            </div>
            <div class="container">
                <div class="page-banner-wrap">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Page Banner Content Start -->
                            <div class="page-banner text-center">
                                <h2 class="title">Blog</h2>
                                
                            </div>
                            <!-- Page Banner Content End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Banner End -->