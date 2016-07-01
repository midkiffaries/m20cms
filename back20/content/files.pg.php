<p>These are all the files stored on this site.</p>

<div id="Create"><a href="upload.file">Upload a File</a></div>

<div id="Order">File type: <select name="listOrder" onchange="Ajax()">
	<option value="all" selected="selected">All</option>
	<option value="document">Document</option>
	<option value="picture">Picture</option>
	<option value="music">Audio</option>
	<option value="video">Video</option>
	<option value="misc">Misc</option>
</select> <input type="hidden" name="Filter" value="" /></div>

<div id="listTable"><span id="Throbber">Loading files...</span></div>

<div id="totalEntries"><span id="entryNum">0</span> files</div>

<div id="tableNav"><input type="button" name="tablePrevious" value="&lt; Previous 20" onclick="tableMinus()" />&nbsp; <input type="button" name="tableNext" value="   Next 20 &gt;   " onclick="tablePlus()" /></div>

<div id="overlay">
	<div id="inputCard" style="padding:0"><iframe src="content/upload.php" width="580" height="150" scrolling="no" frameborder="0"></iframe></div>
	<div id="errorReport"></div><input type="hidden" name="item1" value="" /><input type="hidden" name="item2" value="" /><input type="hidden" name="item3" value="" /><input type="hidden" name="item4" value="" /><input type="hidden" name="item5" value="" /><input type="hidden" name="item6" value="" /><input type="hidden" name="item7" value="" /><input type="hidden" name="item8" value="" /><textarea name="textBox" class="Hide"></textarea>
</div>

<div id="imageBox" onclick="this.style.display='none'"></div>