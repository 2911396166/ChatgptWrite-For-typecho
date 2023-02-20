<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * ChatgptWrite 是一个方便你在typecho使用chatgpt进行文章创作的插件！
 * 
 * @package ChatgptWrite
 * @author 吃猫的鱼
 * @version 1.0.0
 * @link https://www.fish9.cn
 */

 /**
  * 本插件作者为吃猫的鱼
  * 为开源插件，未经许可，不允许任何个体/企业对其进行二次开发/售卖！
  */
 
 
 class ChatgptWrite_Plugin implements Typecho_Plugin_Interface
{
 /* 激活插件方法 */
public static function activate(){
      Typecho_Plugin::factory('admin/write-post.php')->chatgpt = array('ChatgptWrite_Plugin', 'render');
    return '插件开启成功';
}
 
/* 禁用插件方法 */
public static function deactivate(){
    return '插件关闭成功';
}
 
/* 插件配置方法 */
public static function config(Typecho_Widget_Helper_Form $form){
    /** 配置欢迎话语 */
    $AccessToken = new Typecho_Widget_Helper_Form_Element_Text('AccessToken', NULL, '', _t('获取AccessKey <a href="http://wpa.qq.com/msgrd?v=3&uin=2911396166&site=qq&menu=yes">点我购买AccessKey</a>'));
    $customEditor = new Typecho_Widget_Helper_Form_Element_Radio('customEditor', array('0'=>'原生编辑器','1'=>'主题自带编辑器'), '', _t('主题是否自带文章编辑器？（重要！）'));
    $useInterface = new Typecho_Widget_Helper_Form_Element_Radio('useInterface', array('0'=>'使用自己服务器接口','1'=>'使用作者接口(可能失效)'), '', _t('选择使用的接口|ps：建议去提问自己测速，哪个速度快用哪个，万一我的接口用不了请切换成自己的。'));
    $form->addInput($AccessToken);
    $form->addInput($customEditor);
    $form->addInput($useInterface);
}
 
/* 个人用户的配置方法 */
public static function personalConfig(Typecho_Widget_Helper_Form $form){}
 
/* 插件实现方法 */
public static function render(){
echo "<script src=\"https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js\"></script>                    ";
if(Typecho_Widget::widget('Widget_Options')->plugin('ChatgptWrite')->useInterface == 0){
    $url_api ='../usr/plugins/ChatgptWrite/chatgptApi.php';
}else{
    $url_api = 'https://chatgpt.fish9.net/chat.php';
}
if(Typecho_Widget::widget('Widget_Options')->plugin('ChatgptWrite')->customEditor == 0){
    echo "<script type=\"text/jscript\">\n";
    echo "   var loading = 0;\n";
    echo "        function chatgpt() {\n";
    echo "           if(loading!=0){\n";
    echo "               alert(\"上一个请求正在处理，请等待！\");\n";
    echo "               return\n";
    echo "           }\n";
    echo "           loading = 1;\n";
    echo "           var str = document.getElementById(\"chatgptQuestion\").value;\n";
    echo "           console.log(str)\n";
    echo "               axios.get('".$url_api."', {\n";
    echo "                   params: {\n";
    echo "                       id: '1',\n";
    echo "                       apikey: '".Typecho_Widget::widget('Widget_Options')->plugin('ChatgptWrite')->AccessToken."',\n";
    echo "                       text: str\n";
    echo "                   }\n";
    echo "               })\n";
    echo "                   .then(function (response) {\n";
    echo "                       if(response[\"data\"][\"data\"][\"html\"]==null||response[\"data\"][\"msg\"]==0){\n";
    echo "                           alert(\"出现错误，请检查您的AccessToken\");\n";
    echo "                       }else{\n";
    echo "                           document.getElementById(\"text\").value += response[\"data\"][\"data\"][\"html\"];\n";
    echo "                       }\n";
    echo "                   })\n";
    echo "                   .catch(function (error) {\n";
    echo "                       alert(error);\n";
    echo "                   })\n";
    echo "                   .then(function () {\n";
    echo "                       // 总是会执行\n";
    echo "                       loading = 0;\n";
    echo "                   });\n";
    echo "       }\n";
    echo "        function showChatgptAsk(){\n";
    echo "           if(document.getElementById(\"ChatgptAsk\").style.display==\"none\"){\n";
    echo "               document.getElementById(\"ChatgptAsk\").style.display=\"block\"; \n";
    echo "               document.getElementById(\"chatgpt-button\").innerHTML=\"收起chatgpt\"; \n";
    echo "           }else{\n";
    echo "               document.getElementById(\"ChatgptAsk\").style.display=\"none\"; \n";
    echo "               document.getElementById(\"chatgpt-button\").innerHTML=\"展开chatgpt\"; \n";
    echo "           }\n";
    echo "        } \n";
    echo "        </script>   \n";
    echo "        <div style=\"margin:10px 0px 10px 0px;text-align:left;\">\n";
    echo "      <a class=\"primary\" id=\"chatgpt-button\" style = \"text-decoration:none; color:white; padding:7px; margin:17px 0px 17px 0px\"onclick=\"showChatgptAsk()\">展开Chatgpt</a>\n";
    echo "       </div>\n";
    echo "      <div id =\"ChatgptAsk\" style=\"display:none; margin:15px;\">\n";
    echo "         <div >\n";
    echo "            <input type=\"text\" placeholder=\"请输入询问内容...\" class=\"w-70 text title\" name=\"name\" id=\"chatgptQuestion\" value=\"\"/><label onclick=\"chatgpt()\" class=\"primary\" style = \"text-decoration:none; color:white; padding:7px 15px 7px 15px; margin:17px 5px 17px 5px\">发送</label>\n";
    echo "         </div>   \n";
    echo "       </div>\n";
    }else{
    echo "<script type=\"text/jscript\">\n";
    echo "   var loading = 0;\n";
    echo "        function chatgpt() {\n";
    echo "           if(loading!=0){\n";
    echo "               alert(\"上一个请求正在处理，请等待！\");\n";
    echo "               return\n";
    echo "           }\n";
    echo "           loading = 1;\n";
    echo "           var str = document.getElementById(\"chatgptQuestion\").value;\n";
    echo "           console.log(str)\n";
    echo "               axios.get('".$url_api."', {\n";
    echo "                   params: {\n";
    echo "                       id: '1',\n";
    echo "                       apikey: '".Typecho_Widget::widget('Widget_Options')->plugin('ChatgptWrite')->AccessToken."',\n";
    echo "                       text: str\n";
    echo "                   }\n";
    echo "               })\n";
    echo "                   .then(function (response) {\n";
    echo "                       if(response[\"data\"][\"data\"][\"html\"]==null){\n";
    echo "                           alert(\"出现错误，请检查您的AccessToken\");\n";
    echo "                       }else{\n";
    echo "                           document.getElementById(\"respone-div\").style.display=\"block\"; \n";
    echo "                           document.getElementById(\"respone\").value = response[\"data\"][\"data\"][\"html\"];\n";
    echo "                       }\n";
    echo "                   })\n";
    echo "                   .catch(function (error) {\n";
    echo "                       alert(error);\n";
    echo "                   })\n";
    echo "                   .then(function () {\n";
    echo "                       // 总是会执行\n";
    echo "                       loading = 0;\n";
    echo "                   });\n";
    echo "       }\n";
    echo "        function showChatgptAsk(){\n";
    echo "           if(document.getElementById(\"ChatgptAsk\").style.display==\"none\"){\n";
    echo "               document.getElementById(\"ChatgptAsk\").style.display=\"block\"; \n";
        echo "               document.getElementById(\"respone-div\").style.display=\"block\"; \n";
    echo "               document.getElementById(\"chatgpt-button\").innerHTML=\"收起chatgpt\"; \n";
    echo "           }else{\n";
    echo "               document.getElementById(\"ChatgptAsk\").style.display=\"none\"; \n";
    echo "               document.getElementById(\"respone-div\").style.display=\"none\"; \n";
    echo "               document.getElementById(\"chatgpt-button\").innerHTML=\"展开chatgpt\"; \n";
    echo "           }\n";
    echo "        } \n";
    echo "\n";
    echo "       function copy() {\n";
    echo "   const range = document.createRange();\n";
    echo "   range.selectNode(document.getElementById('respone'));\n";
    echo "   const selection = window.getSelection();\n";
    echo "   if(selection.rangeCount > 0) selection.removeAllRanges();\n";
    echo "   selection.addRange(range);\n";
    echo "   document.execCommand('copy');\n";
    echo "   }\n";
    echo "   document.getElementById('copy').addEventListener('click', copyArticle, false);\n";
    echo "	\n";
    echo "\n";
    echo "        </script>   \n";
    echo "        <div style=\"margin:10px 0px 10px 0px;text-align:left;\">\n";
    echo "      <a class=\"primary\" id=\"chatgpt-button\" style = \"text-decoration:none; color:white; padding:7px; margin:17px 0px 17px 0px\"onclick=\"showChatgptAsk()\">展开Chatgpt</a>\n";
    echo "       </div>\n";
    echo "      <div id =\"ChatgptAsk\" style=\"display:none; margin:15px;\">\n";
    echo "         <div >\n";
    echo "            <input type=\"text\" placeholder=\"请输入询问内容...\" class=\"w-70 text title\" name=\"name\" id=\"chatgptQuestion\" value=\"\"/><label onclick=\"chatgpt()\" class=\"primary\" style = \"text-decoration:none; color:white; padding:7px 15px 7px 15px; margin:17px 5px 17px 5px\">发送</label><label onclick=\"copy()\" class=\"primary\" style = \"text-decoration:none; color:white; padding:7px 15px 7px 15px; margin:17px 5px 17px 5px\">复制</label>\n";
    echo "         </div>   \n";
    echo "       </div>\n";
    echo "       \n";
    echo "        <div id=\"respone-div\" style=\"display:none;\">\n";
    echo "       <textarea  autocomplete=\"off\" id=\"respone\" name=\"respone\" class=\"w-100 mono\" rows=\"5\">\n";
    echo "       </textarea>\n";
    echo "       </div>\n";
    }
}
}

?>