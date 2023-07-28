
$arr = array();
if($isfirst) {
    $vernum = param('vernum');
    $ver_time = param('ver_time');
    empty($ver_time) && $ver_time = date('Y-m-d');
    $ver_time = strtotime($ver_time);
    if($vernum != $thread['vernum']) {
        xn_strlen($vernum) > 16 AND message('vernum', lang('vernum_length_over_limit', array('maxlength'=>16)));
        $arr['vernum'] = $vernum;
    }
    if($ver_time != $thread['ver_time']) {
        $arr['ver_time'] = $ver_time;
    }

    $arr AND thread_update($tid, $arr) === FALSE AND message(-1, lang('update_thread_failed'));
}