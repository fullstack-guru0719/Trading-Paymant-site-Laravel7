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

.base--color,.header .main-menu li a:hover, .header .main-menu li a:focus,.page-breadcrumb li:first-child::before,.page-breadcrumb li a:hover,.d-widget .icon{
    color: <?php echo $color; ?> !important;
}

.border-btn:hover, .cmn-btn, .cmn-btn:hover,.base--bg, .team-card:hover, .subscribe-form .subscribe-btn, .pagination li.disabled .page-link,.pagination li .page-link:hover, .pagination li.active .page-link, .contact-item, .header .main-menu li .sub-menu,.d-widget,.investor-card:hover,.blog-details__footer .social__links li a:hover,.sidebar .widget .widget__title::after,select option, .account-menu .icon i,.account-menu .icon .account-submenu{
    background-color: <?php echo $color; ?> !important;
}

.border-btn:hover,.package-card, .page-item.disabled .page-link,.pagination li .page-link:hover, .pagination li.active .page-link {
    border-color: <?php echo $color; ?>;
}

.investor-card:hover {
    box-shadow: 0 5px 10px 5px <?php echo $color; ?>80;
}
.package-card, .package-card:hover {
    box-shadow: 0 5px 15px <?php echo $color; ?>80;
}

.package-card__features li {
    border-bottom: 1px solid <?php echo $color; ?>59;
}
.profit-calculator-wrapper {
    border: 2px solid <?php echo $color; ?>80;
    box-shadow: 0 0 15px <?php echo $color; ?>80;
}
select {
    border: 1px solid <?php echo $color; ?>73;
}
input[type="text"]:read-only, input[type="email"]:read-only, input[type="text"]:disabled, input[type="email"]:disabled {
    border-color: <?php echo $color; ?>;
}

.work-card__icon {
    border: 3px solid <?php echo $color; ?>;
    box-shadow: 0 0 15px 3px <?php echo $color; ?>a6;
}

.work-card__icon .step-number {
    border: 2px solid <?php echo $color; ?>;
}
.work-item::before {
    border-top: 1px dashed <?php echo $color; ?>;
}

.cmn-accordion .card-header .btn {
    background-color: <?php echo $color; ?>;
}

.testimonial-card {
    background-color: <?php echo $color; ?>a6;
    box-shadow: 0 5px 0px <?php echo $color; ?>;
}

.card .card-header {
    background-color: <?php echo $color; ?>;
}

.cmn-accordion .card-header {
    border: 1px solid <?php echo $color; ?>73;
}
.testimonial-card__content {
    border-bottom: 1px solid <?php echo $color; ?>80;
}

.testimonial-card__client .thumb {
    border: 3px solid <?php echo $color; ?>;
}
.testimonial-slider .slick-dots li.slick-active button {
    background-color: <?php echo $color; ?>;
}
.team-card:hover {
    background-color: <?php echo $color; ?>;
    box-shadow: 0 5px 10px 5px <?php echo $color; ?>80;
}
.nav-tabs.custom--style-two .nav-item .nav-link.active {
    border-color: <?php echo $color; ?>;
    background-color: <?php echo $color; ?>;
}
.nav-tabs.custom--style-two .nav-item .nav-link {
    border: 1px solid <?php echo $color; ?>73;
}
.table.style--two thead {
    background-color: <?php echo $color; ?>;
}
.table.style--two tr th, .table.style--two tr td {
    border-top-color: <?php echo $color; ?>40;
}
.table.style--two {
    box-shadow: 0 5px 5px 0 <?php echo $color; ?>40;
}
.border-top-1 {
    border-top: 1px solid <?php echo $color; ?>80;
}
.cta-wrapper {
    box-shadow: 0 3px 15px <?php echo $color; ?>80;
}
.brand-item {
    border: 2px solid <?php echo $color; ?>80;
}
.blog-card {
    box-shadow: 0 0 0px 2px <?php echo $color; ?>cc;
}
.form-control {
    border: 1px solid <?php echo $color; ?>73;
}
.form-control:focus {
    box-shadow: 0 2px 5px <?php echo $color; ?>80;
    border-color: <?php echo $color; ?>;
}
.footer {
    border-top: 2px solid <?php echo $color; ?>80;
}
.scroll-to-top {
    background-color: <?php echo $color; ?>;
}
.subscribe-wrapper {
    box-shadow: 0 0 10px <?php echo $color; ?>80;
}
.choose-card {
    background-color: <?php echo $secondColor; ?>80;
}
.pagination li .page-link {
    border: 1px solid <?php echo $color; ?>73;
}
a:hover {
    color: <?php echo $color; ?>;
}
.contact-item {
    box-shadow: 0 5px 15px <?php echo $color; ?>80;
}
.account-card {
    box-shadow: 0 0 10px 2px <?php echo $color; ?>73;
}
.account-card__header {
    padding: 50px 30px;
    border-bottom: 2px solid <?php echo $color; ?>80;
}
input[type="text"]:read-only, input[type="email"]:read-only, input[type="text"]:disabled, input[type="email"]:disabled {
    background-color: <?php echo $color; ?>59;
}

#phoneInput .letter {
    border: 1px solid <?php echo $color; ?> !important;
}
#phoneInput .letter + .letter {
    border-left: 1px solid <?php echo $color; ?> !important;
}
.card {
    box-shadow: 0 0 15px <?php echo $color; ?>80;
    background-color: <?php echo $secondColor; ?>;
    border: 2px solid <?php echo $color; ?>80;
}
.list-group-item {
    border: 1px dashed <?php echo $color; ?>54;
}
.input-group-text {
    background-color: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}
.footer__bottom, .header.menu-fixed .header__bottom, .profit-calculator-wrapper, .work-card__icon , .work-card__icon .step-number, .table.style--two, .brand-item,.blog-card,.account-card,.sidebar .widget{
    background-color: <?php echo $secondColor; ?>;
}
.sidebar .widget{
    border: 1px solid <?php echo $color; ?>;    
}

.header__bottom {
    background-color: <?php echo $secondColor; ?>80;
}

.cookie__wrapper{
    background: <?php echo $secondColor;?>
}