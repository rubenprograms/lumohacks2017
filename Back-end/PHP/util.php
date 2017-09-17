<?php
	function mysql_fatal_error($msg) 
	{
		$msg2 = mysqli_error();
		echo <<< _END
		We are sorry, but it was not possible to complete the requested task. The error message we got was:
		<p>$msg: $msg2</p>
		Please click the back button on your browser and try again. If you are still having problems, please <a href="mailto:admin@server.com">email our administrator</a>. Thank you.
_END;
	}
?>