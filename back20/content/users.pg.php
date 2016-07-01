<p>These are the people who have access to the CMS.</p>

<div id="Create"><input type="button" value=" Create a User " onclick="createEntry()" /></div>

<div id="Order">Sort by: <select name="listOrder" onchange="Ajax()">
	<option value="firstname">First Name</option>
	<option value="lastname" selected="selected">Last Name</option>
	<option value="username">User Name</option>
	<option value="email">E-mail</option>
	<option value="date">Modified</option>
	<option value="created">Created</option>
</select> &nbsp; Filter: <input type="text" name="Filter" value="" maxlength="40" size="14" onkeyup="Ajax()" /></div>

<div id="listTable"><span id="Throbber">Loading users...</span></div>

<div id="totalEntries"><span id="entryNum">0</span> users</div>

<div id="tableNav"><input type="button" name="tablePrevious" value="&lt; Previous 20" onclick="tableMinus()" />&nbsp; <input type="button" name="tableNext" value="   Next 20 &gt;   " onclick="tablePlus()" /></div>

<div id="overlay">
	<div id="inputCard">
		<p id="cardTitle">User Profile</p>
		<div id="errorReport"></div>
		<table width="100%" cellspacing="2" cellpadding="1">
			<tr>
				<th width="26%">First Name</th>
				<td><input type="text" name="item1" value="" maxlength="25" /></td>			
			</tr>
			<tr>
				<th>Last Name</th>
				<td><input type="text" name="item2" value="" maxlength="25" /></td>			
			</tr>
			<tr>
				<th>Username</th>
				<td><input type="text" name="item3" value="" maxlength="25" /></td>			
			</tr>
			<tr>
				<th>E-mail</th>
				<td><input type="text" name="item4" value="" maxlength="35" /></td>			
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="item5" value="" maxlength="26" /></td>			
			</tr>
			<tr>
				<th>Confirm Password</th>
				<td><input type="password" name="item6" value="" maxlength="26" /></td>			
			</tr>
			<tr>
				<th>Avatar</th>
				<td><input type="text" name="item7" value="" maxlength="100" /></td>			
			</tr>
		</table>
		<input type="hidden" name="item8" value="1" /><textarea name="textBox" class="Hide"></textarea>
		<p><input type="button" value="  Save  " onclick="saveBtn()" /> &nbsp; <input type="button" value=" Cancel " onclick="cancelBtn()" /></p>
	</div>
</div>