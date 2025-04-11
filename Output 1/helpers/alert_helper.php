<?php

function show_alert($message, $redirect) { ?>
    <script>
        alert('<?php echo $message; ?>');
        location = '<?php echo $redirect; ?>';
    </script>
<?php }