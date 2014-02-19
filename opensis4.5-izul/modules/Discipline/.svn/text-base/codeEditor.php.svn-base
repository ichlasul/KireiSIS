<?php
#*************************************************************************
#
# Discipline Module for Opensis
# Copyright (C) 2008 Billboard.Net
# Designer(s): Christopher Whiteley
# Contributor(s): Russell Holmes
#
#*************************************************************************
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, version 2 of the License. See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#**************************************************************************

echo '<table cellspacing="0" cellpadding="0"><tbody><tr><td width="9"/><td class="block_stroke" align="left"><table class="tab_header_bg_active" cellspacing="0" cellpadding="0" border="0" align="left"><tbody><tr id="tab[]" class="tab_header_bg_active"><td class="tab_header_left_active"/><td class="drawtab_header" align="left" valign="middle">Admin</td><td class="tab_header_right_active"/></tr></tbody></table>';
echo '</td></tr><tr><td class="block_topleft_corner"/><td class="block_topmiddle"/><td class="block_topright_corner"/></tr><tr><td class="block_left" rowspan="2"/><td class="block_bg"/><td class="block_right" rowspan="2"/></tr><tr><td><table class="block_bg" width="100%" cellspacing="0" cellpadding="5"><tbody><tr><td class="block_bg">';

$incidentTypes = array(
				       "Facilities",
				       "Incident",
				       "Injury",
				       "Location",
				       "Reporter",
				       "Time",
				       "Weapon",
				       "Perpetrator",
				       "Victim",
				       "Discipline"
                      );

$html = $html.'<h2>Adminstration</h2><table width="700px"><tr><td align="left" style="vertical-align:top;"><a href="javascript:void(\'0\')" onclick="discipline.showWorkArea(this, \'Codes\');">Edit Codes</a></td></tr>
			   <tr><td id="CodesSection" style="display:none"><table width="700px"><tr><td style="font-weight:bold;" id="codeTypeSel">Code Type <select onchange="discipline.getCodes(this.value);" id="codeSelBox"><option value="0">Select</option>';

$counter = 1;
foreach($incidentTypes as $type){
	$html = $html.'<option value="'.$counter.'" >'.$type.'</option>';
	$counter++;
}

$html = $html.'</select></td></tr></table><div id="codesTable" width="700px"></div></td></tr>';
$html = $html.'<tr><td align="left" style="vertical-align:top;"><a href="javascript:void(\'0\')" onclick="discipline.showWorkArea(this, \'Schools\', discipline.getSchools);">Edit Schools</a></td></tr>';
$html = $html.'<tr><td id="SchoolsSection" style="display:none"><div id="schoolWorkArea"></div></td></tr>';
$html = $html.'</table>';


echo $html;

echo '</td></tr></tbody></table></td></tr><tr><td class="block_left_corner"/><td class="block_middle"/><td class="block_right_corner"/></tr><tr><td class="clear" colspan="3"/></tr></tbody></table>';

?>