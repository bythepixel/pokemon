# Provisioning

## Configuring Development Environment
- install vagrant
- install virtual box
- install composer
- clone repo
- copy `vagrant.yml.example` to `vagrant.yml`, ensure your sync method is supported by your OS
- navigate to project folder and run `vagrant up`

## Configuring Production Environments
- spin up an instance with ubuntu 16.04
- copy the provisioner folder to the instance: `scp -r provisioning [user]@[ipaddress]:~/provisioning`
- edit provision.sh and make sure the configuration at the top is correct
- ensure provision.sh has execute privileges (chmod 755)
- execute provisioner script: `./provision.sh`
- deploy a branch (see below)
- ensure .env is properly configured (`php artisan key:generate` to generate key)
- run database seed file (`php artisan db:seed`)

# Deploying to Staging or Production
- You will need your public key added to the deployer user in the environment you are trying to deploy to.
- To change what happens during the deploy process, check out out /git/post-receive.

## Add remotes
```
git remote add staging deployer@xx.xx.xx.xx:/srv/www
git remote add production deployer@xx.xx.xx.xx:/srv/www
```
## Deploy changes
```
git push <environment> <local-branch>:master
```