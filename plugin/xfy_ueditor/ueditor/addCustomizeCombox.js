


UE.registerUI('插入代码',function(editor,uiName){
    //注册按钮执行时的command命令,用uiName作为command名字，使用命令默认就会带有回退操作
    editor.registerCommand(uiName,{
        execCommand:function(cmdName,value){
            //
            this.execCommand( "inserthtml",
            '<pre  class="iceCode:' +  value + '">Code here</pre>',true)
        }
       
    });


    //创建下拉菜单中的键值对，这里我用字体大小作为例子
    var items = [];
    for(var i= 0,ci;ci= ['Aardio', 'HTML/XTML','JavaScript','CSS','PHP','Python','SQL','GO',  'C#','C++','C'][i++];){
        items.push({
            //显示的条目
            label:ci,
            //选中条目后的返回值
            value:ci,
           
            renderLabelHtml:function () {
               
                return '<div class="edui-label %%-label" style="line-height:2;">' + (this.label || '') + '</div>';
            }
        });
    }
    //创建下来框
    var combox = new UE.ui.Combox({
        //需要指定当前的编辑器实例
        editor:editor,
        //添加条目
        items:items,
        //当选中时要做的事情
        onselect:function (t, index) {
            //拿到选中条目的值
            //console.log(this.items[index].value)
            editor.execCommand(uiName, this.items[index].value);
        },
        //提示
        title:uiName,
        //当编辑器没有焦点时，combox默认显示的内容
        initValue:uiName
    });

    editor.addListener('selectionchange', function (type, causeByUi, uiReady) {
        if (!uiReady) {
            var state = editor.queryCommandState(uiName);
            
        }

    });
    return combox;
},80/*index 指定添加到工具栏上的那个位置，默认时追加到最后,editorId 指定这个UI是那个编辑器实例上的，默认是页面上所有的编辑器都会添加这个按钮*/);