Virtaul TV Prompter Readme
(docs/readme.txt)

Description
===========
This PHP script is a virtual web-based TV prompter, for offline use.

It is meant to be a replacement for expensive binary packages around the web, and all it needs is a
modern web browser. It uses jQuery for fast execution, and realtime commands.

How to use
==========
Open the options panel by clicking on the top toolbar button, select your speed and size, paste the
text to be read and apply changes.

Experiment with text size from the top toolbar button until you're happy with it. Real time text size
is not permanent, it should be set from the options panel.

The script uses a simple options panel, a lightweight jQuery plugin and a small out-of-the-box script.

How to install
==============
1. Create a database named 'prompter'.
2. Edit /includes/config.php with your database connection details.
3. Point your web browser to /root/includes/install.php.
4. You're done! Click on the link to start using the prompter.

The script database tables and information will not be deleted or overwritten upon reexecution of install.php.
