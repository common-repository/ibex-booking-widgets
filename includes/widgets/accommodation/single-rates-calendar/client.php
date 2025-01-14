<?php

// Don't use wordpress themes
define('WP_USE_THEMES', false);

require '../../../../../../../wp-blog-header.php';

// Get the options
$opid = get_option('ibw-option-base-operatorid', '');

// Pid
$pid = isset($_GET['pid']) ? htmlentities($_GET['pid']) : false;
$ru = isset($_GET['ru']) ? htmlentities($_GET['ru']) : null;
$theme = isset($_GET['theme']) ? htmlentities($_GET['theme']) : 'navy';

$target = htmlentities($_GET['target']);

$allMinStays = isset($_GET['allminstays']) && $_GET['allminstays'] != 'true' ? false : true;
$hideUnavailMinStays = isset($_GET['hideunavailminstays']) && $_GET['hideunavailminstays'] != 'true' ? false : true;
$showMaxGuests = isset($_GET['showmaxguests']) && $_GET['showmaxguests'] != 'true' ? false : true;
$showRateName = isset($_GET['showratename']) && $_GET['showratename'] != 'true' ? false : true;

$dateOffset = isset($_GET['dateoffset']) && is_numeric($_GET['dateoffset']) ? htmlentities($_GET['dateoffset']) : 0;
$days = isset($_GET['days']) && is_numeric($_GET['days']) ? htmlentities($_GET['days']) : 7;

