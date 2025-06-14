<?
$benefits_blocks = get_field('benefits_blocks', 'option')
?>
<? if ($benefits_blocks) : ?>
    <div class="benefits">
        <div class="container">
            <div class="benefits__blocks">
                <?php foreach ($benefits_blocks as $benefits_block) { ?>
                    <div class="benefits__block">
                        <div class="benefits__block-title title"><?php echo $benefits_block['title']; ?></div>
                        <div class="benefits__block-text"><?php echo $benefits_block['text']; ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<? endif; ?>