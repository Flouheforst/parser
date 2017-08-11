<?php require (__DIR__ . "/../../FlashPush.php"); ?>
<?php App::renderTemplate("header"); ?>
<div class="spinner"></div> 
<section class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action= "php/action/urlSite.php" method="post">
                    <p>
                        <input type="text" name="site" placeholder="WebSite">
                    </p>
                    <p>
                        <input type="number" name="tableCount">
                    </p>
                    <p>
                        <button id="Parse" type= "submit" name = "Parse">Parse</button> 
                    </p>
                    <?php if (FlashPush::has("site-error")) {
                        echo FlashPush::get("site-error");
                    }?>
                    <?php if (FlashPush::has("site-auth")) {
                        echo FlashPush::get("site-auth");
                    }?>
                </form>
            </div>
        </div>
    </div>
</section>
<!--          
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 ">
                <p>Kompot © - 2017</p>
            </div>
        </div>
    </div>
</footer>
-->
<?php App::renderTemplate("footer"); ?>
