<?php

require_once('db.php');

class dd
{
	private function buildDropdown($elementID, $table, $idColumn, $descColumn, $orderBy = 1, $withBlank = true, $preSelected = '', $valueAndTextAreDifferent = true, $excludeDisabled = false)
	{
		$html = "<select id='$elementID'>";
		if($withBlank){ $html.= "<option value='0'>Select...</option>"; }
	
	
		$db = new db();
		$conn = $db->getMariaDbConnection();
		
		$whereClause = '';
		
		if($excludeDisabled)
		{
			$whereClause = ' where isDisabled = 0';
		}
		
		$sql = "select $idColumn, $descColumn from $table $whereClause order by $orderBy";
		
		$stmt = $db->basicQuery($conn, $sql);
		$stmt->bind_result($optionValue, $optionText);
		
		while($stmt->fetch())
		{
			if(($valueAndTextAreDifferent && $preSelected == $optionValue) || (!$valueAndTextAreDifferent && $preSelected == $optionText))
			{
				$selectedHTML = 'selected';
			}
			else
			{
				$selectedHTML = '';
			}
		
			if($valueAndTextAreDifferent)
			{
				$html .= "<option value='$optionValue' $selectedHTML>$optionText</option>";
			}
			else
			{
				$html .= "<option value='$optionText' $selectedHTML>$optionText</option>";
			}
		}
		
		$html .= "</select>";
		
		return $html;
	}

	private function buildComplicatedDropdown($elementID, $sql, $paramsArray, $withBlank = true, $preSelected = '', $valueAndTextAreDifferent = true)
	{
		$html = "<select id='$elementID'>";
		if($withBlank){ $html.= "<option value='0'>Select...</option>"; }
	
		$db = new db();
		$conn = $db->getMariaDbConnection();
		
		$stmt = $db->parameterQuery($conn, $sql, $paramsArray);
		$stmt->bind_result($optionValue, $optionText);
		
		while($stmt->fetch())
		{
			if(($valueAndTextAreDifferent && $preSelected == $optionValue) || (!$valueAndTextAreDifferent && $preSelected == $optionText))
			{
				$selectedHTML = 'selected';
			}
			else
			{
				$selectedHTML = '';
			}
		
			if($valueAndTextAreDifferent)
			{
				$html .= "<option value='$optionValue' $selectedHTML>$optionText</option>";
			}
			else
			{
				$html .= "<option value='$optionText' $selectedHTML>$optionText</option>";
			}
		}
		
		$html .= "</select>";
		
		return $html;
	}

/****************************************************************
	
	Generic DB generated dropdowns that require no parms

*****************************************************************/

	function getChannelsDropdown($elementID, $orderBy = 1, $withBlank = true, $preSelected = '', $valueAndTextAreDifferent = true, $excludeDisabled = true)
	{
		return $this->buildDropdown($elementID, 'propagandaChannel', 'id', 'channelName', $orderBy, $withBlank, $preSelected, $valueAndTextAreDifferent, $excludeDisabled);
	}

}
	
?>
