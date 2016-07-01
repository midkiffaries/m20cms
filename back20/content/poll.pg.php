<p>These are the visitor contributed polls.</p>

<div id="Create"><input type="button" value=" Create a Poll " onclick="createEntry()" /></div>

<div id="Order">Sort by: <select name="listOrder" onchange="Ajax()">
	<option value="question" selected="selected">Question</option>
	<option value="results">Results</option>
	<option value="author">Author</option>
	<option value="date">Date</option>
</select> &nbsp; Filter: <input type="text" name="Filter" value="" maxlength="40" size="14" onkeyup="Ajax()" /></div>

<div id="listTable"><span id="Throbber">Loading polls...</span></div>

<div id="totalEntries"><span id="entryNum">0</span> polls</div>

<div id="tableNav"><input type="button" name="tablePrevious" value="&lt; Previous 20" onclick="tableMinus()" />&nbsp; <input type="button" name="tableNext" value="   Next 20 &gt;   " onclick="tablePlus()" /></div>

<div id="overlay">
	<div id="inputCard">
		<p id="cardTitle">Poll</p>
		<div id="errorReport"></div>
		<table width="100%" cellspacing="2" cellpadding="1">
			<tr>
				<th width="18%">Question</th>
				<td><input type="text" name="item1" value="" maxlength="60" /></td>			
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td></td>			
			</tr>
			<tr>
				<th>Answer 1</th>
				<td><input type="text" name="item2" value="" maxlength="50" /></td>			
			</tr>
			<tr>
				<th>Answer 2</th>
				<td><input type="text" name="item3" value="" maxlength="50" /></td>			
			</tr>
			<tr>
				<th>Answer 3</th>
				<td><input type="text" name="item4" value="" maxlength="50" /></td>			
			</tr>
			<tr>
				<th>Answer 4</th>
				<td><input type="text" name="item5" value="" maxlength="50" /></td>			
			</tr>
			<tr>
				<th>Answer 5</th>
				<td><input type="text" name="item6" value="" maxlength="50" /></td>			
			</tr>
			<tr>
				<th>Answer 6</th>
				<td><input type="text" name="item7" value="" maxlength="50" /></td>			
			</tr>
			<tr>
				<th>Answer 7</th>
				<td><input type="text" name="item8" value="" maxlength="50" /></td>			
			</tr>
		</table>
		<textarea name="textBox" class="Hide"></textarea>
		<p><input type="button" value="  Save  " onclick="saveBtn()" /> &nbsp; <input type="button" value=" Cancel " onclick="cancelBtn()" /></p>
	</div>
</div>