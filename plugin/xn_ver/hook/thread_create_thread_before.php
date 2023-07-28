
$vernum = param('vernum');
$ver_time = param('ver_time');

if(!empty($vernum)){
    xn_strlen($vernum) > 16 AND message('vernum', lang('vernum_length_over_limit', array('maxlength'=>16)));
    empty($ver_time) && $ver_time = date('Y-m-d');
    $thread['vernum']=$vernum;
    $thread['ver_time']=strtotime($ver_time);
}
