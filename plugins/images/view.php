<?php
include_once 'hal.php';

//страница просмотра
if($_REQUEST['v'] and !$_POST)
{
	if(preg_match('/(\d{4}-\d{2})-(\d{2})_(.*)/', $_REQUEST['v'], $matches))
	{
		$date=$matches[1];
		$day=$matches[2];
		$filename=$matches[3];
		if(file_exists($config['uploaddir'].$date."/".$day."/".$filename))
			make_img_code ($filename, $date, $day);
	}
}

$urls_quantity=count($images_array);

if ($urls_quantity>=1)
{
	$view_one_template=get_img_template('view_one');
	foreach($images_array as $img_filename => $img)
	{
		if($img['error'])
			$parse_main['{content}'] .= parse_template (get_img_template('info'), array("{type}" =>'error',"{title}" =>"Ошибка!","{text}" => "Изображение не загружено. ".$img['error']));
		else
		{	
			$info=getimagesize($img['local_path']);
			$stat=stat($img['local_path']);
			$width=$info['0'];
			$height=$info['1'];
			$size=formatfilesize($stat['size']);
			if ($width<$config['view_one_width'])
				$viewpage_img_width='';
			else 
				$viewpage_img_width=$config['view_one_width'];
				if($urls_quantity==1)
					$parse_one_img['{img}']='<a href="'.$img['url_img'].'"><img src='.$img['url_img'].' rw="'.$width.'" rh="'.$height.'" width="'.$viewpage_img_width.'"></a>';
				else
					$parse_one_img['{img}']='<a href="'.$img['url_img'].'"><img src='.$img['url_img'].' rw="'.$width.'" rh="'.$height.'" width="'.$config['view_multi_width'].'"></a>';
	
				$parse_one_img['{view_img}']= $img['view_img_page'];
				$parse_one_img['{url_img}']=$img['url_img'];
				$bb_img_arr[]=$parse_one_img['{bb_img}']=$img['bb_img'];
				$html_img_arr[]=$parse_one_img['{html_img}']='<a href=\''.$config['site_url'].'\'>'.$img['html_img'].'</a>';
	
				$parse_one_img['{width}']=$width;
				$parse_one_img['{height}']=$height;
				$parse_one_img['{size}']=$size;
			
				if($img['url_prev'])
				{
					$parse_one_img['{url_prev}']=$img['url_prev'];
					$bb_prev_and_img_arr[]=$parse_one_img['{bb_prev_and_img}']=$img['bb_prev_and_img'];
					$html_prev_and_img_arr[]=$parse_one_img['{html_prev_and_img}']=$img['html_prev_and_img'];
			
					$parse_one_img['[one_img_prev]']='';
					$parse_one_img['[/one_img_prev]']='';
				}
				else
				{
					//превью нет. вырезаем блоки для превью
					preg_match("/\[one_img_prev\](.*?)\[\/one_img_prev\]/isu", $view_one_template, $one_img_prev_out);
					$parse_one_img[$one_img_prev_out['0']]='';
				}
		
				$parse_main['{content}'] .= parse_template($view_one_template, $parse_one_img);
		}
	}//конец foreach

	//var_dump ($bb_img_arr);
	
	//если картинка одна - нафиг мульти
	if(count($bb_img_arr)<2)
		$view_template=preg_replace("/\[multi_img\](.*?)\[\/multi_img\]/isu", '',$view_template);
	else
	{
		$view_summary_template=get_img_template('view_summary');

		//echo $view_summary_template;
		
		$parse_multi_img['{multi_bb_img}']=implode(" ", $bb_img_arr);
		$parse_multi_img['{multi_html_img}']=implode("\n", $html_img_arr);
	
	
	//var_dump($bb_prev_and_img_arr);
		if(count($bb_prev_and_img_arr)>1)
		{
			$parse_multi_img['{multi_bb_prev_and_img}']=implode(' ', $bb_prev_and_img_arr);
			$parse_multi_img['{multi_html_prev_and_img}']=implode(' ', $html_prev_and_img_arr);
			$parse_multi_img['[multi_img_prev]']='';
			$parse_multi_img['[/multi_img_prev]']='';
		}
		else
		{
			preg_match("/\[multi_img_prev\](.*?)\[\/multi_img_prev\]/isu", $view_summary_template, $multi_img_prev_out);
			$parse_multi_img[$multi_img_prev_out['0']]='';
		}

 		$parse_main['{content}'] .= parse_template($view_summary_template, $parse_multi_img);
		
		//$result_img['result_img'].=parse_template($view_summary_template, $parse_multi_img);

// 		echo json_encode($result_img);
	}
}
else
{
	$parse_main['{content}']='';
	
	if($_REQUEST['v'])
	{
		header('HTTP/1.0 404 Not Found');
		$error[]='Изображение не найдено.';
	}
	else
		$error[]='Ошибка загрузки изображения.';
}
?>