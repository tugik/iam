<?php
include("/auth.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>iam</title>
</head>

<h3>Show last load and update accounts on FW</h3>
<div id="updateblock">
    <h2>Updating....</h2>
</div>


<script  type="text/javascript">
    setInterval(
        function changeBlock(id) {
            document.getElementById('updateblock').innerHTML = '<iframe width="1500" height="800" src="index_accounts2.html" frameborder="0" allowfullscreen></iframe>';
        } , 10000) ;
</script>
