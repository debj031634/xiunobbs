
$vernum = param('vernum');
$ver_time = param('ver_time');
$ver_pic = param('ver_pic');
$ver_pass = param('ver_pass');

if(!empty($vernum)){
    xn_strlen($vernum) > 16 AND message('vernum', lang('vernum_length_over_limit', array('maxlength'=>16)));
    empty($ver_time) && $ver_time = date('Y-m-d');
    $thread['vernum']=$vernum;
    $thread['ver_time']=strtotime($ver_time);
}
if(!empty($ver_pic)){
    $thread['ver_pic']=$ver_pic;
}
if(!empty($ver_pass)){
    $thread['ver_pass']=$ver_pass;
}