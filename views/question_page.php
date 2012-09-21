<?php

/**
 * pun_antibot view of question page
 *      based on pun_stop_bots extension
 *
 * @copyright (C) 2008-2011 PunBB, Nathan Dumont 2012
 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 * @package pun_stop_bots
 */

?>
<?php
  // remove any old images that are lying around
  if($handle = opendir('img/avatars/')) {
    while(false !== ($entry = readdir($handle))) {
      if((substr($entry, 0, 6) == "secpic") && (filectime('img/avatars/' . $entry) < (time() - 10 * 60))) {
        unlink('img/avatars/' . $entry);
      }
    }
    closedir($handle);
  }
          
  // Create the image
  $code='';
  $im = imagecreatetruecolor(180, 40);
  $chr = imagecreatetruecolor(32,32);
  $chars=imagecreatefrompng($ext_info['path'] . "/font.png");

  // Create some colors
  $white = imagecolorallocate($im, 255, 255, 255);
  $black = imagecolorallocate($im, 0, 0, 0);
  imagefilledrectangle($im, 0, 0, 180, 40, $white);

  $oldspacing=10;
  $text = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
  $imgname = 'secpic';
  for($i=0;$i<12;$i++) {
    $num = rand(0,34);
    $imgname = $imgname . $text[$num];
  }
  $imgname = $imgname . '.png';
  for($i=0;$i<6;$i++)
  {
    $num=rand(0,34);
    $row=($num-fmod($num,8))/8;
    $col=fmod($num,8);
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
  imagepng($im, "img/avatars/" . $imgname);
  chmod("img/avatars/" . $imgname, 0666);
?>
<div class="main-head">
  <h2 class="hn"><span><?php echo $lang_pun_antibot['Stop bots question']; ?></span></h2>
</div>
<div class="main-subhead">
  <h2 class="hn"><span><?php echo $forum_page['question']; ?> </span></h2>
</div>
<div class="main-content main-frm">
        
  <form id="afocus" class="frm-form" method="post" accept-charset="utf-8" action="<?php echo $forum_page['form_handler']; ?>">
    <div class="hidden">
    <?php foreach ($forum_page['hidden_fields'] as $hidden_key => $hidden_value): ?>
      <input name="<?php echo forum_htmlencode($hidden_key); ?>" value="<?php echo forum_htmlencode($hidden_value); ?>" type="hidden">
    <?php endforeach; ?>
      <input name="antibot_code" value="<?php echo $code;?>" type="hidden"/>
    </div>
    <div class="sf-set set1"><img alt='image' src='<?php echo "img/avatars/" . $imgname;?>'/></div>
                                                
    <?php echo $lang_pun_antibot['capitals'];?>
    <div class="sf-set set1">
      <div class="sf-box text required">
        <label for="fld1"><span><?php echo $lang_pun_antibot['Your answer']; ?></span></label><br/>
        <span class="fld-input"><input type="text" value="" maxlength="255" size="35" name="pun_antibot_answer" id="fld1" required /></span>
      </div>
    </div>
    <div class="frm-buttons">
      <span class="submit primary"><input name="pun_antibot_submit" value="<?php echo $lang_pun_antibot['Answer']; ?>" type="submit"></span>
    </div>
  </form>
</div>