$httpAgent = plugins_url('scripts/ibex-message-agent.html' , dirname(__FILE__));
$themeURL = plugins_url('single-rates-calendar/style.css' , dirname(__FILE__));

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>iBex Online Bookings</title>

		<!-- DO NOT REMOVE OR CHANGE THE FOLLOWING STATEMENT -->
		<script type="text/javascript" src="Seekom"></script>

		<!-- jQuery & jQuery UI -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>

		<!-- Calendar Theme -->
		<link href="theme/jquery-ui.css" rel="stylesheet" />

		<script language="javascript" type="text/javascript">

			// ----- Specify configuration options below
			// ----- At a minimum you must specify the OperatorId and PropertyId options and the remaining more advanced options are optional
			// ----- depending on your requirements


			// ----- REQUIRED; Do not change
			var ibexBuilder = new SeekomDisplayBuilder();


			// ----- Identification settings

			// ----- OperatorId REQUIRED: The iBex operator ID
			ibexBuilder.OperatorId = '<?php echo $opid?>';

			// ----- PropertyId REQUIRED: The iBex property ID. Note that multi-property operators can define this value dynamically enabling
			// ----- a single template file to be used for multiple properties. You can do this by passing the property ID as a URL parameter
			// ----- value, eg "&prop=1234", which can be retrieved via the "getUrlParam" javascript function when this file is loaded.
			// ----- eg ibexBuilder.PropertyId = getUrlParam('prop');
			ibexBuilder.PropertyId = <?php echo $pid ?>;

			// ----- RegUserId: An optional iBex registered user ID used when retrieving the room and rate information to display in the calendar.
			// ----- This may be used to restrict the rooms and / or rates displayed in the calendar.
			ibexBuilder.RegUserId = '<?php echo $ru ?>';


			// ----- Booking window settings

			// ----- TargetUrl REQUIRED: The URL to be loaded when the user clicks a calendar cell.
			// ----- NOTE If you are loading your own target page which will include the iBex booking page within an iFrame (the container page), then
			// ----- your container page must forward all relevant URL parameters when it loads the iBex page.
			ibexBuilder.TargetUrl = '<?php echo $target ?>';

			// ----- TargetWindow: The target browser window to be loaded when the user clicks a calendar cell.
			// ----- Any "non-special" name (see the Javascript window.open "sname" parameter) will open a single new browser window the first time
			// ----- a calendar cell is clicked - which will be reused for subsequent calendar clicks.
			ibexBuilder.TargetWindow = '_top';

			// ----- TargetRegUserId: An optional iBex registered user ID to be passed to the booking pages.
			// ----- NOTE Do not confuse with "RegUserId" above which, if specified, is used only during preparation of the calendar.
			ibexBuilder.TargetRegUserId = '<?php echo $ru ?>';


			// ----- Calendar appearance settings

			// ----- CustomColorScheme: The color scheme name use on iBex calendar
			// ----- If empty or the color scheme does not exist then default color is blue
			// ----- These are the current available calendar color scheme (brown, green, navy, orange, pink, purple, red, slate)
			ibexBuilder.CustomColorScheme = '<?php echo $theme?>';

			// ----- AllMinStays: If true, then all minimum stay values for each rate are shown on the calendar.
			// ----- If false, then the first available minimum stay value is shown for each day.
			ibexBuilder.AllMinStays = <?php echo $allMinStays ? 'true' : 'false'?>;

			// ----- HideUnavailMinStays: If true and AllMinStays above is true, then minimum stay rows with no rates / availability are not showm.
			ibexBuilder.HideUnavailMinStays = <?php echo $hideUnavailMinStays ? 'true' : 'false'?>;

			// ----- ShowMaxGuest: If true, then the number of max guest will be shown for each rate on the calendar.
			ibexBuilder.ShowMaxGuest = <?php echo $showMaxGuests ? 'true' : 'false'?>;

			// ----- ShowRateName: if true, then rate name column will be shown on the calendar.
			ibexBuilder.ShowRateName = <?php echo $showRateName ? 'true' : 'false'?>;

			// ----- RoomIds: Optional list of iBex room IDs used to limit the rooms shown on the calendar.
			// ----- NOTE In most cases it is better to limit the displayed rooms and rates using the "RegUserId" option above as using specific
			// ----- room IDs may result in a failure if the property operator deletes a room ID.
			// ----- NB Specify as "new Array(1234, 3456);" ... AND a single ID MUST be enclosed in quotes eg ... new Array("1234");
			ibexBuilder.RoomIds = new Array();

			// ----- RateIds: Optional list of iBex rate IDs used to limit the rates shown on the calendar.
			// ----- NOTE In most cases it is better to limit the displayed rooms and rates using the "RegUserId" option above as using specific
			// ----- rate IDs may result in a failure if the property operator deletes a rate ID.
			// ----- NB Specify as "new Array(1234, 3456);" ... AND a single ID MUST be enclosed in quotes eg ... new Array("1234");
			ibexBuilder.RateIds = new Array();

			// ----- StartOffsetDays: No of days offset for initial start of calendar (NB 0 = browser's "today")
			ibexBuilder.StartOffsetDays = <?php echo $dateOffset?>;

			// ----- NoOfDays: No of days to display in the calendar.
			// ----- NOTE changing this value will require you to change the "ColWidths" setting and the container "<div>" width
			ibexBuilder.NoOfDays = <?php echo $days?>;
			//ibexBuilder.NoOfDays = 14;

			// ----- ColWidths: Relative widths used for the calendar table columns.
			// ----- NOTE The settings here work with the default CSS settings. Changing fonts, text sizes etc may require that you
			// ----- also change values here
			<?php if($days <= 10){ ?>
			ibexBuilder.ColWidths = {Name: '30%', Guests: '7%', MinStay: '7%', Days: '7%'};
			<?php } else { ?>
			ibexBuilder.ColWidths = {Name: '20%', Guests: '5%', MinStay: '5%', Days: '5%'};	// Works for 14 days with default CSS
			<?php } ?>

			// ----- REQUIRED: Do not change, use to auto set calendar iframe
			// ----- NOTE add the following javascript to your web page that call this calendar
			/*
				<script>
					// Resize iframe to full height
					function resizeIframe(height)
					{
						// "+60" is a general rule of thumb to allow for differences in
						// IE & and FF height reporting, can be adjusted as required..
						document.getElementById('calPage').height = parseInt(height)+60;
					}
				<script>
			*/
			ibexBuilder.ibexHelper = '<?php echo $httpAgent ?>';

			/**
		     * This function check if the browser is Safari then return a true of false
			 *@return boolean
			 */
			var isSafariBrowser = function(){
	              "use strict";

	              var isSafari = navigator.userAgent.indexOf("Safari") > -1;
	              var isChrome = navigator.userAgent.indexOf("Chrome") > -1;
	              if (isChrome && isSafari){ isSafari = false; }

	              if(!isSafari){
		      			// Check for firefox
		      			if(navigator.userAgent.indexOf("Firefox") > -1){
		      				// Check for >= 22
		      				var version = navigator.userAgent.match(/Firefox\/(\d+)/i);
		      				if(version[1] !== undefined && parseFloat(version[1]) >= 22){
		      					return true;
		      				}
		      			}
		      		}

	              return isSafari;
			};

			// ----- TargetSafariFix Ignore: The url is a fix for safari browser issue with the booking screen
			ibexBuilder.TargetSafariFix = '';
			if(isSafariBrowser()){
				ibexBuilder.TargetSafariFix = 'http://ibex.seekom.com/accommodation/distributions/safari_cookie_fix.php';
			}

		</script>


		<!-- THIS STATEMENT MUST FOLLOW THE ABOVE CONFIGURATION OPTIONS -->
		<script type="text/javascript" src="scripts/ibex-builder.js"></script>

		<link href="<?php echo $themeURL?>" rel="stylesheet" type="text/css" />

	</head>

	<body>
		<p>&nbsp;</p>
		<!--
			NOTE The default width works for a 7-day calendar with the default CSS. Any CSS setting changes may require a change to the width setting.
			     An alternative to specifying a specific width here is to specify a "100%" width and then set a specific width on this page's containing iFrame.
		-->
		<div style="width: 100%">	<!-- 700 for 7 days, 1085 for 14 days -->
			<div id="calendarContent">
				<!-- ***** THE RATES / AVAILABILITY CALENDAR TABLE HTML WILL BE INSERTED HERE ***** -->
			</div>
			<table id="calendarFooter" class="calendarTableFooter" cellpadding="3" cellspacing="0" width="100%">
			  <tr class="footer">
				<td valign="top">Key:</td>
				<td valign="top" align="left">
					<img border="0" src="available.gif" width="10" height="10"> Available<br>
			    	<img border="0" src="on_request.gif" width="10" height="10"> By Request</font>
			    </td>
				<td align="right" width="20px">
					<!--
						NOTE The "Calendar Busy" icon is displayed while the availability data is being retrieved from the server
							 and you may require an alternative icon if you change CSS colours, background etc.
						     Generate a moving icon to your specific requirements at http://www.ajaxload.info/#preview
					-->
					<img id="calendarBusy" style="display: none" src="ajax-loader-white.gif" />
				</td>
			    <td align="right" width="1%">
					<label for="calStartDate">Start&nbsp;Date:</label>
				</td>
			    <td align="left">
					<form><input type="text" id="calStartDate" name="calStartDate" style="width: 80px;" /></form>
				</td>
			    <td>
			    	<a id="calendarPrev" class="footer nullLink" onclick="ibexBuilder.PrevPeriod();"></a>
			    </td>
			    <td>
			    	<a id="calendarNext" class="footer nullLink" onclick="ibexBuilder.NextPeriod();"></a>
			    </td>
			  </tr>
			</table>
		</div>
		<script language="javascript" type="text/javascript" src= "scripts/tooltips.js"></script>
		<iframe id="ibex-frame" src='' height='0' width='0' frameborder='0'></iframe>
		<script language="javascript" type="text/javascript">
			var bodyElement = document.getElementsByTagName('body');
			var calendarFooter = document.getElementById('calendarFooter');
			var colorScheme = (typeof ibexBuilder.CustomColorScheme === 'undefined' || ibexBuilder.CustomColorScheme === '' ? 'navy' : ibexBuilder.CustomColorScheme);

			calendarFooter.setAttribute('class', 'calendarTableFooter ' + colorScheme.toLowerCase());
			bodyElement[0].className = colorScheme.toLowerCase();
		</script>
	</body>
</html>