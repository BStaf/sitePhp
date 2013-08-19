<html>
<body>

<form action="blogEntry.php" method="post"
enctype="multipart/form-data">


User: <input type="text" name="fname">
Password: <input type="text" name="age">
<hr>
<br>
Title: <input type="text" size="50" name="title">
<br>
<textarea rows="30" cols="80" name="quote">

</textarea>
<br>
Pictures to Upload:
<div id="PicUpload">
<label for="file">Picture:</label>
<input type="file" name="Pic1" id="Pic1">
<br>
</div>
<input type="submit">
</form>

</body>
</html>