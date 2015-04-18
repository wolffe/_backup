<script>
function sendNewsletter(formID, textID, value) {
	var formElement = document.getElementById(formID);
	var limit = document.getElementById(textID);
	limit.value = value;
	formElement.submit();
}
</script>
<?php
$delete = ''; $activate = '';

if(isset($_REQUEST['del']))
	$delete = $_REQUEST['del'];
if(isset($_REQUEST['actv']))
	$activate = $_REQUEST['actv'];

$message = '';
$succcessMsg = true;
$membersUpdate = false;
$limit = 0;

if(isset($_POST['send'])) {
	$limit = $_POST['postLimit'];

	$posts = tycoonNewsletter::getPostsSince($to, $since);
	$pcount = count($posts);

	$content = tycoonNewsletter::generateContent($posts, $limit);
	if(tycoonNewsletter::sendNewsletter($content)) {
		$limit = 0;
		$message = __('Newsletter sent successfully.', 'tycoon');
		tycoonNewsletter::printMessage($message);
	}
	else {
		$message = __('An error occured while sending the newsletter. Please try again later.', 'tycoon');
		tycoonNewsletter::printMessage($message, false);
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update') {
	$settings = array();
	$settings['period'] = $_POST['period'];
	$settings['spp'] = $_POST['spp'];
	$settings['letterPostType'] = $_POST['letterPostType'];

	if(isset($_POST['count']) && is_numeric($_POST['count']) && $_POST['count'] > 0)
		$settings['count'] = $_POST['count'];

	$settings['sender'] 	= $_POST['letterSender'];
	$settings['from'] 		= $_POST['letterFrom'];
	$settings['subject'] 	= $_POST['letterSubject'];
	$settings['go'] 		= $_POST['letterGo'];
	$settings['header'] 	= $_POST['letterHeader'];
	$settings['template'] 	= $_POST['letterTemplate'];
	$settings['footer'] 	= $_POST['letterFooter'];

	tycoonNewsletter::saveSettings($settings);
	$message = __('Settings updated successfully.', 'tycoon');
	tycoonNewsletter::printMessage($message);
}

if(is_numeric($activate)) {
	$membersUpdate = true;
	if(tycoonNewsletter::activateSubscriber($activate)) {
		$message = __('Subscription activated.', 'tycoon');
		$succcessMsg = true;
	}
	else {
		$email = tycoonNewsletter::getSubscriptionEmail($activate);
		$state = tycoonNewsletter::getSubscriptionState($email);
		if($state != 'active')
			$message = __('An error occured on subscriber activation. Please try again later.', 'tycoon');
		else
			$message = __('The subscriber is already active.', 'tycoon');

		$succcessMsg = false;
	}
}

if(is_numeric($delete)) {
	$membersUpdate = true;
	tycoonNewsletter::removeSubscriber($delete);
	$message = __('Subscriber deleted successfully.', 'tycoon');
	$succcessMsg = true;
}

tycoonNewsletter::printSendDiv($limit);

tycoonNewsletter::settings();

if($membersUpdate)
	tycoonNewsletter::printMessage($message, $succcessMsg, 'msgMembers');

tycoonNewsletter::manageMembers();
?>
