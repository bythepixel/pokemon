#!/usr/bin/env bash

# Deploy configuration (use absolute paths)
APP_PATH="/srv/www"
PROVISION_FILES_PATH="/vagrant/provisioning" # make sure this is absolute in prod
ENVIRONMENT="local"
API_DOMAIN="api.pokemon.local"

echo "Update ubuntu"
sudo apt-get update -y
sudo apt-get upgrade -y

echo "Install os dependencies"
sudo apt-get install nginx php php-dom php-zip php-mysql php-curl php-mbstring php-gd git dos2unix -y

echo "Install MySQL Server and Client in a Non-Interactive mode. Default root password will be \"root\""
echo "mysql-server mysql-server/root_password password root" | sudo debconf-set-selections
echo "mysql-server mysql-server/root_password_again password root" | sudo debconf-set-selections
sudo apt-get install mysql-server mysql-client -y

mysql -uroot -proot --execute="CREATE DATABASE pokemon"

echo "Install composer globally"
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

echo "Create Unix User"
# --gecos will make this interactive
sudo adduser deployer --disabled-password --gecos ""

echo "Add 'deployer' to a supllementary/secondary group called 'sudo'"
sudo usermod -a -G sudo deployer

echo "Make sure sudoers can sudo without password by adding to sudoers"
sudo sed -i -r "s/%sudo\t*\s*ALL=\(ALL:ALL\)\t*\s*ALL/%sudo ALL=\(ALL:ALL\) NOPASSWD: ALL/" /etc/sudoers

echo "Add our list of keys so we can login as deployer"
sudo mkdir /home/deployer/.ssh
sudo cp ${PROVISION_FILES_PATH}/public_keys /home/deployer/.ssh/authorized_keys
sudo chown -R deployer:deployer /home/deployer/.ssh

echo "Disable root ssh access"
sudo sed -i "s/PermitRootLogin prohibit-password/PermitRootLogin no/" /etc/ssh/sshd_config
sudo service ssh restart

echo "Change owner of Nginx process"
sudo sed -i "s/www-data/deployer/" /etc/nginx/nginx.conf

echo "Change owner of PHP process"
sudo sed -i "s/www-data/deployer/" /etc/php/7.0/fpm/pool.d/www.conf

echo "Remove boilerplate site"
sudo rm /etc/nginx/sites-available/default
sudo rm /etc/nginx/sites-enabled/default

echo "Configure our server blocks"
sudo cp ${PROVISION_FILES_PATH}/api.nginx /etc/nginx/sites-available/api
sudo ln -s /etc/nginx/sites-available/api /etc/nginx/sites-enabled/
sudo sed -i -r "s/\{DOMAINS\}/$API_DOMAIN/" /etc/nginx/sites-available/api

echo "Create the path where the apps will live"
sudo mkdir "$APP_PATH" -p

if [ ${ENVIRONMENT} == 'local' ]
then
    echo "Local environment detected"
    echo "symlink our shared folders to where we are serving out of"
    sudo rm -rf ${APP_PATH}
    sudo ln -sfn /vagrant ${APP_PATH}
else
    echo "Production environment detected"
    echo "If we are production, setup a git-hook deploy process"
    sudo git init ${APP_PATH}
    sudo cp ${PROVISION_FILES_PATH}/git/config ${APP_PATH}/.git/config
    sudo cp ${PROVISION_FILES_PATH}/git/post-receive ${APP_PATH}/.git/hooks/post-receive
    sudo dos2unix ${APP_PATH}/.git/hooks/post-receive # because windoz

    echo "Ensure read/write permissions are sexy"
    sudo chown -R deployer:deployer "$APP_PATH"
    sudo chmod -R 755 "$APP_PATH"
fi

echo "Restart nginx and php services"
sudo service nginx restart
sudo service php7.0-fpm restart