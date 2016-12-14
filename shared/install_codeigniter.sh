sudo apt-get install unzip
wget https://github.com/bcit-ci/CodeIgniter/archive/3.1.2.zip
unzip 3.1.2.zip
sudo rm CodeIgniter-3.1.2/.gitignore
sudo rm -rf CodeIgniter-3.1.2/user_guide
ls /var/www/html/project/application/config | xargs -I {} sudo rm -f CodeIgniter-3.1.2/application/config/{}
ls /var/www/html/project/application/controllers | xargs -I {} sudo rm -f CodeIgniter-3.1.2/application/controllers/{}
ls /var/www/html/project/application/models | xargs -I {} sudo rm -f CodeIgniter-3.1.2/application/models/{}
ls /var/www/html/project/application/views | xargs -I {} sudo rm -f CodeIgniter-3.1.2/application/views/{}
sudo cp -r CodeIgniter-3.1.2/* /var/www/html/project/
sudo rm -rf CodeIgniter-3.1.2
sudo rm 3.1.2.zip