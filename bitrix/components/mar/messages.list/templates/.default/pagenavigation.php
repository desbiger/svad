<div class="pages-box">

<span><?
	if($this->NavPageNomer > 1)
		echo('<a href="'.$sUrlPath.'?PAGEN_'.
			$this->NavNum.'='.($this->NavPageNomer-1).$strNavQueryString.'#nav_start'.
			$add_anchor.'">← Предыдущая</a>');
	else
		echo('← Предыдущая');
?></span>
<ul>
<?
		$NavRecordGroup = $nStartPage;
		while($NavRecordGroup <= $nEndPage)
		{
			echo '<li>';
			if($NavRecordGroup == $this->NavPageNomer)
				echo('<a class="active" href="'.$sUrlPath.'?PAGEN_'.$this->NavNum.'='.
					$NavRecordGroup.$strNavQueryString.'#nav_start'.$add_anchor.'">'.
					$NavRecordGroup.'</a>');
			else
				echo('<a href="'.$sUrlPath.'?PAGEN_'.$this->NavNum.'='.
					$NavRecordGroup.$strNavQueryString.'#nav_start'.$add_anchor.'">'.
					$NavRecordGroup.'</a>');
			echo '</li>';
			$NavRecordGroup++;
		}
?>
</ul>
<span><?
	if($this->NavPageNomer < $this->NavPageCount)
		echo ('<a href="'.$sUrlPath.'?PAGEN_'.
			$this->NavNum.'='.$this->NavPageCount.$strNavQueryString.
			'#nav_start'.$add_anchor.'">Следующая →</a> ');
	else
		echo ('Следующая →');
?></span>
	<div class="end"></div>
</div>