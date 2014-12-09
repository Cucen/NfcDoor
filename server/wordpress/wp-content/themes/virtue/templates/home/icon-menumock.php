<?php $icons = array(
    array('icon_o' => 'icon-pencil', 'link' => '', 'title' => 'Clean Design', 'url' => '', 'description' => ''),
    array('icon_o' => 'icon-mobile-phone', 'link' => '', 'title' => 'Responsive', 'url' => '', 'description' => ''),
    array('icon_o' => 'icon-cogs', 'link' => '', 'title' => 'Tons of Options', 'url' => '', 'description' => ''),
    array('icon_o' => 'icon-shopping-cart', 'link' => '', 'title' => 'Ecommerce', 'url' => '', 'description' => ''),
    ); 
    $itemsize = 'tcol-lg-3 tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12';                   
    ?>
                <div class="home-margin home-padding">
                    <div class="rowtight homepromo">
                    <?php $counter = 1;?>
                        <?php foreach ($icons as $icon) : ?>
                            <div class="<?php echo $itemsize;?> home-iconmenu <?php echo 'homeitemcount'.$counter;?>">
                                <a href="<?php echo $icon['link'] ?>" title="<?php echo $icon['title'] ?>">
                                <?php if(!empty($icon['url'])) echo '<img src="'.$icon['url'].'"/>' ; else echo '<i class="'.$icon['icon_o'].'"></i>'; ?>
                                <?php if ($icon['title'] != '') echo '<h4>'.$icon['title'].'</h4>'; ?>
                                <?php if ($icon['description'] != '') echo '<p>'.$icon['description'].'</p>'; ?>
                                </a>
                            </div>
                             <?php $counter ++ ?>
                        <?php endforeach; ?>

                    </div> <!--homepromo -->
                </div>