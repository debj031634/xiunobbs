$arr = array();
if($isfirst) {
    $vernum = param('vernum');
    $ver_time = param('ver_time');
    $ver_pic = param('ver_pic');
    $ver_pass = param('ver_pass');
    empty($ver_time) && $ver_time = date('Y-m-d');
    $ver_time = strtotime($ver_time);
    if($vernum != $thread['vernum']) {
        xn_strlen($vernum) > 16 AND message('vernum', lang('vernum_length_over_limit', array('maxlength'=>16)));
        $arr['vernum'] = $vernum;
    }
    if($ver_time != $thread['ver_time']) {
        $arr['ver_time'] = $ver_time;
    }
    if ($ver_pic) {
        // 如果图片路径以 / 开头，则创建一个全路径变量 $checkpic ，用于图片尺寸检查。但存数据库中的仍为 / 开头。
        if (substr($ver_pic,0,1)=='/'){
            $url  = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $url .= "://" . $_SERVER['HTTP_HOST'];
            $checkpic =  $url.$ver_pic;
        } else {
            $checkpic = $ver_pic;
        }
        list($w,$h,$t,$a) = getimagesize($checkpic);
        if ( !$w or !$h or $w>800 or $h>500 ){
            message('vernum', lang('ver_pic_size_limit', array('picwidth'=>800,'picheight'=>500)));
        }
    }
    if($ver_pic != $thread['ver_pic']) {
         $arr['ver_pic'] = $ver_pic;
    }
    if($ver_pass != $thread['ver_pass']) {
        xn_strlen($ver_pass) > 16 AND message('vernum', lang('ver_pass_length_over_limit', array('maxlength'=>16)));
        $arr['ver_pass'] = $ver_pass;
    }
    $arr AND thread_update($tid, $arr) === FALSE AND message(-1, lang('update_thread_failed'));
}