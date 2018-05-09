<?php
defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

//language
$lang_code_array=explode('-',$this->language);
$lang_code=$lang_code_array[0];

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');
$menu = $app->getMenu();

$config = JFactory::getConfig();
$abspath=$config->get( 'abs_path' );

//home?
$homepage=false;
if(@$menu->getActive()->home==1){
	$homepage=true;
}

require_once JPATH_BASE.'/global_functions.php';
require_once JPATH_BASE.'/mobile_detect.php';
$mobile_detect = new Mobile_Detect;

// Load optional RTL Bootstrap CSS
//JHtml::_('bootstrap.loadCss', false, $this->direction);

//remove joomla generator and cotrol some meta
$this->setGenerator(null);

//local db
$db = JFactory::getDbo();

//newsletter
if(@$_REQUEST['newsletter_email']!=''){
	if (@$_REQUEST['g-recaptcha-response']=='') {
      echo '<script>alert(\''.($lang_code=='en'?'There was problem with the CAPTCHA code':'Υπήρξε πρόβλημα κατά τον έλεγχο του CAPTCHA').'\')</script>';
    } else {
      $query = "SELECT id FROM #__newsletters WHERE email='" . addslashes(@$_REQUEST['newsletter_email']) . "' LIMIT 1";
      $db->setQuery($query);
      $newsletter_exists = $db->loadResult();
      if ($newsletter_exists > 0) {
        echo '<script>alert(\'' . ($lang_code == 'en' ? 'There was problem with your subscription' : 'Υπήρξε πρόβλημα κατά την εγγραφή σας στο newsletter') . '\')</script>';
      }
      else {
        $query = "INSERT INTO #__newsletters VALUES ('','" . addslashes(@$_REQUEST['newsletter_email']) . "', 1, '" . time() . "') ";
        $db->setQuery($query);
        $db->execute();
        echo '<script>alert(\'' . ($lang_code == 'en' ? 'Thank you for your subscription' : 'Το email σας καταχωρίστηκε επιτυχώς') . '\')</script>';
      }
    }
}

//get menu item notes
$note='';
$query = "SELECT note FROM #__menu WHERE id='".@$_REQUEST['Itemid']."' ";
$db->setQuery($query);
$note = $db->loadResult();
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo $lang_code; ?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?php echo $lang_code; ?>"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?php echo $lang_code; ?>"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="<?php echo $lang_code; ?>">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <jdoc:include type="head" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/dist/styles.css">
    <link rel="stylesheet" href="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/css/overwrite.css">
    <link rel="stylesheet" href="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/css/jquery-ui-timepicker-addon.css">
    <link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/css/jquery.tokenize.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,700&subset=latin,greek' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <?php unset($this->_scripts[$this->baseurl.'/templates/'.$this->template.'/js/template.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/jui/js/bootstrap.min.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/system/js/caption.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/jui/js/jquery-migrate.min.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/jui/js/jquery-noconflict.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/jui/js/jquery.min.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/com_attachments/js/attachments_refresh.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/system/js/core.js']); ?>
    <?php unset($this->_scripts[$this->baseurl.'/media/system/js/mootools-core.js']); ?>
    <?php unset($this->_styleSheets[$this->baseurl.'/media/mod_languages/css/template.css']); ?>
    <?php unset($doc->_scripts[JURI::root(true).'/media/system/js/frontediting.js']);?>
    <?php unset($doc->_scripts[JURI::root(true).'/media/system/js/html5fallback.js']);?>
	<?php
		if($homepage){
			//meta tags
			$menuname = $menu->getActive()->title;
			$article_image='http://www.synathina.gr/images/template/synathina_big.jpg';
			$doc = JFactory::getDocument();
			$doc->setMetaData( 'twitter:card', 'summary_large_image' );
			$doc->setMetaData( 'twitter:site', '@synathina' );
			$doc->setMetaData( 'twitter:title', 'συνΑθηνά' );
			$doc->setMetaData( 'twitter:description', $menuname );
			$doc->setMetaData( 'twitter:image', $article_image );
		}
	?>
    <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/modernizr-custom.js"></script>
		<!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-80529761-1', 'auto');
        ga('send', 'pageview');
    </script>
	<!-- End Google Analytics -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/dist/site.js"></script>
