<?




echo "<tr><td valign=top class=admin align=left colspan=2><font class=stats_header>General Settings</font><p>These are some basic and general settings for this website.<p><br></td></tr>";

form_input($site_name,"site_name","Site Title","The title of your website.");
form_input($freeitem,"freeitem","Free Item Name","The name of the free service you provide.");
form_input($paypal_item,"paypal_item","Paid Item Name","The name of the paid service you provide.");




echo "<tr><td valign=top class=admin colspan=2><hr><br></td></tr>";
echo "<tr><td valign=top class=admin align=left colspan=2><font class=stats_header>Free & Paid Limits Settings</font><p>These are the settings for how many pageloads and how many detailed records your members are entitled to according to their account type.<p><br></td></tr>";

form_input($free_record_limit,"free_record_limit","Free Record Limit","The number of detailed database records free members get.");
form_input($paid_record_limit1,"paid_record_limit1","Paid Record Limit 1","The number of detailed database records paid members level 1 get.");
form_input($paid_record_limit2,"paid_record_limit2","Paid Record Limit 2","The number of detailed database records paid members level 2 get.");
form_input($paid_record_limit3,"paid_record_limit3","Paid Record Limit 3","The number of detailed database records paid members level 3 get.");
form_input($free_pageload_limit,"free_pageload_limit","Free Pageload Limit","The number of monthly pageloads free members get.");
form_input($paid_pageload_limit1,"paid_pageload_limit1","Paid Pageload Limit 1","The number of monthly pageloads paid members level 1 get.");
form_input($paid_pageload_limit2,"paid_pageload_limit2","Paid Pageload Limit 2","The number of monthly pageloads paid members level 2 get.");
form_input($paid_pageload_limit3,"paid_pageload_limit3","Paid Pageload Limit 3","The number of monthly pageloads paid members level 3 get.");




echo "<tr><td valign=top class=admin colspan=2><hr><br></td></tr>";
echo "<tr><td valign=top class=admin align=left colspan=2><font class=stats_header>Price & Paypal Settings</font><p>These settings control the prices of paid memberships and other paypal variables used when payments are made using paypal subscriptions.<p><br></td></tr>";

form_input($paypal_email,"paypal_email","PayPal Email","Your PayPal email address, where you accept payments.");
form_input($paypal_item_number,"paypal_item_number","PayPal Item Number","Just an item number for sales, this can be whatever you want or need it to be.");
form_input($paypal_price1,"paypal_price1","Price Level 1","The price for paid membership level 1.");
form_input($paypal_price2,"paypal_price2","Price Level 2","The price for paid membership level 2");
form_input($paypal_price3,"paypal_price3","Price Level 3","The price for paid membership level 3");
form_input($paypal_term,"paypal_term","PayPal Term","The term of recurring monthly payments,'W' for weekly, 'M' for monthly, 'Y' for yearly.");
form_input($paypal_period,"paypal_period","PayPal Period","The number of recurring payment periods in the above term, 1 for once a month or once a year, etc.");






echo "<tr><td valign=top class=admin colspan=2><hr><br></td></tr>";
echo "<tr><td valign=top class=admin align=left colspan=2><font class=stats_header>Miscellaneous Settings</font><p>These are some miscellaneous settings which do not fit into any other category.<p><br></td></tr>";

form_input($limitresults,"limitresults","Limit Results","Limit the results of stat reports to this many before a new page is created for the remaining results.");
form_input($onlineduration,"onlineduration","Online Duration Time","The amount of time of inactivity in seconds before a visitor is considered to no longer be 'online'. For example, 180 would be 3 minutes.");
form_input($newvisitduration,"newvisitduration","New Visit Duration Time","The amount of time in seconds of inactivity before a visitor is considered to be making a 'new visit'. For example, 3600 would be 1 hour.");
form_input($counter_max_length,"counter_max_length","Counter Max Length","Make this a string of zeros representing the longest value a counter will ever be. For example, if you do not want longer than a 10 digit counter to ever show on members pages, put 10 zeros here.");
form_input($mincountdigits,"mincountdigits","Counter Minimum Length","This is the minimum amount of digits a counter will ever be. For example, making this 5 would make a counter with a value of 67 read 00067.");



echo "<tr><td valign=top class=admin colspan=2><hr><br></td></tr>";
echo "<tr><td valign=top class=admin align=left colspan=2><font class=stats_header>Email Settings</font><p>These settings control some email aspects of the website, such as what email address automatic emails are sent from and whether or not to send the admin an email every time someone signs up.<p><br></td></tr>";

form_input($your_email,"your_email","Admin Email","The main email for the site. All email sent out by this script will show this email address. This applies to emails sent automatically by this script. Emails you send from the admin area will let you specify the sender address.");
form_input($email_me_on_signup,"email_me_on_signup","Email Me On Signup","Send the above main email address an email full of information for every new person that signs up. A 0 (zero) means do not send the email, a 1 means send the email.");
form_input($sleep,"sleep","Email Pause","The amount of time in seconds your server will pause in between emails when you are sending mass emails to all of your members. Allowing the pause slows the results page, but in less resource intensive on your server.");




echo "<tr><td valign=top class=admin colspan=2><hr><br></td></tr>";
echo "<tr><td valign=top class=admin align=left colspan=2><font class=stats_header>General Graph Settings</font><p>These are the basic graph settings for bar and pie graphs. Bar graphs will only have up 2 4 arrays of information (4 sets of gradient colored bars) which require 8 colors (2 colors per bar blended together). Pie graphs can have up to 10 items shown within them, so the best results are to use 10 different colors on the pie graphs. The only exception to those rules are the Database Usage Bar Graphs shown in the next section below.<p><br></td></tr>";

