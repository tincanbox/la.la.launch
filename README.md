# La.Ra.Launch

This is really rough Laravel 8 Launcher with Laradock.

`volume/service` directory for default Laravel 8 implementation.

Uses `Laradock` as a base .env manager.  
ou can simply overrides .conf or .env files via `build/laradock/EACH_DIR`.


## Getting started

```
mkdir YOUR_PROJECT
cd YOUR_PROJECT
git clone https://github.com/tincanbox/la.ra.launch.git .
rm -rf .git
git init
```

Just pull this repo and call ./bin/install .
You dont need to call `docker-compose up` manually.

```
npm install
./bin/install.sh
```

## Structure

/volume directory is fully mounted to /var/www directory on the guest machine.

- build/ = 
- script/ = scripts for guest machine environment.
- service/ = Laravel itself


## Trouble shooting

### docker ERROR: readlink /var/lib/docker/overlay2/l: invalid argument

```
docker-compose down --rmi all
```
