# StudentSocialNetwork
A student social network that emphasizes on collaborative learning through the use of structured discussion forums. Developed using a combination of the Boostrap web development framework for the front-end and PHP for the back-end.

Setting up the Social Network

1. Download and Install XAMPP
- Go to https://www.apachefriends.org/index.html
- Download the software for your respective operating system
- A message will pop-up warning you about User Account Control and how it may affect some functions of XAMPP. Just click OK and continue with the installation. The setup wizard should appear after you click OK.
- Go through the setup wizard and install it on your system. Make sure every component is checked and set your installation folder 

2. Download the files for the social network
- This is included in the zip file upload, there should be a folder called "USN"

3. Copying the social network files to XAMPP
- Navigate to the location of the installed software. In my case it would be C:\xampp
- Navigate to the "htdocs" folder
- Copy and paste the "USN" folder into the "htdocs" folder

4. Setting up the database
- Navigate back to C:\xampp
- Launch the application called "xampp-control.exe"
- You will be presented with the GUI for the XAMPP Control Panel, with various modules displayed
- The only two modules that you need to "Start" is the Apache and MySQL module, ignore the rest
- Start both modules by clicking the "Start" button beside those respective modules. The modules will be highlighted in green when it has been started
- Once both modules have started, open a web browser and type in "localhost/phpmyadmin" and hit enter
- You will be presented with the phpmyadmin page, where you can manage your local databases. 
- Click the "Databases" tab on the top and create a database named "socialnetwork"
- Once it is created, click the database on the left side and then click the "Import" tab on the top.
- Choose the .sql file included in the zip file to import and confirm the import
- The tables should be created once the import is finished

5. Launching the social network
- Make sure both Apache and MySQL modules are running from the XAMPP Control Panel
- Open a web browser and type in "localhost/USN" and then the index page should be presented to you. You can test the website from here.


Additional Information/Help
- If it says "No Privileges" under the "Create Database" option, clear your cookies and cache for your localhost
- Here is a YouTube video explaining how to install XAMPP : https://www.youtube.com/watch?v=N6ENnaRotmo
- Here is a YouTube video explaining how to create a database : https://www.youtube.com/watch?v=ueWpNe0PG34
- Here is a YouTube video explaining how to run the website using XAMPP : https://www.youtube.com/watch?v=k9em7Ey00xQ
