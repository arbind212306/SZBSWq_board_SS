<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="error-msg" onclick="this.classList.add('hidden');"  style="text-align: center;"><?= $message ?></div>
