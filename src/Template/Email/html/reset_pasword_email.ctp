<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$content = explode("\n", $content);
$base_url=  $this->Url->build('/', true);
foreach ($content as $line) :
    //echo '<p> ' . $line . "</p>\n";
endforeach;?>
<p style=""><?php echo $this->Html->image("springboard-mail-logo.png", ['fullBase' => true]); ?></p>
<p style=""><b>Hi <?= $first_name ; ?> <?= $last_name ; ?>,</b></p>
<?php $base_url=  $this->Url->build('/', true);?>
 <p>Recently you have requested to reset your password click on the below link to reset your password.</p><br>  
 <a href="<?php echo $base_url; ?>users/resetPassword/<?php echo $id ?>/<?php echo $key ?>">Click here to reset password</a><br><br>
 <p>If you did not request for password reset please ignore this email or contact support if you have any query.</p><br>

 <br>
<p><b>Thanks & Regards,</b></p>
<p><b>Spring Board</b></p>





