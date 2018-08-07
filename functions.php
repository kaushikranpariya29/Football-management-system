<?php

	function clear($input)
	{
		trim($input);
		stripcslashes($input);
		htmlspecialchars($input);
		return $input;
	}
?>