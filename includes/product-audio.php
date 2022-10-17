<?php
    global $product;

    $product_audio_type = get_post_meta( $product->get_id(), 'harmony_product_audio_type', true );
    $soundcloud_url     = get_post_meta( $product->get_id(), 'harmony_soundcloud', true );
    $wpmedia_url        = get_post_meta( $product->get_id(), 'harmony_wpmedia_audio', true );
    
?>

<div id="harmony-audio-wrapper">

    <?php if( $product_audio_type == 'sc_audio' && !empty( $soundcloud_url ) ): ?>

        <iframe id="sc-widget" src="https://w.soundcloud.com/player/?url=<?php echo esc_url( $soundcloud_url ); ?>" width="100%" height="100%" scrolling="no" frameborder="no"></iframe>

    <?php endif; ?>

    <?php if( $product_audio_type == 'wpmedia_audio' && !empty( $wpmedia_url ) ): ?>

        <audio id="wpmedia-audio-content" controls><source src="<?php echo esc_url( $wpmedia_url ); ?>"></audio>

    <?php endif; ?>

</div>