# Travel-Guides
***CS 4750 Project by Brianna Heckert, August Lamb, Alex Walsh***

## How To Run 
1. Install XAMPP
    - https://www.cs.virginia.edu/~up3f/cs4750/supplement/XAMPP-setup.html
2. Start GCP SQL instance
3. Click the "Connections" tab on the left -> Network
    - make sure your IP address is listed under Authorized Networks
    - this might have to be completed each time bc IP addresses change but idk
4. Fill in the database info in `connect-db.php` using secrets stored in GCP SecreteManager
5. run `git update-index --assume-unchanged connect-db.php`
    - important so that database info never gets committed (only need to run command once)
6. Start XAMPP Apache Web Server
    - hit the "Manager Servers" tab at the top
    - make sure a copy of the project folder is in the XAMPP htdocs folder
    - the url will be localhost/project-folder-name

## How to Stop
1. Stop XAMPP Apache Web Server
2. **Stop GCP SQL instance**
3. `git push` branch if needed 

