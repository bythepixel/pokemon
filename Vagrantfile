# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

require 'yaml'

# Load vagrant.yml if exists, if not, just return empty hash with hash as default
settings = File.exist?('vagrant.yml') ? YAML.load_file('vagrant.yml') : {}

Vagrant.configure(2) do |config|
  config.vm.box = "geerlingguy/ubuntu1604"

  config.vm.network "private_network", ip: "192.168.13.37"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end

  config.vm.provision "shell", path: "provisioning/provision.sh"

  if settings['sync_method'] == 'nfs'
    config.vm.synced_folder ".", "/vagrant", :nfs => true
  end

end