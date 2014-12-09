<?php

echo "<table><form target=\"paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\"><tr><td valign=\"middle\">
    <input type=\"hidden\" name=\"cmd\" value=\"".$paypal[0]."\">
    <input type=\"hidden\" name=\"amount\" value=\"".$paypal[2]."\">
    <input type=\"hidden\" name=\"business\" value=\"paypal@wuk.ch\">
    <input type=\"hidden\" name=\"item_name\" value=\"".$paypal[1]."\">
    <input type=\"hidden\" name=\"item_number\" value=\"Custom Tables\">
    <input type=\"hidden\" name=\"add\" value=\"1\">";
if ($paypal[3] != '') { echo $paypal[3]; } else { echo "<input type=\"hidden\" name=\"quantity\" value=\"1\">"; }
echo "<input type=\"hidden\" name=\"no_shipping\" value=\"1\">
    <input type=\"hidden\" name=\"no_note\" value=\"0\">
    <input type=\"hidden\" name=\"currency_code\" value=\"EUR\">
    <input type=\"hidden\" name=\"lc\" value=\"CH\">
    <input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF\"></td><td valign=\"middle\">
    <input type=\"image\" src=\"https://www.paypalobjects.com/en_US/i/bnr/horizontal_solution_PP_old.gif\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online.\">
</td></tr></form></table>";

?>