</head>

<body>
    <div class="container-grid container-grid--wrapper">
        <header class="l-header">
            <div class="l-header__logo">
                <div class="logo-container">
                    <a href="<?php echo $lang_code;?>/" class="logo logo-all" alt="συνΑθηνά">
                        <img src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/img/icons/synathina_logo.png" alt="" />
                    </a>
                </div>
            </div>
            <div class="l-header__nav">
                <a class="l-header__nav__logo"><img class="img-responsive" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/img/icons/synathina_logo_new.png" /></a>
                <jdoc:include type="modules" name="mainmenu" style="none" class="l-header__nav__menu menu menu--inline"/>
            </div>
            <div class="l-header__actions">
                <ul class="i18n-actions">
                    <li><a>ελ</a></li>
                    <li><a>en</a></li>
                    <!-- jdoc:include type="modules" name="localesmenu" style="none" /-->
                </ul>
                <ul class="account-actions inline-list--separated">
                    <li><a>Είσοδος</a></li>
                    <li><a>Εγγραφή</a></li>
                </ul>
                <ul class="synathina-actions menu">
                    <li><a>Καταχώρηση Δράσης</a></li>
                    <li><a>Καταχώρηση Open Call</a></li>
                </ul>
            </div>
            <div class="l-header__hambuger">
                <a class="hamburger hamburger--squeeze <?=($homepage&&!$mobile_detect->isMobile()?'is-active':'')?>" rel="js-toggle-menu">
                    <div class="hamburger-box ">
                        <div class="hamburger-inner"></div>
                    </div>
                </a>
            </div>
        </header>
        <main style="background-color: #fff; position:relative;" class="l-main">
            <div class="browser-message" rel="js-browser-message">
                <p>😢 Λυπούμαστε, προς το παρών δεν υποστηρίζουμε IE 11 και παλαιότερους browser, παρακαλώ επιλέξτε συγχρονους browser οπως firefox, chrome, safari, Microsoft edge.</p>
            </div>
            <?php if($homepage){ ?>
            <div class="l-homepage">
                <div class="clip-circle"></div>
                <div id="map" class="synathina-map synathina-map--blur"></div>
                <div class="bg"></div>
                <div id="coords"></div>
                <div class="cross" rel="js-cross">
                    <div class="inner">
                        <div class="cross-side cross-side--top">
                            <div class="cross-content">
                            <div class="is-tablecell" rel="js-population">
                                <span class="cross-side-title">
                                <strong>1<sup>o</sup></strong></span>
                                <span class="cross-side-desc">πληθυσμός</span>
                            </div>
                            </div>
                        </div>
                        <div class="cross-side cross-side--left"></div>
                        <div class="cross-side cross-side--center" >
                            <div class="cross-content">
                            <div class="is-tablecell" rel="js-teams">
                                    8 <br> ομάδες
                            </div>
                            </div>
                        </div>
                        <div class="cross-side cross-side--right">
                            <div class="cross-content">
                            <div class="is-tablecell" rel="js-activities">
                                12 <br> δρασεις
                            </div>
                            </div>
                        </div>
                        <div class="cross-side cross-side--bottom"></div>
                    </div>
                </div>
                <div class="time">
                    <div class="time-space">
                        <ul>
                            <li class="jan"><span>2014</span></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li class="jan"><span>2015</span></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li class="jan"><span>2016</span></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li class="jan"><span>2017</span></li>
                            <div class="time-bar"></div>
                        </ul>

                    </div>
                    <div id="slider3" class="d3-slider d3-slider-horizontal time-slider" rel="js-range-slider">
                    </div>
                </div>
                <div class="categories is-open" rel="js-toggle-categories js-create-categories">
                    <div class="inner">
                        <div id="filters-closed"><?=($lang_code=='en'?'THEMATICS':'ΘΕΜΑΤΙΚΕΣ')?> <span id="filters-closed-x">X</span></div>
                        <form action="">
                        </form>
                    </div>
                </div>
                <div class="debug-values module-debug">
                    <span id="slider3textmin"></span>
                    <span id="slider3textmax"></span>
                </div>
                <div class="l-homepage__featured" rel="js-drawer">
                    <div class="is-relative">
                        <div class="c-featured" rel="js-mobile-gallery">
                            <div class="featured-item c-featured__super featured-item--with-filter" style="background-image: url(/images/synathina_featured_main.jpg)">
                                <div>
                                    <h3 class="featured-item-title">
                                        Πώς λειτουργεί η υποστήριξη στην ιστοσελίδα του συνΑθηνά
                                    </h3>
                                    <p class="featured-item-description">
                                        H διασύνδεση ανάμεσα σε όσους υλοποιούν δράσεις για τη βελτίωση της ποιότητας ζωής στην πόλη και σε όσους επιθυμούν να υποστηρίξουν αυτές τις δράσεις
                                    </p>
                                    <a class="featured-item-cta ">ΔΙΑΒΑΣΤΕ ΠΕΡΙΣΣΟΤΕΡΑ</a>
                                </div>
                            </div>
                            <div class="featured-item c-featured__first featured-item--with-filter" style="background-image: url(/images/featured_hands.jpg)">
                                <div>
                                    <h3 class="featured-item-title">
                                        Πώς λειτουργεί η υποστήριξη στην ιστοσελίδα του συνΑθηνά
                                    </h3>
                                    <p class="featured-item-description">
                                        H διασύνδεση ανάμεσα σε όσους υλοποιούν δράσεις για τη βελτίωση της ποιότητας ζωής στην πόλη και σε όσους επιθυμούν να υποστηρίξουν αυτές τις δράσεις
                                    </p>
                                    <a class="featured-item-cta">ΔΙΑΒΑΣΤΕ ΠΕΡΙΣΣΟΤΕΡΑ</a>
                                </div>
                            </div>
                            <div class="featured-item c-featured__second featured-item--with-filter" style="background-image: url(/images/featured_hands.jpg)">
                                <div>
                                    <h3 class="featured-item-title">
                                        Πώς λειτουργεί η υποστήριξη στην ιστοσελίδα του συνΑθηνά
                                    </h3>
                                    <p class="featured-item-description">
                                        H διασύνδεση ανάμεσα σε όσους υλοποιούν δράσεις για τη βελτίωση της ποιότητας ζωής στην πόλη και σε όσους επιθυμούν να υποστηρίξουν αυτές τις δράσεις
                                    </p>
                                    <a class="featured-item-cta">ΔΙΑΒΑΣΤΕ ΠΕΡΙΣΣΟΤΕΡΑ</a>
                                </div>
                            </div>
                            <div class="featured-item c-featured__third featured-item--with-filter" style="background-image: url(/images/featured_hands.jpg)">
                                <div>
                                    <h3 class="featured-item-title">
                                        Πώς λειτουργεί η υποστήριξη στην ιστοσελίδα του συνΑθηνά
                                    </h3>
                                    <p class="featured-item-description">
                                        H διασύνδεση ανάμεσα σε όσους υλοποιούν δράσεις για τη βελτίωση της ποιότητας ζωής στην πόλη και σε όσους επιθυμούν να υποστηρίξουν αυτές τις δράσεις
                                    </p>
                                    <a class="featured-item-cta">ΔΙΑΒΑΣΤΕ ΠΕΡΙΣΣΟΤΕΡΑ</a>
                                </div>
                            </div>
                            <div class="featured-item c-featured__fourth featured-item--with-filter" style="background-image: url(/images/featured_hands.jpg)">
                                <div>
                                    <h3 class="featured-item-title">
                                        Πώς λειτουργεί η υποστήριξη στην ιστοσελίδα του συνΑθηνά
                                    </h3>
                                    <p class="featured-item-description">
                                        H διασύνδεση ανάμεσα σε όσους υλοποιούν δράσεις για τη βελτίωση της ποιότητας ζωής στην πόλη και σε όσους επιθυμούν να υποστηρίξουν αυτές τις δράσεις
                                    </p>
                                    <a class="featured-item-cta">ΔΙΑΒΑΣΤΕ ΠΕΡΙΣΣΟΤΕΡΑ</a>
                                </div>
                            </div>
                        </div>
                        <div class="feature-toggler">
                            <span class="feature-toggler-arrow"></span>
                            <a rel="js-toggle-drawer" class="feature-toggler-label">ΔΕΙΤΕ ΤΟΝ ΧΑΡΤH</a>
                        </div>
                    </div>
                </div>
            </div>
                <?php } ?>
                <?php if ($this->countModules('banner')) : ?>
                    <div class="banner">
                        <jdoc:include type="modules" name="banner" style="banner" />
                    </div>
                <?php endif; ?>

                <jdoc:include type="component" />
            <?php if(!$homepage) { ?>
                <br /><br />
            <?php } ?>
        </main>
        <footer class="l-footer">
            <div class="l-footer__sponsors nav-extra-links">
                <a href="http://www.bloomberg.org/" target="_blank"><img src="/images/extra_links/bloomberg_img.png" alt="bloomberg img"></a>
                <a href="http://mayorschallenge.bloomberg.org/" target="_blank"><img src="/images/extra_links/mayor_chalenge_img.png" alt="mayor chalenge img"></a>
                <img src="/images/synathina_espa_logos_gr.png" width="100%" class="eu-logo">
			</div>
            <div class="l-footer__menus">
                <ul class="menu nav-site-com" rel="js-footer-menu-item">
                    <li><a href="/el/eπικοινωνία.html">Eπικοινωνία</a></li>
                    <li><a href="#newsletter-message" class="newsletter-tooltip">Newsletter</a></li>
                    <li><a href="/el/βοήθεια.html">Βοήθεια</a></li>
                </ul>
                <div class="nav-social-links" rel="js-footer-menu-item">
                    <a href="https://www.facebook.com/SunAthina" target="_blank"><i class="fa fa-facebook"></i></a>
                    <a href="https://twitter.com/synathina" target="_blank"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.instagram.com/synathina" target="_blank"><i class="fa fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/synathina" target="_blank"><i class="fa fa-linkedin"></i></a>
                    <a href="https://www.youtube.com/channel/UCgA-jpbuZG4YMuQE5GGewZA" target="_blank"><i class="fa fa-youtube"></i></a>
                </div>
                <div class="l-footer__menus__dropdown hidden" rel="js-create-footer-menu">
                    <div id="footer-dropdown-menu" class="dropdown" rel="js-close-footer-menu">
                        <ul class="menu menu--vertical"></ul>
                    </div>
                    <button class="button btn btn--coral btn--bold btn btn-primary validate" rel="js-toggle-footer-drown">Επικοινωνια</button>
                </div>
            </div>
        </footer>
        <nav class="mobile-menu" rel="js-mobile-menu">
            <ul class="mobile-menu__list menu">
                <a class="mobile-menu-close" rel="js-mobile-menu-close"></a>
                <li><a href="">Αρχική</a></li>
                <li>
                    <a>συνΑθηνά</a>
                    <ul class="menu">
                        <li><a href="http://#">Σχετικά με Εμάς</a></li>
                        <li><a href="http://#">Στατιστικά</a></li>
                        <li><a href="http://#">Δίκτυο</a></li>
                    </ul>
                </li>
                <li><a href="">Αρχική</a></li>
                <li><a href="">Αρχική</a></li>
                <li>
                    <a>συνΑθηνά</a>
                    <ul class="menu">
                        <li><a href="http://#">Σχετικά με Εμάς</a></li>
                        <li><a href="http://#">Στατιστικά</a></li>
                        <li><a href="http://#">Δίκτυο</a></li>
                    </ul>
                </li>
                <li><a href="">Αρχική</a></li>
                <li><a href="">Αρχική</a></li>
                <li>
                    <a>συνΑθηνά</a>
                    <ul class="menu">
                        <li><a href="http://#">Σχετικά με Εμάς</a></li>
                        <li><a href="http://#">Στατιστικά</a></li>
                        <li><a href="http://#">Δίκτυο</a></li>
                    </ul>
                </li>
                <li><a href="">Αρχική</a></li>
            </ul>
        </nav>
    </div>
    <div class="module module--synathina module--popup mfp-hide" id="newsletter-message" style="margin: 0px auto;">
        <div class="module-skewed">
            <!-- Content Module -->
            <div class="newsletter">
                <h3 class="popup-title">Newsletter</h3>
                <form action="<?php echo JURI::current();?>" class="form form-inline" method="post">
                    <label class="is-block newsletter-label form-label"><strong><?php echo JText::_('MOD_NEWSLETTER'); ?></strong></label>
                    <div class="form-group">
                        <input type="email" name="newsletter_email" style="min-width:200px;" placeholder="<?php echo JText::_('MOD_NEWSLETTER_EMAIL'); ?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--coral btn--bold"><?php echo JText::_('MOD_NEWSLETTER_SUBMIT'); ?></button>
                    </div>
            <?php if (!$config->get('dev_mode')) { ?>
                    <div class="g-recaptcha" data-sitekey="6Ld4fykUAAAAAHJhqJLKxvf8k0gRWVQIjPtnTcuD"></div>
            <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <jdoc:include type="modules" name="opencall" style="none" />
    <script>
        window.jQuery || document.write('<script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>
    <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery-ui.min.js"></script>
    <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/eventemitter2.js"></script>
    <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/_plugins.js"></script>
    <?php if($homepage) { ?>
        <!-- IF in home page load application source files and dependecies -->
        <!-- Application Dependecies-->
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/togeojson.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/d3.min.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/crossfilter.min.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/dc.min.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/d3.slider.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/markerclusterer.js"></script>
        <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/slick.min.js"></script>
        <script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAn_Z73vSnRqhaPNt76B8e_156YxREMefU&callback=initMap&libraries=geometry"></script>
        <!-- Application -->
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/filter.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/ajax.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/app.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/categories.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/window.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/map.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/areas.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/activity.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/ui.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/cross<?=$lang_code=='en'?'_en':''?>.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/app/slider.js"></script>

    <?php } else { ?>
        <!-- ELSE load web site source files and dependecies -->
        <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/dev_menu.js"></script>
        <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/slick.min.js"></script>
        <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery.magnific-popup.min.js"></script>
        <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jscrollpane.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/site/main.js"></script>
        <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/ui.js"></script>
    <?php 	} ?>
	<script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/vendor/jquery.tokenize.js"></script>
    <script src="<?php echo JUri::base(); ?>templates/<?php echo $this->template; ?>/js/site/extra.js"></script>

    <script>
        $body = $("body");

        $(document).on({
            ajaxStart: function() { $body.addClass("loading");    },
            ajaxStop: function() { $body.removeClass("loading"); }
        });

        $(document).ready(function(){
            $(function(){
                $('.more-articles-button').on('click', function(e){

                    e.preventDefault();
                    var counter=$('.articles_counter').val();
                    var extralink=$('.article_url_parameter').val();
                    var itemid=$('.articles_itemid').val();
                    var counter_all=$('.all_articles_counter').val();
                    var catid=$('.param_catid').val();
                    $.ajax({
                        url: '<?php echo JUri::base(); ?>more_articles.php',
                        type: 'post',
                        data: {'lang':'<?php echo $this->language; ?>', 'counter':counter, 'catid':catid, 'extralink':extralink, 'itemid':itemid},
                        success: function(data, status) {
                            if(data != "") {
                                $('.more-articles').before(data);
                                setTimeout(function(){
                                    $( ".more--articles" ).removeClass( "more--articles-hidden" )
                                }, 300);
                                $('.articles_counter').val(parseInt(counter)+4);
                                if(parseInt(parseInt(counter)+4)>=parseInt(counter_all)){
                                    $('.more-articles-button').css('visibility','hidden');
                                }
                            }
                        },
                        error: function(xhr, desc, err) {
                        }
                    }); // end ajax call
                });
            });

        });

        $(document).ready(function(){
            target = $('[rel="js-show-category-types"]');
            inputs = $('#member-registration').find(' > .form-group > input ');

            $.each(inputs, function(i, elem){
                alert(elem);
                $(elem).checkValue;
            });
        });
        <?php
            if(@$note=='teams' && !$mobile_detect->isMobile()){
        ?>
        $( document ).ready(function() {
            $(function() {
                $( document ).tooltip({
                    position: {
                        my: "center bottom",
                        at: "center bottom"
                    }
                });
            });
        });
        <?php
            }
        ?>
</script>

<div class="modal"><!-- Place at bottom of page --></div>
</body>
</html>
