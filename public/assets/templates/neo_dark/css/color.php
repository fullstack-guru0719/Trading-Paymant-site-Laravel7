<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}


function checkhexcolor2($secondColor){
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?>




body, .modal-content-bg, .user-sidebar.style--xl, .form-control,.header-section.header-fixed {
	background-color: <?php echo $secondColor;?> !important;
}

.footer-section::before, .cmn-accordion.style--two .card-header .acc-btn::after,.base--bg,*::-webkit-scrollbar-button,*::-webkit-scrollbar-thumb,::selection   {
    background-color: <?php echo $color;?> !important;
}

.footer-widget .social-links li a:hover , .social-links li a:hover , .testimonial-single i, .pricing-item__header .package__price , .btn-primary, .overview-item span, .feature-thumb.icon, 
.feature--item.active .feature-content .title, .feature--item:hover .feature-content .title, .nav-tabs li a.color-one, .nav-tabs li a.color-one , .nav-tabs li a.color-two , .single-post__footer .share a:hover, .captcha span, .contact-item .icon ,.inner-hero-content .page__breadcums a,.privacy-links li a:hover, .base--color,.work-item .work-icon i,.work-item .work-content .sub-title {
	color: <?php echo $color;?> !important;
}

.btn-primary:hover {
    color: #fff;
}
.footer-bottom{
    border-top: 1px solid <?php echo $color;?>63;
}
.header-top {
    padding-top: 10px;
    padding-bottom: 15px;
    border-bottom: 1px solid <?php echo $color;?>50;
}
.work-item .work-icon::before {
    border: 2px dashed <?php echo $color;?>;
}
@media (max-width: 1199px){

    .navbar-toggler {
        margin-right: 0px;
    }
    .header-section {
        background-color: <?php echo $secondColor;?>;
    }
}

.inner-hero-section{
    border-bottom: 5px solid <?php echo $color;?>;
}

.list-group-item, .referral-form .input-group-text {
    border: 1px solid <?php echo $color;?>20;
}
.hero-section {
    border-bottom: 5px solid <?php echo $color;?>;
}
.cmn-btn, .referral-form .input-group-text {
    background: <?php echo $color;?>;
}

.cookie__wrapper{
    background: <?php echo $secondColor;?>
}