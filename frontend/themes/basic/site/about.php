<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'About '. Yii::$app->setting->get('siteName');

$css =<<<EOF
body {
    background-color: #f2f2f2;
    font-family: "Lato";
    font-weight: 300;
    font-size: 16px;
    color: #555;
    padding-top: 50px;

    -webkit-font-smoothing: antialiased;
    -webkit-overflow-scrolling: touch;
}

/* Titles */
h1, h2, h3, h4, h5, h6 {
    font-family: "Raleway";
    font-weight: 300;
    color: #333;
}


/* Paragraph & Typographic */
p {
    line-height: 28px;
    margin-bottom: 25px;
}

.centered {
    text-align: center;
}

/* Links */
a {
    color: #3bc492;
    word-wrap: break-word;

    -webkit-transition: color 0.1s ease-in, background 0.1s ease-in;
    -moz-transition: color 0.1s ease-in, background 0.1s ease-in;
    -ms-transition: color 0.1s ease-in, background 0.1s ease-in;
    -o-transition: color 0.1s ease-in, background 0.1s ease-in;
    transition: color 0.1s ease-in, background 0.1s ease-in;
}

a:hover,
a:focus {
    color: #c0392b;
    text-decoration: none;
    outline: 0;
}

a:before,
a:after {
    -webkit-transition: color 0.1s ease-in, background 0.1s ease-in;
    -moz-transition: color 0.1s ease-in, background 0.1s ease-in;
    -ms-transition: color 0.1s ease-in, background 0.1s ease-in;
    -o-transition: color 0.1s ease-in, background 0.1s ease-in;
    transition: color 0.1s ease-in, background 0.1s ease-in;
}

 hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #ccc;
    margin: 1em 0;
    padding: 0;
}


/* ==========================================================================
   Wrap Sections
   ========================================================================== */

#headerwrap {
    background-color: #34495e;
    padding-top: 60px;
}

#headerwrap h1 {
    margin-top: 30px;
    color: white;
    font-size: 70px;
    }

#headerwrap h3 {
    color: white;
    font-size: 30px;
}

#headerwrap h5 {
    color: white;
    font-weight: 700;
    text-align: left;
}

#headerwrap p {
    text-align: left;
    color: white
}

/* intro Wrap */

#intro {
    padding-top: 50px;
    border-top: #bdc3c7 solid 5px;
}

#features {
    padding-top: 50px;
    padding-bottom: 50px;
}

#features .ac a{
    font-size: 20px;
}

/* Showcase Wrap */

#showcase {
    display: block;
    background-color: #34495e;
    padding-top: 50px;
    padding-bottom: 50px;
}

#showcase h1 {
    color: white;
}

#footerwrap {
    background-color: #2f2f2f;
    color: white;
    padding-top: 40px;
    padding-bottom: 60px;
    text-align: left;
}

#footerwrap h3 {
    font-size: 28px;
    color: white;
}

#footerwrap p {
    color: white;
    font-size: 18px;
}

/* Copyright Wrap */

#c {
    background: #222222;
    padding-top: 15px;
    text-align: right;
}

#c p {
    color: white
}
EOF;
$this->registerCss($css);
?>

<!-- Fixed navbar -->
<div id="navigation" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><b><?= Yii::$app->setting->get('siteName') ?></b></a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#home" class="smothscroll">Home</a></li>
        <li><a href="#desc" class="smothscroll">Description</a></li>
        <li><a href="#showcase" class="smothScroll">Showcase</a></li>
        <li><a href="#contact" class="smothScroll">Contact</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>


<section id="home" name="home"></section>
<div id="headerwrap">
    <div class="container">
        <div class="row centered">
            <div class="col-lg-12">
                <h1>Welcome To <b><?= Yii::$app->setting->get('siteName') ?></b></h1>
                <h3><?= Yii::$app->setting->get('siteDescription') ?></h3>
                <br>
            </div>
                        <div class="col-lg-2">
                <h5>Amazing Results</h5>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <img class="hidden-xs hidden-sm hidden-md" src="/assets/img/arrow1.png">
            </div>
            <div class="col-lg-8">
                <img class="img-responsive" src="/assets/img/app-bg.png" alt="">
            </div>
            <div class="col-lg-2">
                <br>
                <img class="hidden-xs hidden-sm hidden-md" src="/assets/img/arrow2.png">
                <h5>Awesome Design</h5>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div>
        </div>
    </div> <!--/ .container -->
