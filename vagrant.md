
## Vagrant installation
If you want, you can use bundled Vagrant instead of installing app to your local machine.

1. Install [Vagrant](https://www.vagrantup.com/)
2. Copy `./vagrant/vagrant.yml.dist` to `./vagrant/vagrant.yml`
3. Create GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens)
4. Edit values as desired including adding the GitHub personal API token to `./vagrant/vagrant.yml`
5. Run:
```
vagrant plugin install vagrant-hostmanager
vagrant up
```
That`s all. After provision application will be accessible on http://calambur-shop.dev
