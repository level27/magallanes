# magallanes

### What's Magallanes? ###
 Magallanes is a deployment tool for PHP applications; it's quite simple to use and manage.
 It will get your application to a safe harbor.
 See http://magephp.com.

### This repository ###
At Level27, we like Magallanes and we have composed this little repository, with some custom tasks, to clone on
build servers and use to deploy your applications.
You can do a composer install to get Magallanes. We currently use 1.0.3, because the latest version 1.0.6 has serious
issues with autoloading custom tasks. Use a symlink to the tasks subdirectory here in your .mage config directory.