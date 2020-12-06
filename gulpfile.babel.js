import { task } from 'gulp';
import * as W from './gulpfile.workspace.js';

const CONFIG = W.CONFIG;

// Fetchs command line arguments
// Also is used as webpack adaptor.
const argv = W.argv;
const docker = W.docker;
const bind = W.bind;

/*============================================================
 * Task Definitions.
 *============================================================
 */

function do_help() {
  return (C, done) => {
    // Do Your Default Things.
    console.log("help");
  }
}

function do_install() {
  return async (C, done) => {
    await docker('run', 'down');
    await docker('run', 'up', '-d', CONFIG.laradock.workspace, ...CONFIG.laradock.target);
    await docker('command', './service/build/bin/bootstrap')
    done();
  }
}

function do_launch() {
  return async (C, done) => {
    await docker('run', 'up', '-d', CONFIG.laradock.workspace, ...CONFIG.laradock.target)
    done();
  }
}

function do_fix_permission() {
  return async (C, done) => {
    await docker('command', 'chown', '-R', CONFIG.docker.user + ':' + CONFIG.docker.group, './' + CONFIG.service.build);
    await docker('command', 'chown', '-R', CONFIG.docker.user + ':' + CONFIG.docker.group, './service/storage');
    await docker('command', 'chmod', '-R', 'ug+x', './' + CONFIG.service.build);
    done();
  }
}

function do_copy() {
  return async (C, done) => {
    await W.copy(__dirname + '/build/laradock', __dirname + '/laradock');
    await W.copy(__dirname + '/build/service', __dirname + '/service');
    done();
  }
}

function do_stop() {
  return (C, done) => {
    docker('run', 'stop')
      .then(done)
  }
}

function do_destroy() {
  return async (C, done) => {
    await docker('run', 'stop');
    await docker('run', 'down');
    done();
  }
}

function do_login() {
  return (C, done) => {
    W.term('Direct shell login is ') + W.term.red('NOT SUPPORTED') + W.term('. Use command described below.\n');
    W.term.yellow(W.generate_docker_command('shell').join(' ') + '\n');
    done();
  }
}

task('default', bind('series', do_help()));
task('install', bind('series', do_copy(), do_launch(), do_fix_permission(), do_install()));
task('launch',  bind('series', do_copy(), do_launch(), do_fix_permission()));
task('login',   bind('series', do_login()));
task('halt',    bind('series', do_stop()));
task('copy',    bind('series', do_copy()));
task('destroy', bind('series', do_destroy()));
