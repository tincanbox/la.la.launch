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

function task_default() {
  return (C, done) => {
    // Do Your Default Things.
  }
}

function task_install() {
  return async (C, done) => {
    await docker('run', 'up', '-d', CONFIG.laradock.workspace, ...CONFIG.laradock.target);
    await docker('command', '')
    done();
  }
}

function task_launch() {
  return (C, done) => {
    docker('run', 'up', '-d', CONFIG.laradock.workspace, ...CONFIG.laradock.target)
      .then(done);
  }
}

function task_copy() {
  return async (C, done) => {
    W.copy('./build/laradock', './laradock')
      .then(done);
  }
}

function task_stop() {
  return (C, done) => {
    docker('run', 'stop')
      .then(done)
  }
}

function task_login() {
  return (C, done) => {
    docker('shell')
      .then(done);
  }
}

task('install', bind('series', task_copy(), task_install()));
task('launch', bind('series', task_launch()));
task('login', bind('series', task_login()));
task('default', bind('series', task_default()));
task('halt', bind('series', task_stop()));
task('copy', bind('series', task_copy()));
