<?php
include_once('../../../wp-blog-header.php');
include_once('newsletter-tycoon.php');

$del = $_REQUEST['del'];
$add = $_REQUEST['add'];
$delConf = $_POST['delconf'];

$content = '';
$content .= '<h1>' . get_bloginfo('name').' - ' . __('Newsletter', 'tycoon') . '</h1>';

if($del != '') {
	if(tycoonNewsletter::isConfirmation($del)) {
		if($delConf != '') {
			if($delConf == 1) {
				$id = tycoonNewsletter::getConfirmationId($del);
				$email = tycoonNewsletter::getSubscriptionEmail($id);
				tycoonNewsletter::removeSubscriber($id);
				$content .= '<div class="success">' . __('Your email has been successfully removed from the subscribers list!', 'tycoon') . '</div>';
			}
			else {
				$content .= '<div class="success">' . __('Subscription removal canceled!', 'tycoon') . '</div>';
			}
		}
		else {
			$content .= '<h2>' . __('Confirm Unsubscription', 'tycoon') . '</h2>';
			$content .= '<p>' . __('Are you sure you want to unsubscribe?', 'tycoon') .'</p>';

			$content .= '<form method="post">';
				$content .= '<input type="hidden" name="delconf" value="1">';
				$content .= '<input type="submit" name="Yes" value="' . __('Yes', 'tycoon') . '">';
			$content .= '</form>';

			$content .= '<form method="post">';
				$content .= '<input type="hidden" name="delconf" value="0">';
				$content .= '<input type="submit" name="No" value="' . __('No', 'tycoon') . '">';
			$content .= '</form>';
		}
	}
	else {
		$content .= '<div class="errorTitle">' . __('Invalid confirmation code!', 'tycoon') . '</div>';
		$content .= '<p>' . __('Make sure that you have used the full link provided in the email.', 'tycoon') . '</p>';
	}
}
elseif($add != '') {
	if(tycoonNewsletter::isConfirmation($add)) {
		$id = tycoonNewsletter::getConfirmationId($add);

		tycoonNewsletter::activateSubscriber($id);
		$email = tycoonNewsletter::getSubscriptionEmail($id);
		$content .= '<div class="success">' . __('Your email has been successfully added to the subscribers list!', 'tycoon') . '</div>';
	}
	else {
		$content .= '<div class="errorTitle">' . __('Invalid confirmation code!', 'tycoon') . '</div>';
		$content .= '<p>' . __('Make sure that you have used the full link provided in the email.', 'tycoon') . '</p>';
	}
}
else {
	header('Location: ' . get_bloginfo('url'));
	exit();
}
tycoonNewsletter::writeConfirmationPage($content);
?>