</div><!--/ #headerwrap -->


<section id="desc" name="desc"></section>
<!-- INTRO WRAP -->
<div id="intro">
    <div class="container">
        <div class="row centered">
            <h1>Designed To Web</h1>
            <br>
            <br>
            <div class="col-lg-3">
                <img src="/assets/img/intro01.png" alt="">
                <h3>Community</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div>
            <div class="col-lg-3">
                <img src="/assets/img/intro02.png" alt="">
                <h3>Schedule</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div>
            <div class="col-lg-3">
                <img src="/assets/img/intro03.png" alt="">
                <h3>Monitoring</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div>
            <div class="col-lg-3">
                <img src="/assets/img/intro03.png" alt="">
                <h3>Yii framework</h3>
                <p>Yii comes with rich features: MVC, DAO/ActiveRecord, I18N/L10N, caching, authentication and role-based access control, scaffolding, testing, etc. It can reduce your development time significantly.</p>
            </div>
        </div>
        <br>
        <hr>
    </div> <!--/ .container -->
</div><!--/ #introwrap -->

<!-- FEATURES WRAP -->
<div id="features">
    <div class="container">
        <div class="row">
            <h1 class="centered">What's New?</h1>
            <br>
            <br>
            <div class="col-lg-6 centered">
                <img class="centered" src="/assets/img/mobile.png" alt="">
            </div>
                        <div class="col-lg-6">
                <h3>Some Features</h3>
                <br>
            <!-- ACCORDION -->
                <div class="accordion ac" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                            First Class Design
                            </a>
                        </div><!-- /accordion-heading -->
                        <div id="collapseOne" class="accordion-body collapse in">
                            <div class="accordion-inner">
                            <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                    <br>
                        <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                            Retina Ready Theme
                            </a>
                        </div>
                        <div id="collapseTwo" class="accordion-body collapse">
                            <div class="accordion-inner">
                            <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                    <br>
                         <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                            Awesome Support
                            </a>
                        </div>
                        <div id="collapseThree" class="accordion-body collapse">
                            <div class="accordion-inner">
                            <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                    <br>
                    
                     <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
                            Responsive Design
                            </a>
                        </div>
                        <div id="collapseFour" class="accordion-body collapse">
                            <div class="accordion-inner">
                            <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div><!-- /accordion-inner -->
                        </div><!-- /collapse -->
                    </div><!-- /accordion-group -->
                    <br>                            </div><!-- Accordion -->
            </div>
        </div>
    </div><!--/ .container -->
</div><!--/ #features -->


<section id="showcase" name="showcase"></section>
<div id="showcase">
    <div class="container">
        <div class="row">
            <h1 class="centered">Some Screenshots</h1>
            <br>
            <div class="col-lg-8 col-lg-offset-2">
                <div id="carousel-example-generic" class="carousel slide">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                  </ol>
                                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <div class="item active">
                      <img src="/assets/img/item-01.png" alt="">
                    </div>
                    <div class="item">
                      <img src="/assets/img/item-02.png" alt="">
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>        </div><!-- /container -->
</div>    

<section id="contact" name="contact"></section>
<div id="footerwrap">
    <div class="container">
        <div class="col-lg-5">
            <h3>Address</h3>
            <p>
            Av. Greenville 987,<br/>
            New York,<br/>
            90873<br/>
            United States
            </p>
        </div>
                <div class="col-lg-7">
            <h3>Drop Us A Line</h3>
            <br>
            <form role="form" action="#" method="post" enctype="plain"> 
              <div class="form-group">
                <label for="name1">Your Name</label>
                <input type="name" name="Name" class="form-control" id="name1" placeholder="Your Name">
              </div>
              <div class="form-group">
                <label for="email1">Email address</label>
                <input type="email" name="Mail" class="form-control" id="email1" placeholder="Enter email">
              </div>
              <div class="form-group">
                  <label>Your Text</label>
                  <textarea class="form-control" name="Message" rows="3"></textarea>
              </div>
              <br>
              <button type="submit" class="btn btn-large btn-success">SUBMIT</button>
            </form>
        </div>
    </div>
</div>
<div id="c">
    <div class="container">
        <p>Created by <a href="http://www.blacktie.co">BLACKTIE.CO</a></p>
        </div>
</div>