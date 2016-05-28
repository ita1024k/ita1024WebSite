<?php
	$this->widget ( 'ext.ueditor.UeditorWidget', array (
			'name' => 'content',
			'id' => 'content',
			'value' => $app_content['content'],
			'config' => array (
					'serverUrl' => Yii::app ()->createUrl ( 'editor/' ), // 指定serverUrl
					'toolbars'=>array(
					    array('fullscreen', 'source', '|', 'undo', 'redo', '|','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|','forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',   
           'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',   
           'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',   
           'directionalityltr', 'directionalityrtl', 'indent', '|',   
           'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',   
           'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',   
           'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|')
					),
					'initialFrameHeight' => '500',
					'initialFrameWidth' => '100%' 
			),
			'htmlOptions' => array (
					'rows' => 3,
					'class' => 'span12 controls' 
			) 
	) );
	/* 'fullscreen', 'source', '|', 'undo', 'redo', '|',   
           'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',   
           'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',   
           'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',   
           'directionalityltr', 'directionalityrtl', 'indent', '|',   
           'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',   
           'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',   
           'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|',   
           'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',   
           'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',   
           'searchreplace', 'help', 'drafts' */
?>
