<?php
	//获取当前文件所在的文件夹的目录
	function get_basepath()
	{
		if($dir = trim(dirname($_SERVER['SCRIPT_NAME']),'\,/'))
		{
			$base_path = "/$dir";
			$base_path .= '/';
		}
		else
		{
			$base_path = '/';
		}
		return $base_path;
	}

	//页面重定向
	function redirector($c)
	{
		@ob_clean();
		header("Location:$c");
		exit();
	}

	//页面重定向到指定指定页面
	function redirector_c($ctl,$act = 'index')
	{
		@ob_clean();
		header("Location: index.php?ctl=$ctl&act=$act");
		exit();
	}

	//设置数据缓存
	function where_is_tmp()
	{
		//ini_get — 获取一个配置选项的值
        //uploadtmp临时文件
        //得到的是G:/wamp/tmp
        $uploadtmp = ini_get('upload_tmp_dir');

        //getenv() — 获取一个环境变量的值
        //获取TMP或者TEMP环境变量
        //得到的是C:\Windows\TEMP
        $envtmp = (getenv('TMP'))?getenv('TMP'):getenv('TEMP');

        //is_writable() 函数判断指定的文件是否可写
        if(is_dir($uploadtmp) && is_writable($uploadtmp))
        {
        	return $uploadtmp;
        }

        if(is_dir($envtmp) && is_writable($envtmp))
        {
        	return $envtmp;
        }

        if(is_dir('/tmp') && is_writable('/tmp'))
        {
            return '/tmp';
        }

        if(is_dir('/usr/tmp') && is_writable('/usr/tmp'))
        {
            return '/usr/tmp';
        }

        if(is_dir('/var/tmp') && is_writable('/var/tmp'))
        {
            return '/var/tmp';
        }

        return ",";
	}

	//设置文件的地址
	function fileSrc($img)
	{
		return 'data/'.$img;
	}

	//获取文件地址
	function mkfileLink($dir,$key,$ext)
	{
		return 'data/'.$dir.'/'.$key.'_'.'.'.$ext;
	}

	//设置储存文件的目录名称
	function get_updir_name($t)
	{
		switch($t)
		{
			case '1':
				$name = date('Ymd');
				break;
			case '2':
				$name = date('Ym');
				break;
			default:
				$name = date('Ymd');
		}
		return $name;
	}

	//页面显示
    //$total为总页数,$page为当前页数，$url为页数连接的地址
    function pageshow($total,$page,$url = '',$pageset = 5)
    {
    	$ppset = '';
    	if($total > 0)
    	{
    		if($page < 1 || $page == '')
    		{
    			$page = 1;
    		}

    		if($page > $total)
    		{
    			$paeg = $total;
    		}

    		//共多少页
    		$ppset = '<span class="pageset_totol">共'.$total.'页</span>';

    		if($page > 1)
    		{
    			//加上第一页和上一页
    			$ppset .= '<a href="'.str_replace('[#page#]','1',$url).'">&lt;&lt;</a><a href="'.str_replace('[#page#]',($page - 1),$url).'" class="pre_page">&lt;</a>';
    		}

    		//如果当前页数超过$paegset（5）的时候，显示...
    		if(($page - $pageset) > 1)
    		{
    			$ppset .= '<a href="'.str_replace('[#page#]','1',$url).'">1</a> ... ';
    			for($i = $page - $pageset;$i < $page;$i++)
    			{
    				$ppset .= '<a href = "'.$page.'">';
    			}	
    		}
            else
            {
                for($i = 1;$i < $page;$i++)
                {
                    $ppset .= '<a href="'.str_replace('[#page#]',$i,$url).'">'.$i.'</a>';
                }
            }

    		$ppset .= "<a href=\"".str_replace('[#page#]',$page,$url)."\" onclick=\"return false\" class=\"current\">$page</a> ";
            
            if(($page + $pageset) < $total)
            {
                for($i = $page + 1;$i <= ($page + $pageset);$i++)
                {
                    $ppset .= '<a href="'.str_replace('[#page#]',$i,$url).'">'.$i.'</a> ';
                }
                $ppset .= ' ... <a href="'.str_replace('[#page#]',$total,$url).'">'.$total.'</a> ';
            }
            else
            {
                for($i = $page + 1;$i <= $total;$i++)
                {
                    $ppset .= '<a href="'.str_replace('[#page#]',$i,$url).'">'.$i.'</a> ';
                }
            }

            //下一页
            if($page < $total)
            {
                $ppset .= ' <a href="'.str_replace('[#page#]',($page + 1),$url).'" class="next_page">&gt;</a> <a href="'.str_replace('[#page#]',$total,$url).'">&gt;&gt;</a>';
            }
            return $ppset;
    	}
    	else
    	{
    		return '<span class="pageset_totol">共0页</span>';
    	}
    }

    //$message要显示的信息
    //$target 返回到link指定的页面时的打开方式
    function showInfo($message,$flag = true,$link = '',$target = '_self')
    {
        $titlecolor = $flag?'infotitle2':'infotitle3';
        //如果$link为空的话那么返回到上一个页面，否则返回到$link指定的页面
        $otherlink = ($link == ''?'javascript:history.back();':$link);

        print<<<EOF
        <!doctype html>
        <html>
        <head>
        <meta charset = "utf-8" />
        <title>Ilbum 操作提示</title>
        <link href="css/main.css" rel="stylesheet" type="text/css" />
        </head>
        <body>
            <div id="addend_parent"></div>
            <div id="container" id="cpcontainer">
                <h3>操作提示</h3>
                <div class="infobox">
                    <h4 class="$titlecolor">$message</h4>
                    <h5>
                        <a class="return_btn" href="$otherlink" target="$target">返回</a>
                    </h5>
                </div>
            </div>
        </body>
        </html>
EOF;
        exit();
    }