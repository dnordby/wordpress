## WordPress Setup

### Local Development:

##### Dependencies
* [MAMP](https://www.mamp.info/en/) installed on local machine
* New [WordPress](https://wordpress.org/download/) download

##### Get Started
1. Open MAMP in Applications and ensure local servers are running

2. Create a new database by clicking `phpMyAdmin` in the WebStart page or [navigating there](http://localhost:8888/MAMP/index.php?page=phpmyadmin&language=English) if the WebStart page doesn't come up automatically (this setting can be adjusted under Start/Stop preferences in MAMP).

3. Click the `Databases` tab

4. In the "Create database" field, enter a unique local database name. Ideally, name the local database the same thing as what the production database is expected to be. Click `Create`.

5. Unzip the new WordPress zipfile acquired from the download and place it in the directory the MAMP server is pointing is pointing to.

6. In a browser, navigate to `localhost:8888` (or whichever port has been specified in the Apache Port field of the MAMP Ports settings). If the expected directory is not visible, check that the Web Server settings in MAMP are pointing to the correct directory.

7. In the browser, click the directory of the project theme to be built and follow the prompts to install WordPress.

8. When prompted, enter the following information to populate the database:

	* Database Name: [name chosen in step 4]
	* User Name: `root`
	* Password: `root`
	* Database Host: `localhost`
	* Table Prefix: `wp_`

9. Once the WordPress Welcome screen is reached, input desired site title, create a username and password, include an email address, and check the box next to Discourage search engines from indexing this site. Be sure to make a note of the username and password selected, especially if the Password is auto-created.

10. Follow the prompts to login.



##### Installing Sage(optional based on project params)
1. Ensure [Composer](https://getcomposer.org/download/) is installed.

2. Run `php composer.phar create-project roots/sage new-theme-name 8.5.3` (specifiy Sage version at the end of the command, current build as of 10/10/17 is 8.5.3 with v.9 forthcoming).

3. Note [theme functionallity](https://roots.io/sage/docs/theme-functionality/) and [workflow](https://roots.io/sage/docs/theme-development-and-building/) docs.

4. Once the them is installed and running locally, [these commands](https://roots.io/sage/docs/theme-development-and-building/#available-gulp-commands) can be used to compile the `assets/` directory to the `dist/` directory for production.



##### Installing Timber(optional based on project params)
1. In the WordPress dashboard, install the [Timber Library](https://wordpress.org/plugins/timber-library/) and ACF.

2. [Download or clone](https://github.com/timber/starter-theme) the theme.

3. Review [Timber docs](https://timber.github.io/docs/) for theming, guides, and reference.



### Deployment to Staging/Production using WP Engine:
When hosting using WP Engine, utilize the [Git Push functionallity](https://wpengine.com/git/) to deploy.

1. Generate a new [SSH key](https://help.github.com/articles/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent/) if there are no [existing keys](https://help.github.com/articles/checking-for-existing-ssh-keys/) present. It is likely that a key already exists; a new one will likely not need to be generated.

2. Copy new/existing public SSH Key - run `pbcopy < ~/.ssh/id_rsa.pub` in the terminal (it will be available on the machine's clipboard).

3. Login to the project WP Engine dashboard. Click "Git Push" and paste the SSH key into the textarea `SSH public key`. When selecting a `Developer name`, be aware that WP Engine will remember your SSH key from install-to-install, so create a name accordingly.

4. Wait about 10 minutes (actual times can vary widely: from a few minutes to 24 hours) and confirm access by running `ssh git@git.wpengine.com info` from the terminal.

5. Add both production and staging remotes:
	* `git remote add production git@git.wpengine.com:production/my_wp_install_name.git`
	* `git remote add staging git@git.wpengine.com:staging/my_wp_install_name.git`
	* Check both have been successfully added: `git remote -v`:

	production  git@git.wpengine.com:production/my_wp_install_name.git (fetch)
	production  git@git.wpengine.com:production/my_wp_install_name.git (push)
	staging  git@git.wpengine.com:staging/my_wp_install_name.git (fetch)
	staging  git@git.wpengine.com:staging/my_wp_install_name.git (push)

6. To deploy to staging run `git deploy staging master`

7. To deploy to production run `git deploy production master`


### WP Engine Notes

##### Deploy current install to another hosted install
1. Login to the WP Engine dashboard and select the install to copy.

2. Click Backup points in menu on the left.

3. Click `Deploy Site` and follow the instructions to specify which install backup point to duplicate, which install to copy it to, and if the database should be included or not.


##### Download backup of current install
1. Login to the WP Engine dashboard and select the install to copy.

2. Click Backup points in menu on the left.

3. Select a backup point and click Download ZIP. The package [will contain](https://wpengine.com/support/wp-engine-backups-contain/) all WordPress core files, themes and plugins, and database.


##### Migrate site
1. Login to the WP Engine dashboard and select the install to copy.

2. Click Site migration in menu on the left.

3. Use the video and SFTP information on the page to complete site transfers
