# Getting started with Xdebug in Docker

* create your custom `xdebug.ini` from `docker/xdebug/xdebug.ini.dist` updating `client_host` based on your system
* In PhpStorm enable `Run → Start listening for PHP debug connection`
* `docker-compose up apache-xdebug`
* if you want to debug supervisor script run `docker-compose stop supervisor && dc up supervisor-xdebug` (supervisor is started with apache it needs to be stopped first)
* if you want to debug cli cmd run it in container `cli-xdebug`
* note that if you have `Start listening for PHP debug connection` enabled, `create-ini.php` inside docker will get caught in debugger. `docker-compose` will be unresponsive until you Resume program in PhpStorm

PhpStorm should offer you to set up server (`Languages & FW → PHP → Servers`). You have to set up mapping from project root to `/var/www/html`. If it does not, you can add the server manually:

* Settings → Language & Frameworks → PHP → Servers
* add new server
  * name: connection (same as in env variable in `docker-compose.yml`)
  * Host: localhost
  * Port: 8700 (for https or 8800 for http)
  * Use path mappings
  * set Project Root to Absolute path `/var/www/html` on the server
  
Note you need to set up a server with mapping for every host and port combination (https `localhost:8800`, http`localhost:8700`and SAPI tests `connection-apache:80`). Without server and mapping your breakpoints in code won't work and you'll need to use `xdebug_break` in code instead. 

## Setting up XDEBUG for Linux
### Problem
Linux does not have a host.docker.internal which determines IP address of host. 
`docker-compose` command give container not static IP address and you have to change it
every time when `docker-compose` change it.

### Workaround
Create bridged docker newtork:
```
docker network create -d bridge --subnet 192.168.0.0/24 --gateway 192.168.0.1 docker-net
```
Now all containers have access to host on IP address 192.168.0.1.
Update xdebug.ini with:
```
xdebug.client_host=192.168.0.1
```

## Troubleshooting

Uncomment xdebug logging in `docker/xdebug/xdebug.ini`. 
