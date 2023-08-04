//<?php
$lib = param(1, "no");



if($lib=="aardiolib"){
    // 从默认的地方读取主题列表
    $thread_list_from_default = 1;


    if($thread_list_from_default) {
        $fids = arrlist_values($forumlist_show, 'fid');
        $threads = arrlist_sum($forumlist_show, 'threads');
        //$pagination = pagination(url("$route-{page}"), $threads, $page, $pagesize);
        

        $threadlist = thread_find_by_fids($fids, 1, $threads, 'tid', $threads);
    }


    thread_list_access_filter($threadlist, $gid);

    foreach($threadlist as $tid=>$thread) {   
        $title = $thread['subject'];
        $ver = $thread['vernum'];
        //unset($threadlist[$tid]["user"]); //清空用户详细信息
        //unset($threadlist[$tid]);
        $threadlist[$tid]=$ver;
        // if($thread['vernum']!="") {
        //     $list = post_find_by_tid($tid, 1, 1);
        //     foreach ($list as $k => $v) {
        //         $threadlist[$tid]['subject'] =  $title;
        //         $threadlist[$tid]['ver'] =  $ver;
        //         $threadlist[$tid]['filename'] ="";
        //         $threadlist[$tid]['orgfilename'] ="";
        //         if($v['filelist']){
        //             $threadlist[$tid]['filename'] = $v['filelist'][0]['filename'] ;
        //             $threadlist[$tid]['orgfilename'] = $v['filelist'][0]['orgfilename'] or "";
        //         }
        //     }
            
        // }
    }
    /*
    echo "<pre>";
    //
    var_dump($threadlist);
    echo "</pre>";
    */

    echo json_encode($threadlist,JSON_UNESCAPED_UNICODE );
    exit();
}