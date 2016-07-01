<p>These are the events you have on your calendar.</p>

<div id="Create"><input type="button" value=" Create an Event " onclick="createEntry()" /></div>

<div id="Order">Calendar: <select name="listOrder" onchange="Ajax()">
	<option value="0" selected="selected">Everything</option>
	<option value="" disabled="disabled">&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;</option>
	{LIST_USERS}
</select> &nbsp; <input type="hidden" name="Filter" value="" /> <a href="../calendar.rss"><img src="template/graphics/rss.png" alt="RSS Feed" /></a></div>

<div id="listTable"><span id="Throbber">Loading calendar...</span></div>

<div id="totalEntries"><span id="entryNum">0</span> events</div>

<div id="tableNav">&nbsp;</div>

<div id="overlay">
	<div id="inputCard">
		<p id="cardTitle">Calendar Event</p>
		<div id="errorReport"></div>
		<table width="100%" cellspacing="2" cellpadding="1">
			<tr>
				<th width="18%">What</th>
				<td><input type="text" name="item1" value="" maxlength="50" /></td>			
			</tr>
			<tr>
				<th>Where</th>
				<td><input type="text" name="item2" value="" maxlength="80" /></td>			
			</tr>
			<tr>
				<th>When</th>
				<td><script type="text/javascript">var cal1=new CalendarPopup('calendarPop');</script><input type="text" name="item3a" id="item3a" value="" maxlength="10" style="width:16%" title="Year-Month-Day" onclick="cal1.select(document.form.item3a,'item3a','yyyy-MM-dd'); return false;" onchange="if (document.form.item5a.value=='') document.form.item5a.value=this.value;" /> at <input type="text" name="item3b" value="" maxlength="8" style="width:14%" /> &nbsp;<strong>to</strong>&nbsp; <input type="text" name="item5a" id="item5a" value="" maxlength="10" style="width:16%" title="Year-Month-Day" onclick="cal1.select(document.form.item5a,'item5a','yyyy-MM-dd'); return false;" onfocus="if (this.value=='') this.value=document.form.item3a.value;" /> at <input type="text" name="item5b" value="" maxlength="8" style="width:14%" /><input type="hidden" name="item3" value="" /> <input type="button" value="All Day" style="width:15%" onclick="setAllDay()" /></td>			
			</tr>
			<tr>
				<th>Catagory</th>
				<td><input type="text" name="item6" value="" maxlength="100" style="width:65%" />
					<select name="catagorySelect" onchange="addCatagories('item6')" style="width:29%">
						<option value="">add tag</option>
						<option value="" disabled="disabled">&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;</option>
					</select>			
				</td>			
			</tr>
		</table>
		<div id="textArea"><textarea name="textBox" id="textBox"></textarea></div>
		<div id="checkBoxes"><input type="button" value="Google Maps" onclick="openWindow('http://maps.google.com/')" /> &nbsp;&nbsp;&nbsp;&nbsp; Repeat &nbsp;<select name="item7"><option value="0">none</option><option value="1">weekdays</option><option value="2">weekly</option><option value="3">monthly</option><option value="4">yearly</option></select> &nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="item8" id="item8" value="0" onchange="checkBox('item8')" /><label for="item8">Make this event private</label></div>
		<input type="hidden" name="item4" value="" /><input type="hidden" name="item5" value="" />
		<p><input type="button" value="  Save  " onclick="saveBtn()" /> &nbsp; <input type="button" value=" Cancel " onclick="cancelBtn()" /></p>
	</div>
	<div id="calendarPop"></div>
</div>

<!--script language="javascript">generate_wysiwyg('textBox')</script-->
<!--script type="text/javascript">WYSIWYG.attach('textBox')</script-->