<?php
# messages.class.php
# All the messages!


class messages {

	# The email is already in use.
	public $uniqueEmail = "There is already an account associated with this email.";

	# The passwords do not match.
	public $mismatchPasswords = "The entered passwords do not match.";

	# The emails do not match.
	public $mismatchEmails = "The entered emails do not match.";

	# The username is already taken.
	public $usernameTaken = "The username you entered is already taken.";

	# Login successful
	public $loginGood = "You have been successfully logged in.";

	# Incorrect password
	public $loginPasswordBad = "You have entered the incorrect password";

	# Username not found
	public $loginNameBad = "That username is not found.";

	# Log out sucessful
	public $logoutGood = "You have been successfully logged out, ";

	# New account created
	public $accountCreated = "Your account has been successfully created.";

	# Something went wrong with account creation :(
	public $accountCreateFailed = "Something went wrong.  Please contact an administrator or try again later.";

	# No password, no account!
	public $blankPassword = "You must enter a password.";

	# No email, no account!
	public $blankEmail = "You must enter an email address.";

	# Logout failed somehow
	public $logoutFailed = "Something went wrong and we failed to log you out :(";

	# You need to be logged in in order to log out!
	public $logInToLogOut = "You must be logged in before you can log out!";

	# The email is invalid.
	public $invalidEmail = "The entered email is not valid.";

	# The username is too long (30 characters max)
	public $longUsername = "The entered username is too long.  30 characters max.";

	# Unknown error catch-all
	public $unknownError = "Something somewhere went horribly wrong.";	

	# You don't have the required permissions.
	public $permissions = "You do not have the required permissions to perform that function.";

	# Successful new post
	public $newPostSuccess = "Your post has been submitted.";

	# Successful post edit
	public $editPostSuccess = "Your post has been edited.";

	# Successful new topic
	public $newTopicSuccess = "Your topic has been submitted.";
}

$messages = new messages;

?>