form_input($graph_width,"graph_width","Graph Width","This is the width of all the graphs in pixels.");
form_input($graph_height,"graph_height","Graph Height","This is the height of all the graphs in pixels.");
form_input2($bcolor,"bcolor","Graph Background Color","This is the background color for the graph images.");
form_input3($piecolors,"piecolors","Pie Graph Colors","These are the colors used in the pie graphs, seperated by comma. Put as many here as you want, the colors will be applied to pie graphs in order, and then repeat from the beginning again if necessary.");
form_input2($colo3,"colo3","1st Bar Color 1","This is the first color used to make the gradient in single bar graphs (top of bar).");
form_input2($colo4,"colo4","1st Bar Color 2","This is the second color used to make the gradient in single bar graphs (bottom of bar).");
form_input2($colo1,"colo1","2nd Bar Color 1","This is the first color used to make the gradient on the second set of bars in 2 barred bar graphs (top of bar).");
form_input2($colo2,"colo2","2nd Bar Color 2","This is the second color used to make the gradient on the second set of bars in 2 barred bar graphs (bottom of bar).");

form_input2($colo1a,"colo1a","3rd Bar Color 1","This is the first color used to make the gradient on the third set of bars in 3 barred bar graphs (top of bar).");
form_input2($colo1b,"colo1b","3rd Bar Color 2","This is the second color used to make the gradient on the third set of bars in 3 barred bar graphs (bottom of bar).");
form_input2($colo2a,"colo2a","4th Bar Color 1","This is the first color used to make the gradient on the fourth set of bars in 4 barred bar graphs (top of bar).");
form_input2($colo2b,"colo2b","4th Bar Color 2","This is the second color used to make the gradient on the fourth set of bars in 4 barred bar graphs (bottom of bar).");
form_input2($colo3a,"colo3a","5th Bar Color 1","This is the first color used to make the gradient on the fifth set of bars in 5 barred bar graphs (top of bar).");
form_input2($colo3b,"colo3b","5th Bar Color 2","This is the second color used to make the gradient on the fifth set of bars in 5 barred bar graphs (bottom of bar).");






echo "<tr><td valign=top class=admin colspan=2><hr><br></td></tr>";
echo "<tr><td valign=top class=admin align=left colspan=2><font class=stats_header>Database Usage Bar Graph Settings</font><p>These settings control only the colors of the bar graph used to display Detailed Record Database Usage and Monthly Pageload Usage, which have far more colors in them than do the other bar graphs found throughout the site. These graphs are only found on the Detailed Records Summary page when viewing the summary for all campaigns. You cannot change the colors for the first bar in this graph, this bar (which represents the members current level) changes from green to red when members approach their limit, so it is best to avoid using green or red bars anywhere else in this graph.<p><br></td></tr>";
 
form_input2($colo7,"colo7","2nd Bar Color 1","This is the first color used to make the gradient on the second bar in the database usage graph (top of 'Your Limit' bar).");
form_input2($colo8,"colo8","2nd Bar Color 2","This is the second color used to make the gradient on the second bar in the database usage graph (bottom of 'Your Limit' bar).");
form_input2($colo9,"colo9","3rd Bar Color 1","This is the first color used to make the gradient on the third bar in the database usage graph (top of 'Free Limit' bar).");
form_input2($colo10,"colo10","3rd Bar Color 2","This is the second color used to make the gradient on the third bar in the database usage graph (bottom of 'Free Limit' bar).");
form_input2($colo11,"colo11","4th Bar Color 1","This is the first color used to make the gradient on the fourth bar in the database usage graph (top of 'Paid Limit 1' bar).");
form_input2($colo12,"colo12","4th Bar Color 2","This is the second color used to make the gradient on the fourth bar in the database usage graph (bottom of 'Paid Limit 1' bar).");
form_input2($colo13,"colo13","5th Bar Color 1","This is the first color used to make the gradient on the fifth bar in the database usage graph (top of 'Paid Limit 2' bar).");
form_input2($colo14,"colo14","5th Bar Color 2","This is the second color used to make the gradient on the fifth bar in the database usage graph (bottom of 'Paid Limit 2' bar).");
form_input2($colo15,"colo15","6th Bar Color 1","This is the first color used to make the gradient on the sixth bar in the database usage graph (top of 'Paid Limit 3' bar).");
form_input2($colo16,"colo16","6th Bar Color 2","This is the second color used to make the gradient on the sixth bar in the database usage graph (bottom of 'Paid Limit 3' bar).");






function form_input($value,$name,$echo1,$echo2) {
echo "<tr><td valign=top class=admin1 width=150><b>$echo1:</b></td><td valign=top class=admin2><input class=textinput name=$name value=\"$value\"><br>$echo2<br><br></td></tr>"; }

function form_input2($value,$name,$echo1,$echo2) {
echo "<tr><td valign=top class=admin1 width=150><b>$echo1:</b></td><td valign=top class=admin2><table cellspacing=1><tr><td><input class=textinput name=$name onchange=\"$name.style.backgroundColor=this.value\" value=\"$value\"></td><td bgcolor=\"$value\" width=30>Current&nbsp;Color</table><br>$echo2<br><br></td></tr>"; }

function form_input3($value,$name,$echo1,$echo2) {
echo "<tr><td valign=top class=admin1 width=150><b>$echo1:</b></td><td valign=top class=admin2><textarea rows=5 cols=45 class=textareasmall name=$name>$value</textarea><br>$echo2<br><br></td></tr>"; }



?>