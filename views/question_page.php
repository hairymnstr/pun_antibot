<?php

/**
 * pun_stop_bots view of question page
 *
 * @copyright (C) 2008-2011 PunBB
 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 * @package pun_stop_bots
 */

?>
<div class="main-head">
	<h2 class="hn"><span><?php echo $lang_pun_stop_bots['Stop bots question']; ?></span></h2>
</div>
<div class="main-subhead">
	<h2 class="hn"><span><?php echo $forum_page['question']; ?> </span></h2>
</div>
<div class="main-content main-frm">
  <label><?php echo $lang_antibot['description']; ?><br />
                                                <?php
                                                  // Create the image
                                                  $code='';
                                                  $im = imagecreatetruecolor(180, 40);
                                                  $chr = imagecreatetruecolor(32,32);
                                                  $chars=imagecreatefrompng("font.png");

                                                  // Create some colors
                                                  $white = imagecolorallocate($im, 255, 255, 255);
                                                  $black = imagecolorallocate($im, 0, 0, 0);
                                                  imagefilledrectangle($im, 0, 0, 180, 40, $white);

                                                  $oldspacing=10;
                                                  for($i=0;$i<6;$i++)
                                                  {
                                                    $num=rand(0,34);
                                                    $row=($num-fmod($num,8))/8;
                                                    $col=fmod($num,8);
                                                    $text = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
                                                    $size=rand(24,32);
                                                    $spacing=rand(23,25);
                                                    $ypos=rand(0,8);
                                                    imagefilledrectangle($chr,0,0,32,32,$white);
                                                    imagecopyresampled($chr,$chars,0,0,$col*32,$row*32,$size,$size,32,32);
                                                    imagecolortransparent($chr,$white);
                                                    imagecopymerge($im,$chr,$oldspacing,$ypos,0,0,32,32,100);
                                                    $code=$code . $text[$num];
                                                    $oldspacing=$oldspacing+$spacing;
                                                  }
                                                  $code=crypt($code);
                                                  imagepng($im, "img/avatars/secpic.png");
                                                  chmod("img/avatars/secpic.png",0666);
                                                ?>

                                                <img alt='image' src='<?php echo "img/avatars/secpic.png";?>'/><br />
                                                <input type='text' name='antibot' size='6'/>
                                                <input type='hidden' value='<?php echo $code;?>' name='code'/>
                                                <?php echo $lang_antibot['capitals'];?></label>
	<form id="afocus" class="frm-form" method="post" accept-charset="utf-8" action="<?php echo $forum_page['form_handler']; ?>">
		<div class="hidden">
		<?php foreach ($forum_page['hidden_fields'] as $hidden_key => $hidden_value): ?>
			<input name="<?php echo forum_htmlencode($hidden_key); ?>" value="<?php echo forum_htmlencode($hidden_value); ?>" type="hidden">
		<?php endforeach; ?>
		</div>
		<div class="sf-set set1">
			<div class="sf-box text required">
				<label for="fld1"><span><?php echo $lang_pun_stop_bots['Your answer']; ?></span></label><br/>
				<span class="fld-input"><input type="text" value="" maxlength="255" size="35" name="pun_stop_bots_answer" id="fld1" required /></span>
			</div>
		</div>
		<div class="frm-buttons">
			<span class="submit primary"><input name="pun_stop_bots_submit" value="<?php echo $lang_pun_stop_bots['Answer']; ?>" type="submit"></span>
		</div>
	</form>
</div>
