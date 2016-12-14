Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.hostname = "ubuntu"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.synced_folder "shared/", "/home/vagrant/shared"
  config.vm.synced_folder "project/", "/var/www/html/project"

  config.vm.provision :shell, path: "shared/bootstrap.sh"
  config.vm.provision :shell, path: "shared/install_codeigniter.sh"
end