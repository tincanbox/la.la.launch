# La.Ra.Launch

This is really rough and fragile Laravel 8 Launcher with Laradock.

`service` directory for default Laravel 8 implementation.
If you have working Laravel project, put it in `service` directory.

Uses `Laradock` as a base .env manager.  
You can simply overrides .conf or .env files via `build/laradock/EACH_DIR`.

- Laradock : https://github.com/laradock/laradock


## Getting started

Just pull this repo and call install command.  
You dont need to call `docker-compose up` manually.  
(Or use this as a template.)

```
mkdir YOUR_PROJECT
cd YOUR_PROJECT
git clone https://github.com/tincanbox/la.ra.launch.git .
rm -rf .git
git init
```

Then install node packages and Docker containers.

```
npm install
npx gulp install
```

If you are lucky, any problems wont bother you.

## Develop

### Gulp

- default = Nothing.
- install = Installs all dependencies.
- launch = Re-launch containers (halt then launch)
- login = NOT supported. But shows working command string.
- halt = Stops all containers.
- copy = Just copies `build` dir's contents.
- destroy = `halt` then let all containers down.


### Webpack

Just run npm command.

```
# Develop
cd service
npm run watch
```

## Structure

- build/ = Overrides for each layer.
- service/ = Laravel itself
- volume = Data directory for Laradock's containers.


## Translation Module

Simple and useful, legitimate implementation for Laravel. Thanks sir.

See: https://github.com/GENL/matice


## Trouble shooting

### docker ERROR: readlink /var/lib/docker/overlay2/l: invalid argument

Yaaay your containers have name-conflictions between them. Just reset all.

```
docker-compose down --rmi all
```
