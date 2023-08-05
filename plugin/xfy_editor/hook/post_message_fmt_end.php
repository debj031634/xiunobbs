// 对引用进行处理<?php
	!empty($arr['quotepid']) && $arr['quotepid'] > 0 && $arr['message'] = post_quote($arr['quotepid']).$arr['message'];