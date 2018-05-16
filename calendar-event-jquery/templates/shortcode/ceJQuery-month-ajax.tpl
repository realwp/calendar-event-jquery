<?php foreach($posts as $index => $post) { ?>
    <a href="<?php echo $post['link']; ?>">
        <div>
            <div>
                <span><?php echo $post['title']; ?></span>
                <span>از تاریخ <?php echo $post['date_from']; ?> تا تاریخ <?php echo $post['date_to']; ?></span>
            </div>
            <div><?php echo $post['content']; ?></div>
        </div>
    </a>
<?php } ?>