<section id="slider" class="container semi-fluid hidden-xs hidden-sm">
    <div class="row">
        <div id="main-carousel" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="<?= __PATH_TEMPLATE__ ?>images/slide1.png">
                    <div class="carousel-caption-ex">
                        <h1><?= lang('res_template_slider_txt_1', true) ?></h1>
                        <h2><?= lang('res_template_slider_txt_2', true) ?><h2>
                    </div>
                </div>
                <div class="item">
                    <img src="<?= __PATH_TEMPLATE__ ?>images/slide2.png">
                    <div class="carousel-caption-ex">
                        <h1><?= lang('res_template_slider_txt_3', true) ?></h1>
                        <h2><?= lang('res_template_slider_txt_4', true) ?><h2>
                    </div>
                </div>
            </div>
            <ol class="carousel-indicators">
                <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#main-carousel" data-slide-to="1"></li>
            </ol>
        </div>
    </div>
</section>
<section class="contentPaddingWithoutSlider visible-xs visible-sm"></section>