<p>These are the visitor comments to the blogs.</p>

<div id="Order">Blog: <select name="listOrder" onchange="Ajax()">
	<option value="0" selected="selected">All blogs</option>
	{LIST_BLOGS}
</select> &nbsp; <input type="hidden" name="Filter" value="" /></div>

<div id="listTable"><span id="Throbber">Loading comments...</span></div>

<div id="totalEntries"><span id="entryNum">0</span> comments</div>

<div id="tableNav"><input type="button" name="tablePrevious" value="&lt; Previous 20" onclick="tableMinus()" />&nbsp; <input type="button" name="tableNext" value="   Next 20 &gt;   " onclick="tablePlus()" /></div>

<div id="overlay">
	<div id="inputCard">
		<p id="cardTitle">Visitor Comment</p>
		<div id="errorReport"></div>
		<table width="100%" cellspacing="2" cellpadding="1">
			<tr>
				<th width="18%">Blog Title</th>
				<td><input type="text" name="item1" value="" maxlength="120" readonly="readonly" /></td>			
			</tr>
			<tr>
				<th>Name</th>
				<td><input type="text" name="item2" value="" maxlength="80" /></td>			
			</tr>
			<tr>
				<th>E-mail</th>
				<td><input type="text" name="item3" value="" maxlength="80" /></td>			
			</tr>
			<tr>
				<th>IP Address</th>
				<td><input type="text" name="item5" value="" maxlength="100" readonly="readonly" /></td>			
			</tr>
		</table>
		<div id="textArea"><textarea name="textBox" id="textBox" style="height:150px"></textarea></div>
		<input type="hidden" name="item4" value="" /><input type="hidden" name="item6" value="" /><input type="hidden" name="item7" value="" /><input type="hidden" name="item8" value="" />
		<p><input type="button" value="  Save  " onclick="saveBtn()" /> &nbsp; <input type="button" value=" Cancel " onclick="cancelBtn()" /></p>
	</div>
</div>