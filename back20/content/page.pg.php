<p>These are the blog entries on this site.</p>

<div id="Create"><input type="button" value=" Create a Web Page " onclick="createEntry()" /></div>

<div id="Order">Sort by: <select name="listOrder" onchange="Ajax()">
	<option value="title" selected="selected">Title</option>
	<option value="author">Author</option>
	<option value="catagories">Catagory</option>
	<option value="date">Modified</option>
	<option value="id">Created</option>
</select> &nbsp; Filter: <input type="text" name="Filter" value="" maxlength="40" size="14" onkeyup="Ajax()" /></div>

<div id="listTable"><span id="Throbber">Loading pages...</span></div>

<div id="totalEntries"><span id="entryNum">0</span> Web Pages</div>

<div id="tableNav"><input type="button" name="tablePrevious" value="&lt; Previous 20" onclick="tableMinus()" />&nbsp; <input type="button" name="tableNext" value="   Next 20 &gt;   " onclick="tablePlus()" /></div>

<div id="overlay">
	<div id="inputCard">
		<p id="cardTitle">Web Page</p>
		<div id="errorReport"></div>
		<table width="100%" cellspacing="2" cellpadding="1">
			<tr>
				<th width="18%">Title</th>
				<td><input type="text" name="item1" value="" maxlength="70" /></td>			
			</tr>
			<tr>
				<th>Catagory</th>
				<td><input type="text" name="item2" value="" maxlength="100" style="width:65%" />
					<select name="catagorySelect" onchange="addCatagories('item2')" style="width:29%">
						<option value="">add tag</option>
						<option value="" disabled="disabled">&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;</option>
					</select>
				</td>
			</tr>
		</table>
		<div id="textArea"><textarea name="textBox" id="textBox"></textarea></div>
		<input type="hidden" name="item3" value="" /><input type="hidden" name="item4" value="" /><input type="hidden" name="item5" value="" /><input type="hidden" name="item6" value="" /><input type="hidden" name="item7" value="" /><input type="hidden" name="item8" value="" />
		<p><input type="button" value="  Save  " onclick="saveBtn()" /> &nbsp; <input type="button" value=" Cancel " onclick="cancelBtn()" /></p>
	</div>
</div>

<!--script language="javascript">generate_wysiwyg('textBox')</script-->
<!--script type="text/javascript">WYSIWYG.attach('textBox')</script-->
