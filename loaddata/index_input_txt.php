<?php
include("/auth.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>iam</title>
</head>

<h3>Input accesslist by text format</h3>
<h6>examples:</h6>
<h5>tcp, 10.10.1.0, 10.0.0.1, 443  # comment</h5>


<form action="insert_input_txt.php" method="post">
    <textarea name="mes" cols="150" rows="50" class="lnews_data"></textarea>
    </p>
    <p>
        <label>
            <input type="submit" name="submit" id="submit" value="submit">
        </label>
    </p>
</form>




