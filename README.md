# ChatgptWrite-For-typecho
来自typecho 的ChatgptWrite插件
# 关于插件
最新版本：1.0.0
ChatgptWrite 是一个方便你在typecho使用chatgpt进行文章创作的插件！
# 关于作者
作者：吃猫的鱼
博客：https://www.fish9.cn/
# 插件安装/使用方法
将本插件上传至typecho中的/usr/plugins目录里面，将名字改成ChatgptWrite 然后去后台开启插件，对插件进行相应的配置。
最后前往typecho根目录中的admin/write-post文件中，找到下面这段代码
```php
<p>
<label for="text" class="sr-only"><?php _e('文章内容'); ?></label>
```
在这段代码上面加上一个挂截点代码
```php
<?php \Typecho\Plugin::factory('admin/write-post.php')->chatgpt(); ?>
```
大功告成！您可以正式开始使用插件了！
您可以前往撰写文章页面，体验强大的ai给您带来的写作灵感！
无需科学上网，仅需在你的博客后台即可使用！
