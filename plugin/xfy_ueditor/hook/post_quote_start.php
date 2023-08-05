//<?php  //这里处理重复引用的问题
//拿到引用回复内容  $s

$n = strripos($s,"</blockquote>");
if($n){
    $s = substr($s,$n+13); //只截取引用后面的文字去处理
}